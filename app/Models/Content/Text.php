<?php namespace App\Models\Content;

use Illuminate\Http\Request;
use App\Models\PageContent;

class Text extends Model {
	public static function createDefault() {
		$text = new static();
		$text->text = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui';
		$text->save();
		return $text;
	}
	
	public function display() {
		return $this->text;
	}
	
	public function displayEdit(PageContent $pageContent) {
		return view('page-contents.text')->with([
			'text' => $this,
			'pageContent' => $pageContent
		]);
	}
	
	public function saveEdit(Request $request, PageContent $pageContent) {
		$this->text = $request->text;
		return $this->save();
	}
}
