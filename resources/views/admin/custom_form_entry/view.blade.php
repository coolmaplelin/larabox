@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    {{ trans($entry->custom_form->name) }} <span class="text-lowercase">form entry</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">View</li>
	  </ol>
	</section>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">

			<!-- Default box -->
			@if ($crud->hasAccess('list'))
				<a href="{{ url($crud->route) }}?form_id={{ $entry->id }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span class="text-lowercase">{{ trans($entry->custom_form->name) }} form entries</span></a><br><br>
			@endif

			<div class="box">
		    	<div class="box-header with-border">
		    		<h3 class="box-title">Submitted at {{ date('d/m/Y H:i', strtotime($entry->created_at)) }} </h3>
		    	</div>

		    	<div class="box-body">
					@foreach ($form_fields as $FormField)
                        @php 
                            $nameSlug = str_slug($FormField['title']);
                        @endphp
                        <div class='form-group'>

                            <label @if ($FormField['manda'] == "1") class="required" @endif >
                                {{ $FormField['title'] }} 
                            </label>

                            @if ($FormField['type'] == 'text' || $FormField['type'] == 'email')
                                <input type='{{ $FormField['type'] }}' class='form-control' name='formentry[{{ $nameSlug }}]' @if ($FormField['manda'] == "1") required @endif value="{{ $FormField['value'] }}"/>
                            @elseif ($FormField['type'] == 'textbox')
                                <textarea type='text' class='form-control' name='formentry[{{ $nameSlug }}]' @if ($FormField['manda'] == "1") required @endif>{{ $FormField['value'] }}</textarea>
                            @elseif ($FormField['type'] == 'select' or $FormField['type'] == 'radio' or $FormField['type'] == 'checkbox')

                                @php 
                                    $options_array = explode("\n", $FormField['options']);
                                @endphp

                                @if ($FormField['type'] == 'select')
                                    <select class='form-control' name='formentry[{{ $nameSlug }}]' >
                                        <option></option>
                                        @for ($i = 0; $i < count($options_array); $i++)
                                            @php $valueSlug = str_slug($options_array[$i]); @endphp
                                            <option value="{{ $valueSlug }}" @if ($valueSlug == $FormField['value']) selected @endif >{{ $options_array[$i] }}</option>
                                        @endfor
                                    </select>

                                @elseif ($FormField['type'] == 'radio')
                                    @for ($i = 0; $i < count($options_array); $i++)
                                        @php $valueSlug = str_slug($options_array[$i]); @endphp
                                        <div class='radio'>
                                            <label><input type='radio' name='formentry[{{ $nameSlug }}]' value="{{ $valueSlug }}" @if ($FormField['manda'] == "1") required @endif @if ($valueSlug == $FormField['value']) checked @endif /> {{ $options_array[$i] }}</label>
                                        </div>
                                    @endfor
                                @else ($FormField['type'] == 'checkbox')
                                    <div class="checkbox-group @if ($FormField['manda'] == "1") required @endif">
                                        @php $valueArray = explode(',', $FormField['value']) @endphp
                                        @for ($i = 0; $i < count($options_array); $i++)
                                            @php $valueSlug = str_slug($options_array[$i]); @endphp
                                            @php $is_checked = in_array($valueSlug, $valueArray); @endphp
                                            <div class='checkbox'>
                                                <label><input type='checkbox' name='formentry[{{ $nameSlug }}][]' value="{{ $valueSlug }}" @if ($is_checked) checked @endif/> {{ $options_array[$i] }}</label>
                                            </div>
                                        @endfor
                                    </div>
                                @endif

                            @elseif ($FormField['type'] == 'image')
                                <br/>
                                @if ($FormField['value'])
                                    <a href="{{ $FormField['value'] }}" target="_blank"><img src="{{ $FormField['value'] }}" style="max-height: 100px;" /></a>
                                @else
                                    <p>No image uploaded</p>
                                @endif
                            @else
                                field is not valid!!!
                            @endif

                        </div>  
                          
                    @endforeach		    			
				</div>
		    </div>

		</div>
	</div>
@endsection


@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection


@section('after_scripts')
<script type="text/javascript">
$(function(){
    $(".form-group input").attr('disabled', 'disabled');
    $(".form-group select").attr('disabled', 'disabled');
    $(".form-group textarea").attr('disabled', 'disabled');
})
</script>
@endsection
