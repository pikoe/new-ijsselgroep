<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller {
	public function activeties(Request $request, $year = null, $month = null, $day = null) {
		$date = Carbon::createFromDate($year, $month, $day);
		return view('activeties', [
			'date' => $date->copy()->startOfMonth()->previous(Carbon::MONDAY),
			'start' => $date->copy()->startOfMonth(),
			'end' => $date->copy()->endOfMonth()
		]);
	}
}
