<a data-content-block-href="kalender={{ $start->copy()->subMonth()->format('Y-m') }}" href="{{ request()->url() }}?kalender={{ $start->copy()->subMonth()->format('Y-m') }}">Vorige maand</a>
<a data-content-block-href="kalender={{ $start->copy()->addMonth()->format('Y-m') }}" href="{{ request()->url() }}?kalender={{ $end->copy()->addMonth()->format('Y-m') }}">Volgende maand</a>
<table id="event-calendar-{{ $calendar->id }}" class="calendar">
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
					$monday = $date->copy()->next(\Carbon\Carbon::MONDAY);

					foreach($events as $key => $event) {

						if($event->start->eq($date)) {
							// is gestart, op 00:00:00
							$start = $date;
							$left = 0;
						} else if($event->start->lt($date)) {
							// is gestart voor deze dag
							if($date->dayOfWeek !== \Carbon\Carbon::MONDAY) {
								continue;
							}
							$start = $date;
							$left = 0;
						} else if($event->start->copy()->startOfDay()->eq($date)) {
							// start deze dag
							$start = $event->start;
							$left = $start->secondsSinceMidnight()/60/60/24*100;
						} else {
							break;
						}

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
						$rows[$event->row] = $event->end->copy();


						if($event->end->gt($monday)) {
							$width = $start->diffInSeconds($monday)/60/60/24*100;
						} else {
							$width = $start->diffInSeconds($event->end)/60/60/24*100;
							unset($events[$key]);
						}

						echo '<a href="#' . $event->id . '" class="event" style="top:' . (19*$event->row) . 'px;width:' . round($width, 2) . '%;left:' . round($left, 2) . '%;" data-event="' . $event->id . '" title="' . e($event->name) . '">' . e($event->name) . '<div class="text">' . $event->public_text . '</div></div>';
					}
				?>
			</td>
			@endfor
		</tr>
		@endwhile
	</tbody>
</table>

@section('javascript')
@parent
<script type="text/javascript">
	document.getElements('#event-calendar-{{ $calendar->id }} .event').addEvent('click', function(e) {
		e.preventDefault();
	});
</script>
@endsection