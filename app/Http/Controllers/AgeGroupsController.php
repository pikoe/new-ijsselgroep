<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class AgeGroupsController extends Controller {
	public function welpen(Request $request, $year = null, $month = null, $day = null) {
		return view('welpen', [
			'date' => Carbon::now()->startOfMonth()->previous(Carbon::MONDAY),
			'start' => Carbon::now()->startOfMonth(),
			'end' => Carbon::now()->endOfMonth()
		]);
	}
}

