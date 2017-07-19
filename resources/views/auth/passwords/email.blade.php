@extends('layouts.web')

@section('content')
<ul class="breadcrumbs clearfix">
	<li class="home"><a href="/">Home</a></li>
	<li><a href="login">Login</a></li>
</ul>
@if(session('status'))
	<div class="page-block">
		{{ session('status') }}
	</div>
@endif
<div class="page-block">
	<h1>Wachtwoord vergeten?</h1>
	<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
		{{ csrf_field() }}

		<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
			<label for="email" class="col-md-4 control-label">E-mailadres</label>

			<div class="col-md-6">
				<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

				@if ($errors->has('email'))
					<span class="help-block">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<button type="submit" class="btn btn-primary">Stuur wachtwoord reset link</button>
			</div>
		</div>
	</form>
</div>
@endsection
