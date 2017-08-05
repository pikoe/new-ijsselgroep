<?php namespace App\Models\Content;

use Illuminate\Http\Request;
use App\Models\PageContent;

class Image extends Model {
	public static function createDefault() {
		$image = new static();
		$image->src = 'img/ijsselgroep-logo.png';
		$image->alt = 'IJsselgroep logo';
		$image->title = 'Scouting IJsselgroep';
		$image->save();
		return $image;
	}
	
	public function display() {
		return '<img src="' . $this->src . '" alt="' . $this->alt . '"' . ($this->title?' title="' . $this->title . '"':'') . '>';
	}
	
	public function displayEdit(PageContent $pageContent) {
		return view('page-contents.image')->with([
			'image' => $this,
			'pageContent' => $pageContent
		]);
	}
	public function saveEdit(Request $request, PageContent $pageContent) {
		if($request->image && $request->image->isValid()) {
			$extentension = strtolower($request->image->getClientOriginalExtension());
			$basename = basename(strtolower($request->image->getClientOriginalName()), '.' . $extentension);

			$this->src = 'upload/' . $basename . '.' . $extentension;
			$this->title = $this->alt = $basename;

			if($request->image->move(public_path('upload'), $basename . '.' . $extentension) && $this->save()) {
				return $this->toArray();
			}
		} else {
			return true;
		}
	}
	
	private $width = null;
	private $height = null;
	private $type = null;
	
	public function getSize() {
		list($this->width, $this->height, $this->type) = getimagesize(public_path($this->src));
	}
	public function getWidht() {
		if(!$this->width) {
			$this->getSize();
		}
		return $this->width;
	}
	public function getHeight() {
		if(!$this->height) {
			$this->getSize();
		}
		return $this->height;
	}
	
	function resize($w, $h, $crop = false) {
		$target = 'files/' . ($crop ? 'c-' : 'r-') . $w . 'x' . $h . '-' . basename($this->src);
		if(file_exists(public_path($target))) {
			return $target;
		}
		if(!$this->width) {
			$this->getSize();
		}
		$r = $this->width / $this->height;
		$width = $this->width;
		$height =  $this->height;
		if ($crop) {
			if ($this->width > $this->height) {
				$width = ceil($this->width-($this->width*abs($r-$w/$h)));
			} else {
				$height = ceil($this->height-($this->height*abs($r-$w/$h)));
			}
			$newwidth = $w;
			$newheight = $h;
		} else {
			if ($w/$h > $r) {
				$newwidth = $h*$r;
				$newheight = $h;
			} else {
				$newheight = $w/$r;
				$newwidth = $w;
			}
		}
		
		switch($this->type){
			case IMAGETYPE_JPEG:
				$src = imagecreatefromjpeg(public_path($this->src)); //jpeg file
				break;
			case IMAGETYPE_GIF:
				$src = imagecreatefromgif(public_path($this->src)); //gif file
				break;
			case IMAGETYPE_PNG:
				$src = imagecreatefrompng(public_path($this->src)); //png file
				break;
			default: 
				return false;
		}
		$dst = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		
		switch($this->type){
			case IMAGETYPE_JPEG:
				imagejpeg($dst, public_path($target)); //jpeg file
				break;
			case IMAGETYPE_GIF:
				imagegif($dst, public_path($target)); //gif file
				break;
			case IMAGETYPE_PNG:
				imagepng($dst, public_path($target)); //png file
				break;
		}
		
		return $target;
	}
}

// http://html5demos.com/dnd-upload
