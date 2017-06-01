@extends('layouts.app')

@section('pageTitle', 'Create Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        	{!! Form::model($Page, ['action' => 'PageController@create']) !!}

        		<div class="form-group">
			      	{!! Form::label('title', 'Title') !!}
			      	{!! Form::text('title', '', ['class' => 'form-control']) !!}
			    </div>

			    <div class="form-group">
			      	{!! Form::label('is_live', 'Live') !!}
			      	{!! Form::radio('is_live', 'value', true) !!}
			    </div>

			    <div class="form-group">
			      	{!! Form::label('published_at', 'Published Date') !!}
			      	
			      	<div class="input-group date">
      					{!! Form::text('published_at', '', ['class' => 'form-control datepicker']) !!}
      					
      					<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
    				</div>
			    </div>

			    <button class="btn btn-success" type="submit">Submit</button>
			{!! Form::close() !!}
        </div>
    </div>
</div>
@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datepicker/datepicker3.css') }}">
@endsection

@section('after_scripts')
	<script src="{{ asset('vendor/adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
	<script>
		$(function() {
			$('.datepicker').datepicker();
		});
	</script>
@endsection