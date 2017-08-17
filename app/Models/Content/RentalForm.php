<?php namespace App\Models\Content;

/**
 * Description of ContactForm
 *
 * @author Dennis
 */
class RentalForm extends Model {
	public $id = 0;
	
	public static function createDefault() {
		return new static();
	}
	public static function find() {
		return new static();
	}
	
	public function display() {
		if(!session()->has('rental-form-token-key') || !session()->has('rental-form-token-val')) {
			session()->put('rental-form-token-key', uniqid() . md5(uniqid()));
			session()->put('rental-form-token-val', md5(uniqid()) . uniqid());
		}
		
		$send = null;
		if(request()->has('rental-form')) {
			if(request()->get(session()->get('rental-form-token-key')) == session()->get('rental-form-token-val')) {
				// post afhandelen
				$send = true;

				session()->put('rental-form-token-key', uniqid() . md5(uniqid()));
				session()->put('rental-form-token-val', md5(uniqid()) . uniqid());
			} else {
				sleep(1);
				$send = false;
			}
		}
		return view('page-contents-display.rental_form', [
			'rental_form' => $this,
			'send' => $send
		]);
	}
}
