<form action="" method="post" class="contact-form">
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
		<input type="text" name="name" id="name" value="{{ request()->get('name') }}">
	</div>
	<div class="clearfix">
		<label for="email">E-mail</label>
		<input type="email" name="email" id="email" value="{{ request()->get('email') }}">
	</div>
	<div class="clearfix">
		<label for="to">Aan</label>
		<select name="to" id="to">
			<option value="info">Algemeen</option>
			<optgroup label="Leeftijdsgroepen">
				<option value="welpen">Welpen (7 - 11)</option>
				<option value="scouts">Scouts (11 - 15)</option>
				<option value="explorers">Explorers (15 - 18)</option>
				<option value="roverscouts">Roverscouts (18 - 21)</option>
			</optgroup>
			<option value="verhuur">Verhuur</option>
			<option value="bestuur">Bestuur</option>
			<option value="vrienden">Vrienden van</option>
			<option value="shop">Kleding</option>
		</select>
	</div>
	<div class="clearfix">
		<label for="subject">Onderwerp</label>
		<input type="text" name="subject" id="subject" value="{{ request()->get('subject') }}">
	</div>
	<div class="clearfix">
		<label for="message">Bericht</label>
		<textarea name="message" id="message">{{ request()->get('message') }}</textarea>
	</div>
	
	<div class="clearfix">
		<input type="hidden" name="{{ session()->get('contact-form-token-key') }}" value="{{ session()->get('contact-form-token-val') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<button class="button" title="Verzenden" name="contact-form" value="1">Verzenden</button>
	</div>
</form>