<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class RentalController extends Controller {
	public function pdf() {
		$data = [];
		$pdf = PDF::loadView('rental-agreement', $data);
		return $pdf->download('rental-agreement.pdf');
	}
}
