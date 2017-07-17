<?php namespace App\Models;

use Illuminate\Http\Request;

class PageContent extends Model {
	
	public static $contentModels = [
		'Text',
		'Image',
		'Map',
		'Calendar'
	];
	
	public function page() {
		return $this->belongsTo(Page::class);
	}
	
	public function getClassAttribute() {
        return '\\App\\Models\\Content\\' . $this->attributes['model'];
    }
	
	public function display() {
		return '<div class="content-block" id="content-' . $this->id . '" data-content="' . $this->model . '-' . $this->model_id . '">' . $this->class::find($this->model_id)->display() . '</div>';
	}
	
	public function displayEdit() {
		return $this->class::find($this->model_id)->displayEdit($this);
	}
	public function saveEdit(Request $request) {
		return $this->class::find($this->model_id)->saveEdit($request, $this);
	}
	
}
