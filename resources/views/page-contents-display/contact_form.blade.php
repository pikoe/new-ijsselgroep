<form action="" method="post" data-form="contact-form">
	<h2 class="icon mail">Contact formulier</h2>
	@if($errors->any())
		<ul class="messages">
			@foreach ($errors->all() as $error)
				<li class="error">{{ $error }}</li>
			@endforeach
		</ul>
	@endif
	@if($send === true)
		<ul class="messages">
			<li class="success">Het formulier is verzonden. We sturen je zo snel mogelijk een reactie.</li>
		</ul>
	@endif
	
	<div class="clearfix">
		<label for="name">Naam</label>
		<input type="text" name="name" id="name" value="{{ request()->get('name') }}" required>
	</div>
	<div class="clearfix">
		<label for="email">E-mail</label>
		<input type="email" name="email" id="email" value="{{ request()->get('email') }}" required>
	</div>
	<div class="clearfix">
		<label for="to">Aan</label>
		<select name="to" id="to" required>
			<option value="">Maak een keuze</option>
			<option value="info"{{ request()->get('to')=='info'?' selected':'' }}>Algemeen</option>
			<optgroup label="Leeftijdsgroepen">
				<option value="welpen"{{ request()->get('to')=='welpen'?' selected':'' }}>Welpen (7 - 11)</option>
				<option value="scouts"{{ request()->get('to')=='scouts'?' selected':'' }}>Scouts (11 - 15)</option>
				<option value="explorers"{{ request()->get('to')=='explorers'?' selected':'' }}>Explorers (15 - 18)</option>
				<option value="roverscouts"{{ request()->get('to')=='roverscouts'?' selected':'' }}>Roverscouts (18 - 21)</option>
			</optgroup>
			<option value="verhuur"{{ request()->get('to')=='verhuur'?' selected':'' }}>Verhuur</option>
			<option value="bestuur"{{ request()->get('to')=='bestuur'?' selected':'' }}>Bestuur</option>
			<option value="vrienden"{{ request()->get('to')=='vrienden'?' selected':'' }}>Vrienden van</option>
			<option value="shop"{{ request()->get('to')=='shop'?' selected':'' }}>Kleding</option>
		</select>
	</div>
	<div class="clearfix">
		<label for="subject">Onderwerp</label>
		<input type="text" name="subject" id="subject" value="{{ request()->get('subject') }}" required>
	</div>
	<div class="clearfix">
		<label for="message">Bericht</label>
		<textarea name="message" id="message" required>{{ request()->get('message') }}</textarea>
	</div>
	
	<div class="clearfix">
		<input type="hidden" name="{{ session()->get('contact-form-token-key') }}" value="{{ session()->get('contact-form-token-val') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<button class="button" title="Verzenden" name="contact-form" value="1">Verzenden</button>
	</div>
</form>