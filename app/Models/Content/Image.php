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
}

// http://html5demos.com/dnd-upload
