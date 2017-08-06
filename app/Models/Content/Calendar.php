<?php namespace App\Models\Content;

use Illuminate\Http\Request;
use App\Models\PageContent;
use App\Models\Event;
use App\Models\Group;
use App\Models\Location;
use Carbon\Carbon;

class Calendar extends Model {
	
	public function locations() {
		return $this->belongsToMany(Location::class);
	}
	
	public function groups() {
		return $this->belongsToMany(Group::class);
	}
	
	
	public static function createDefault() {
		$calendar = new static();
		$calendar->save();
		return $calendar;
	}
	
	public function display() {
		$locations = $this->locations()->allRelatedIds()->toArray();
		$groups = $this->groups()->allRelatedIds()->toArray();
		
		if(request()->has('kalender') && request()->kalender && preg_match('/\d{4}-\d{1,2}/', request()->kalender)) {
			$input = explode('-', request()->kalender);
			$date = Carbon::createFromDate($input[0], $input[1], null);
		} else {
			$date = Carbon::createFromDate(null, null, null);
		}
		$from = $date->copy()->startOfMonth()->previous(Carbon::SUNDAY)->addDay();
		$to = $date->copy()->endOfMonth()->next(Carbon::MONDAY);
		
		$events = Event::whereBetween('events.start', [$from, $to])
				->orWhereBetween('events.end', [$from, $to])
				->orWhereRaw('"' . $from->format('Y-m-d H:i:s') . '" BETWEEN `events`.`start` AND `events`.`end`')
				->orderBy('start', 'asc')
				->orderBy('end', 'desc')
				->groupBy('events.id');
		
		if(count($locations)) {
			$events->join('event_location', function($join) use ($locations) {
				$join->on('events.id', 'event_location.event_id')->whereIn('event_location.location_id', $locations);
			});
		}
		if(count($groups)) {
			$events->join('event_group', function($join) use ($groups) {
				$join->on('events.id', 'event_group.event_id')->whereIn('event_group.group_id', $groups);
			});
		}
		
		return view('page-contents-display.calendar', [
			'calendar' => $this,
			'events' => $events->select('events.*')->get(),
			
			'date' => $from,
			'start' => $date->copy()->startOfMonth(),
			'end' => $date->endOfMonth(),
		]);
	}
	
	public function displayEdit(PageContent $pageContent) {
		return view('page-contents.calendar')->with([
			'calendar' => $this,
			'pageContent' => $pageContent,
			
			'groups' => Group::orderBy('id'),
			'locations' => Location::orderBy('name')
		]);
	}
	public function saveEdit(Request $request, PageContent $pageContent) {
		if($this->save()) {
			$this->locations()->sync((array)$request->locations);
			$this->groups()->sync((array)$request->groups);
			return true;
		}
	}
}

// http://html5demos.com/dnd-upload
