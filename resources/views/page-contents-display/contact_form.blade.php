<form action="" method="post">
	
	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	{{ ($send === null ? '' : ($send ? 'Valide':'Foutief')) }}
	
	<div>
		<label for="name">Naam</label>
		<input type="text" name="name" id="name" value="{{ request()->get('name') }}">
	</div>
	<div>
		<label for="email">E-mail</label>
		<input type="email" name="email" id="email" value="{{ request()->get('email') }}">
	</div>
	<div>
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
	<div>
		<label for="subject">Onderwerp</label>
		<input type="text" name="subject" id="subject" value="{{ request()->get('subject') }}">
	</div>
	<div>
		<label for="message">Bericht</label>
		<textarea name="message" id="message">{{ request()->get('message') }}</textarea>
	</div>
	
	<div>
		<input type="hidden" name="{{ session()->get('contact-form-token-key') }}" value="{{ session()->get('contact-form-token-val') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<button class="button" title="Verzenden" name="contact-form" value="1">Verzenden</button>
	</div>
</form>