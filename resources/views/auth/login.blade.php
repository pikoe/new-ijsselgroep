@extends('layouts.web')

@section('content')
<ul class="breadcrumbs clearfix">
	<li class="home"><a href="/">Home</a></li>
</ul>
<div class="page-block">
	<form method="POST" action="{{ url('/login') }}">
		<h1>Login</h1>
		@if($errors->any())
			<ul class="messages">
				@foreach ($errors->all() as $error)
					<li class="error">{{ $error }}</li>
				@endforeach
			</ul>
		@endif
		<div class="clearfix{{ $errors->has('email') ? ' has-error' : '' }}">
			<label for="email">E-mail</label>
			<input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
		</div>

		<div class="clearfix{{ $errors->has('password') ? ' has-error' : '' }}">
			<label for="password">Wachtwoord</label>
			<input id="password" type="password" name="password" required>
		</div>

		<div class="clearfix">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<button class="button" title="Verzenden" type="submit">Login</button>
			
			<a href="{{ url('/password/reset') }}">Wachtwoord vergeten?</a>
		</div>
	</form>
</div>
@endsection
