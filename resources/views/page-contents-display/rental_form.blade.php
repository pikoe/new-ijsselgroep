<form action="" method="post">
	
	{{ ($send === null ? '' : ($send ? 'Valide':'Foutief')) }}
	
	<div>
		<input type="hidden" name="{{ session()->get('contact-form-token-key') }}" value="{{ session()->get('contact-form-token-val') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<button class="button" title="Verzenden" name="contact-form" value="1">Verzenden</button>
	</div>
</form>