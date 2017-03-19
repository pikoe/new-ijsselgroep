@extends('layouts.admin')

@section('content')
<form class="form" method="post">
	<textarea class="editor" name="text">Hello, World!</textarea>

	{!! str_repeat('Content 123<br>', 10) !!}
</form>
@endsection