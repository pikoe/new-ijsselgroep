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
		return '<img src="' . $this->src . '"  width="' . $this->getWidht() . '" height="' . $this->getHeight() . '" alt="' . $this->alt . '"' . ($this->title?' title="' . $this->title . '"':'') . '>';
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
		if(file_exists(public_path($this->src))) {
			list($this->width, $this->height, $this->type) = getimagesize(public_path($this->src));
		}
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
	
	function resize($w, $h, $crop = false, $stamps = null) {
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
		
		$dst = imagecreatetruecolor($newwidth, $newheight);
		switch($this->type){
			case IMAGETYPE_JPEG:
				$src = imagecreatefromjpeg(public_path($this->src)); //jpeg file
				break;
			case IMAGETYPE_PNG:
				$src = imagecreatefrompng(public_path($this->src)); //png file
				imagealphablending($dst, false);
				imagesavealpha($dst, true);
				break;
			case IMAGETYPE_GIF:
				$src = imagecreatefromgif(public_path($this->src)); //gif file
				imagealphablending($dst, false);
				imagesavealpha($dst, true);
				break;
			default: 
				return false;
		}
		imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		
		if(($stamps === null && ($w >= 600 || $h >= 600)) || $stamps) {
			if(in_array($this->type, [IMAGETYPE_PNG, IMAGETYPE_GIF])) {
				imagealphablending($dst, true);
			}
			// dan stempels erop
			$stamp_left = imagecreatefrompng(public_path('img/stamp-left.png'));
			imagecopy($dst, $stamp_left, 0, $newheight - 116, 0, 0, 141, 116);
			
			$stamp_right = imagecreatefrompng(public_path('img/stamp-right.png'));
			imagecopy($dst, $stamp_right, $newwidth - 155, $newheight - 179, 0, 0, 155, 179);
		}
		
		switch($this->type){
			case IMAGETYPE_JPEG:
				imagejpeg($dst, public_path($target . '.tmp'), 100); //jpeg file
				exec('jpegtran -copy none -optimize -progressive "' . public_path($target . '.tmp') . '" > "' . public_path($target) . '"');
				if(file_exists(public_path($target))) {
					unlink(public_path($target . '.tmp'));
				} else {
					rename(public_path($target . '.tmp'), public_path($target));
				}
				break;
			case IMAGETYPE_PNG:
				imagepng($dst, public_path($target), 0); //png file
				exec('optipng -o7 -strip all "' . public_path($target) . '"');
				break;
			case IMAGETYPE_GIF:
				imagegif($dst, public_path($target)); //gif file
				break;
		}
		chmod(public_path($target), 0666);
		
		return $target;
	}
}

// http://html5demos.com/dnd-upload
