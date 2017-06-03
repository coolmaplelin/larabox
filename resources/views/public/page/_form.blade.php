{{ Form::model($Page, ['route' => [$route_name, $Page->id]])}}

	@include("inc.errors")

	@if ($route_name == 'page.update')
		{{ Form::hidden('id', $Page->id) }}
	@endif

	<div class="form-group">
      	{{ Form::label('title', 'Title') }}
      	{{ Form::text('title', old('title', $Page->title) , ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
      	{{ Form::label('name', 'Name') }}
      	{{ Form::text('name', old('name', $Page->name), ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
    	<div class="checkbox">
    		<label>
    			{{ Form::checkbox('is_live', "1") }} Live
    		</label>
      		
    	</div>
      	
    </div>

    <div class="form-group">
      	{{ Form::label('published_at', 'Published Date') }}
      	
      	<div class="input-group date">
				{{ Form::text('published_at', old('name', $Page->published_at), ['class' => 'form-control datepicker', 'data-date-format' => 'dd/mm/yyyy']) }}
				
				<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
    </div>

    <button class="btn btn-success" type="submit">Submit</button>
{{ Form::close() }}
        


@push('page_form_styles')
	<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datepicker/datepicker3.css') }}">
@endpush

@push('page_form_scripts')
	<script src="{{ asset('vendor/adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
	<script>
		$(function() {
			$('.datepicker').datepicker({
				'autoclose' : true
			});
		});
	</script>
@endpush