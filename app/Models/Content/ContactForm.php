<?php namespace App\Models\Content;

use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;

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
	
	private function domain_exists($email, $record = 'MX'){
		list($user, $domain) = explode('@', $email);
		return checkdnsrr($domain, $record);
	}

	public function display() {
		if(!session()->has('contact-form-token-key') || !session()->has('contact-form-token-val')) {
			session()->put('contact-form-token-key', uniqid() . md5(uniqid()));
			session()->put('contact-form-token-val', md5(uniqid()) . uniqid());
		}
		
		$tos = [
			'info' => 'info@scouting-ijsselgroep.nl',
			'welpen' => 'welpen@scouting-ijsselgroep.nl',
			'scouts' => 'scouts@scouting-ijsselgroep.nl',
			'explorers' => 'explorers@scouting-ijsselgroep.nl',
			'roverscouts' => 'info@scouting-ijsselgroep.nl',
			'verhuur' => 'verhuur@scouting-ijsselgroep.nl',
			'bestuur' => 'bestuur@scouting-ijsselgroep.nl',
			'vrienden' => 'info@scouting-ijsselgroep.nl',
			'shop' => 'info@scouting-ijsselgroep.nl'
		];
		$tos = [
			'info' => 'dennis_veeneman@hotmail.com',
			'welpen' => 'dennis_veeneman@hotmail.com',
			'scouts' => 'dennis_veeneman@hotmail.com',
			'explorers' => 'dennis_veeneman@hotmail.com',
			'roverscouts' => 'dennis_veeneman@hotmail.com',
			'verhuur' => 'dennis_veeneman@hotmail.com',
			'bestuur' => 'dennis_veeneman@hotmail.com',
			'vrienden' => 'dennis_veeneman@hotmail.com',
			'shop' => 'dennis_veeneman@hotmail.com'
		];
		
		$send = null;
		$errors = new MessageBag;
		if(request()->has('contact-form')) {
			if(request()->get(session()->get('contact-form-token-key')) == session()->get('contact-form-token-val')) {
				// post afhandelen
				$validator = Validator::make(request()->all(), [
					'name' => 'required|min:3|max:255',
					'email' => 'required|email',
					'to' => [
						'required',
						Rule::in(array_keys($tos))
					],
					'subject' => 'required|min:3|max:255',
					'message' => 'required|min:3'
				]);
				$validator->setAttributeNames([
					'name' => 'Naam',
					'email' => 'E-mail',
					'to' => 'Aan',
					'subject' => 'Onderwerp',
					'message' => 'Bericht'
				]);
				if($validator->fails()) {
					$errors = $validator->errors();
				} else if(!$this->domain_exists(request()->email)) {
					$errors->add('email', 'Het opgegeven e-mail adres lijkt niet te bestaan.');
				} else {
					$send = true;
					
					// TODO verzenden
				}

				session()->put('contact-form-token-key', uniqid() . md5(uniqid()));
				session()->put('contact-form-token-val', md5(uniqid()) . uniqid());
			} else {
				sleep(1);
				$errors->add('_token', 'Formulier lijkt al te zijn verzonden, in een ander tabblad bijvoorbeeld. Klik eventueel nogmaals op versturen.');
			}
		}
		return view('page-contents-display.contact_form', [
			'contact_form' => $this,
			'send' => $send,
			'errors' => $errors
		]);
	}
}
