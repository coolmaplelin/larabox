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


@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

			<!-- Default box -->
			@if ($crud->hasAccess('list'))
				<a href="{{ url($crud->route) }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span class="text-lowercase">{{ $crud->entity_name_plural }}</span></a><br><br>
			@endif

			<div class="box">
		    	<div class="box-header with-border">
		    		<h3 class="box-title">{{ trans($entry->title) }}</h3>
		    	</div>

		    	<div class="box-body">
		    		@include('inc.jquery_file_upload', ['entity_name' => $crud->entity_name, 'entity_id' => $id])	
				</div>
		    </div>

		</div>
	</div>
@endsection
