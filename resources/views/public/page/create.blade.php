@extends('layouts.app')

@section('pageTitle', 'Create Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        	<h1>Create A Page</h1>
        	{!! Form::model($Page, ['action' => 'PageController@store']) !!}

        		@include("inc.errors")

        		<div class="form-group">
			      	{!! Form::label('title', 'Title') !!}
			      	{!! Form::text('title', '', ['class' => 'form-control']) !!}
			    </div>

			    <div class="form-group">
			      	{!! Form::label('name', 'Name') !!}
			      	{!! Form::text('name', '', ['class' => 'form-control']) !!}
			    </div>

			    <div class="form-group">
			    	<div class="checkbox">
			    		<label>
			    			{!! Form::checkbox('is_live', '1') !!} Live
			    		</label>
			      		
			    	</div>
			      	
			    </div>

			    <div class="form-group">
			      	{!! Form::label('published_at', 'Published Date') !!}
			      	
			      	<div class="input-group date">
      					{!! Form::text('published_at', '', ['class' => 'form-control datepicker', 'data-date-format' => 'dd/mm/yyyy']) !!}
      					
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
			$('.datepicker').datepicker({
				'autoclose' : true
			}).on('changeDate', function(e) {
        		// `e` here contains the extra attributes
        		//console.log(e);
        		var year = e.date.getFullYear();
				var month = e.date.getMonth() + 1;
				var day = e.date.getDate();
				var value = year + '-' + (month > 9 ? month : ('0' + month)) +  '-' + (day > 9 ? day : ('0' + day)) ;

				$(this).val(value);
    		});
		});
	</script>
@endsection