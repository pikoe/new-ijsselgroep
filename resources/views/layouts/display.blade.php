@extends('layouts.web')

@section('title', $page->name)
@section('description', $page->title . ' ' . $page->sub_title)

@section('content')
	@include('page-layouts/' . $page->layout)
@endsection