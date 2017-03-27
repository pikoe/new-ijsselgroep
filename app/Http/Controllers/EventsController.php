<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;

class EventsController extends Controller {
	public function index(Request $request, $year = null, $month = null, $day = null) {
		$date = Carbon::createFromDate($year, $month, $day);
		
		$from = $date->copy()->startOfMonth()->previous(Carbon::SUNDAY)->addDay();
		$to = $date->copy()->endOfMonth()->next(Carbon::MONDAY)->subDay();
		
		$events = Event::whereBetween('start', [$from, $to])
				->orWhereBetween('end', [$from, $to])
				->orWhereRaw('"' . $from->format('Y-m-d H:i:s') . '" BETWEEN `start` AND `end`')
				->orderBy('start')
				->get();
		
		return view('events.index', [
			'date' => $from,
			'start' => $date->copy()->startOfMonth(),
			'end' => $date->copy()->endOfMonth(),
			'events' => $events,
			'started' => [],
			'ended' => []
		]);
	}
	
	public function add() {
		
	}
}
