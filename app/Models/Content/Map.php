<?php namespace App\Models\Content;

use Illuminate\Http\Request;
use App\Models\PageContent;

class Map extends Model {
	public static function createDefault() {
		$map = new static();
		$map->lat = 52.199797;
		$map->lng = 6.215269;
		$map->zoom = 12;
		$map->label = 'Locatie';
		$map->save();
		return $map;
	}
	
	public function display() {
		return view('page-contents-display.map', [
			'map' => $this
		]);
	}
	
	public function displayEdit(PageContent $pageContent) {
		return view('page-contents.map')->with([
			'map' => $this,
			'pageContent' => $pageContent
		]);
	}
	
	public function saveEdit(Request $request, PageContent $pageContent) {
		if($this->save()) {
			return $this->displayEdit($pageContent);
		}
	}
}
