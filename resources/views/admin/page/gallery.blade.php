@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span >{{ ucfirst($crud->entity_name) }} gallery</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li><a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}" class="text-capitalize">{{ $entry->name }}</a></li>
	    <li class="active">Gallery</li>
	  </ol>
	</section>
@endsection