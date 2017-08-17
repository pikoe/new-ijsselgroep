<?php namespace App\Models\Content;

/**
 * Description of ContactForm
 *
 * @author Dennis
 */
class ContactForm extends Model {
	public $id = 0;
	
	public static function createDefault() {
		return new static();
	}
	public static function find() {
		return new static();
	}
	
	public function display() {
		if(!session()->has('contact-form-token-key') || !session()->has('contact-form-token-val')) {
			session()->put('contact-form-token-key', uniqid() . md5(uniqid()));
			session()->put('contact-form-token-val', md5(uniqid()) . uniqid());
		}
		
		$send = null;
		if(request()->has('contact-form')) {
			if(request()->get(session()->get('contact-form-token-key')) == session()->get('contact-form-token-val')) {
				// post afhandelen
				$send = true;

				session()->put('contact-form-token-key', uniqid() . md5(uniqid()));
				session()->put('contact-form-token-val', md5(uniqid()) . uniqid());
			} else {
				sleep(1);
				$send = false;
			}
		}
		return view('page-contents-display.contact_form', [
			'contact_form' => $this,
			'send' => $send
		]);
	}
}
