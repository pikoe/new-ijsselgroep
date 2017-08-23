<?php namespace App\Models;

class Email extends Model {
	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		
		if(empty($this->token)) {
			$this->token = md5(rand() . 'Bla Bla');
		}
	}
}
