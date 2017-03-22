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
		<div class="col-md-10 col-md-offset-1">

			<!-- Default box -->
			@if ($crud->hasAccess('list'))
				<a href="{{ url($crud->route) }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span class="text-lowercase">{{ $crud->entity_name_plural }}</span></a><br><br>
			@endif

			<div class="box">
		    	<div class="box-header with-border">
		    		<h3 class="box-title"></h3>
		    	</div>

		    	<div class="box-body">
					@foreach ($entry->form_fields as $FormField)
                        @php 
                            $nameSlug = str_slug($FormField['title']);
                        @endphp
                        <div class='form-group'>

                            <label @if ($FormField['manda'] == "1") class="required" @endif >
                                {{ $FormField['title'] }} 
                            </label>

                            @if ($FormField['type'] == 'text' || $FormField['type'] == 'email')
                                <input type='{{ $FormField['type'] }}' class='form-control' name='formentry[{{ $nameSlug }}]' @if ($FormField['manda'] == "1") required @endif/>
                            @elseif ($FormField['type'] == 'textbox')
                                <textarea type='text' class='form-control' name='formentry[{{ $nameSlug }}]' @if ($FormField['manda'] == "1") required @endif></textarea>
                            @elseif ($FormField['type'] == 'select' or $FormField['type'] == 'radio' or $FormField['type'] == 'checkbox')

                                @php 
                                    $options_array = explode("\n", $FormField['options']);
                                @endphp

                                @if ($FormField['type'] == 'select')
                                    <select class='form-control' name='formentry[{{ $nameSlug }}]' @if ($FormField['manda'] == "1") required @endif>
                                        @for ($i = 0; $i < count($options_array); $i++)
                                            @php $valueSlug = str_slug($options_array[$i]); @endphp
                                            <option value="{{ $valueSlug }}">{{ $options_array[$i] }}</option>
                                        @endfor
                                    </select>

                                @elseif ($FormField['type'] == 'radio')
                                    @for ($i = 0; $i < count($options_array); $i++)
                                        @php $valueSlug = str_slug($options_array[$i]); @endphp
                                        <div class='radio'>
                                            <label><input type='radio' name='formentry[{{ $nameSlug }}]' value="{{ $valueSlug }}" @if ($FormField['manda'] == "1") required @endif /> {{ $options_array[$i] }}</label>
                                        </div>
                                    @endfor
                                @else ($FormField['type'] == 'checkbox')
                                    <div id="testcheckbox" class="checkbox-group @if ($FormField['manda'] == "1") required @endif">
                                        @for ($i = 0; $i < count($options_array); $i++)
                                            @php $valueSlug = str_slug($options_array[$i]); @endphp
                                            <div class='checkbox'>
                                                <label><input type='checkbox' name='formentry[{{ $nameSlug }}][]' value="{{ $valueSlug }}"/> {{ $options_array[$i] }}</label>
                                            </div>
                                        @endfor
                                    </div>
                                @endif

                            @elseif ($FormField['type'] == 'image')
                                <br/><input type="file" name='{{ $nameSlug }}' accept="image/*">
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
