<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends Controller {
	public function logo($email, $token) {
		if($email->token == $token && $email->read_at == null) {
			$email->read_at = \Carbon\Carbon::now();
			$email->save();
		}
		
		$headers = [
			'Content-Type' => 'image/png',
        ];
		return response()->download(public_path('img/ijsselgroep-logo.png'), 'ijsselgroep-logo.png', $headers);
	}
}
