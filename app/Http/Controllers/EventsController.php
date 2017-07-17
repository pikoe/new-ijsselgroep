<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Location;
use App\Models\Group;

class EventsController extends Controller {
	public function index(Request $request, $year = null, $month = null, $day = 1) {
		$date = Carbon::createFromDate($year, $month, $day);
		
		$from = $date->copy()->startOfMonth()->previous(Carbon::SUNDAY)->addDay();
		$to = $date->copy()->endOfMonth()->next(Carbon::MONDAY);
		
		$events = Event::whereBetween('start', [$from, $to])
				->orWhereBetween('end', [$from, $to])
				->orWhereRaw('"' . $from->format('Y-m-d H:i:s') . '" BETWEEN `start` AND `end`')
				->orderBy('start', 'asc')
				->orderBy('end', 'desc')
				->get();
		
		return view('events.index', [
			'events' => $events,
			
			'date' => $from,
			'start' => $date->copy()->startOfMonth(),
			'end' => $date->endOfMonth()
		]);
	}
	
	public function add(Request $request, $start = null, $end = null) {
		if($request->isMethod('post')) {
			$event = new Event;
			$event->name = $request->name;
			$event->start = Carbon::createFromFormat('d-m-Y H:i:s', $request->start . ':00');
			$event->end = Carbon::createFromFormat('d-m-Y H:i:s', $request->end . ':00');
			if($event->start->addMinutes(15)->gt($event->end)){
				return redirect()->back()->withInput()->withErrors(['Zorg dat het eind minimaal 15 minuten na de start is']);
			}
			if($event->save()) {
				$event->locations()->attach((array)$request->locations);
				$event->groups()->attach((array)$request->groups);
				
				return redirect()->route('events.index', [$event->start->year, $event->start->format('m')]);
			}
			
		}
		
		if($start) {
			$start = Carbon::createFromFormat('Y-m-d', $start);
		} else {
			$start = Carbon::today();
		}
		if($end) {
			$end = Carbon::createFromFormat('Y-m-d', $end);
		} else {
			$end = Carbon::today()->addDay();
		}
		if($end->lt($start)) {
			$date = $start;
			$start = $end;
			$end = $date;
		}
		
		return view('events.add', [
			'start' => $start,
			'end' => $end,
			'groups' => Group::orderBy('id'),
			'locations' => Location::orderBy('name')
		]);
	}
	
	public function edit(Request $request, Event $event) {
		if($request->isMethod('post')) {
			$event->name = $request->name;
			$event->start = Carbon::createFromFormat('d-m-Y H:i:s', $request->start . ':00');
			$event->end = Carbon::createFromFormat('d-m-Y H:i:s', $request->end . ':00');
			if($event->start->addMinutes(15)->gt($event->end)){
				return redirect()->back()->withInput()->withErrors(['Zorg dat het eind minimaal 15 minuten na de start is']);
			}
			if($event->save()) {
				$event->locations()->sync((array)$request->locations);
				$event->groups()->sync((array)$request->groups);
				
				return redirect()->route('events.index', [$event->start->year, $event->start->format('m')]);
			}
		}
		
		return view('events.edit', [
			'event' => $event,
			'groups' => Group::orderBy('id'),
			'locations' => Location::orderBy('name')
		]);
	}
	
	public function delete(Event $event) {
		if($event->delete()) {
			return [true];
		} else {
			return [false];
		}
	}
}
