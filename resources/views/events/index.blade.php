@extends('layouts.admin')

@section('content')
<div class="form">
	<div class="toolbar clearfix">
		<h2>Kalender {{ $start->formatLocalized('%B %Y') }}</h2>
		<div class="buttons">
			<a class="button add" href="{{ route('events.add') }}"><i class="fa fa-plus" aria-hidden="true"></i> Toevoegen</a>
		</div>
	</div>
	<a href="{{ route('events.index', [$date->copy()->subDay()->year, $date->copy()->subDay()->format('m')]) }}" class="button previous"><i class="fa fa-angle-double-left"></i> Previous month</a>
	<a href="{{ route('events.index') }}" class="button now"><i class="fa fa-calendar-o"></i> This month</a>
	<a href="{{ route('events.index', [$end->copy()->addDay()->year, $end->copy()->addDay()->format('m')]) }}" class="button next">Next month <i class="fa fa-angle-double-right"></i></a>
			
	<table id="event-calendar" class="calendar">
		<thead>
			<tr>
				<th class="week" title="Weeknummer">&nbsp;</th>
				<th title="Maandag">Ma<span>andag</span></th>
				<th title="Dinsdag">Di<span>nsdag</span></th>
				<th title="Woensdag">Wo<span>endag</span></th>
				<th title="Donderdag">Do<span>nderdag</span></th>
				<th title="Vrijdag">Vr<span>ijdag</span></th>
				<th title="Zaterdag">Za<span>terdag</span></th>
				<th title="Zondag">Zo<span>ndag</span></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$rows = [];
				$row = 0;
			?>
			@while($date->lte($end))
			<tr>
				<th class="week-number" title="Week {{ $date->weekOfYear }}">{{ $date->weekOfYear }}</th>
				@for($w = $date->weekOfYear; $w == $date->weekOfYear; $date->addDay())
				<td class="day" data-date="{{ $date->format('Y-m-d') }}">
					@if($date->day == 1)
						<div class="start-of-month">{{ $date->formatLocalized('%b') }}</div>
					@elseif($date->daysInMonth == $date->day)
						<div class="end-of-month">{{ $date->formatLocalized('%b') }}</div>
					@endif
					<div class="day">{{ $date->day }}</div>
					<?php
						foreach($events as $key => $event) {
							if($event->start->copy()->startOfDay()->lte($date)) {
								if($event->start->lte($date)) {
									foreach($rows as $row => $available) {
										if($available->lte($event->start)) {
											$event->row = $row;
											unset($rows[$row]);
											break;
										}
									}
									if($event->row == null) {
										$event->row = ++$row;
									}
								}
								$started[] = $event;
								
								unset($events[$key]);
							} else {
								break;
							}
						}
						foreach($started as $key => $event) {
							if($event->end->copy()->startOfDay()->addDay()->lte($date)) {
								$rows[$event->row] = $event->end->copy();
								$ended[] = $event;
								unset($started[$key]);
							} else {
								$pos = '';
								$width = 100;
								if($event->start->format('His') !== '000000' && $event->start->copy()->startOfDay()->eq($date)) {
									$left = $event->start->secondsSinceMidnight()/60/60/24*100;
									$width -= $left;
									$pos .= 'left:' . round($left, 2) . '%;';
									if($event->row == null) {
										foreach($rows as $row => $available) {
											if($available->lte($event->start)) {
												$event->row = $row;
												unset($rows[$row]);
												break;
											}
										}
										if($event->row == null) {
											$event->row = ++$row;
										}
									}
								}
								if($event->end->format('His') !== '000000' && $event->end->copy()->startOfDay()->eq($date)) {
									$right = $event->end->secondsUntilEndOfDay()/60/60/24*100;
									$width -= $right;
									
									$ended[] = $event;
									unset($started[$key]);
									$rowAssigned = false;
									foreach($started as $startingEvent) {
										if($startingEvent->row == null && $startingEvent->start->secondsUntilEndOfDay()/60/60/24*100 <= $right) {
											$startingEvent->row = $event->row;
											$rowAssigned = true;
											break;
										}
									}
									if(!$rowAssigned) {
										$rows[$event->row] = $event->end->copy();
									}
								}
								echo '<a href="' . route('events.edit', $event->id) . '" class="event" style="top:' . (19*$event->row) . 'px;width:' . round($width, 2) . '%;' . $pos . '" data-event="' . $event->id . '" title="' . e($event->name) . '">' . e($event->name) . '</div>';
							}
						}
					?>
				</td>
				@endfor
			</tr>
			@endwhile
		</tbody>
	</table>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
	var drag = {
		start: null,
		move: null,
		dates: {
			start: null,
			move: null
		}
	};
	
	document.id('event-calendar').addEvents({
		'mouseenter:relay(.event)': function() {
			document.getElements('#event-calendar .event[data-event=' + this.getProperty('data-event') + ']').addClass('hover');
		},
		'mouseleave:relay(.event)': function() {
			document.getElements('#event-calendar .event.hover').removeClass('hover');
		},
		'mousedown:relay(td.day)': function(e) {
			if(e.target.nodeName.toLowerCase() !== 'a') {
				drag.start = this;
				drag.dates.start = this.getProperty('data-date');
			}
		},
		'mousemove:relay(td.day)': function() {
			if(drag.start && drag.move !== this) {
				drag.move = this;
				drag.dates.move = this.getProperty('data-date');
				var found = false;
				document.getElements('#event-calendar td.day').each(function(td) {
					if(!found && td !== drag.start && td !== drag.move) {
						td.removeClass('selected');
					} else if(td === drag.start && td !== drag.move) {
						found = !found;
						td.addClass('selected');
					} else if(td === drag.move && td !== drag.start) {
						found = !found;
						td.addClass('selected');
					} else if(td === drag.move && td === drag.start) {
						td.addClass('selected');
					} else if(found) {
						td.addClass('selected');
					}
				});
			}
		}
	});
	document.addEvent('mouseup', function() {
		if(drag.start && drag.move) {
			new Confirm('Wilt een nieuwe activiteit in de kalender plaatsen?', function() {
				if(drag.dates.move < drag.dates.start) {
					location.href = '{{ route('events.add') }}/' + drag.dates.move + '/' + drag.dates.start;
				} else {
					location.href = '{{ route('events.add') }}/' + drag.dates.start + '/' + drag.dates.move;
				}
			}, function() {
				document.getElements('#event-calendar td.day.selected').removeClass('selected');
			});
		}
		drag.start = null;
		drag.move = null;
	});
</script>
@endsection
