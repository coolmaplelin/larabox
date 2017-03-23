@extends('layouts.app')

@section('pageTitle', ' - '. $CustomForm->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $CustomForm->name }}</div>

                <div class="panel-body">
                    {!! $CustomForm->instructions !!}

                    <form class="custom-form" action="{{ $CustomForm->getFullUrl() }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @foreach ($FormFields as $FormField)
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
                                        <div class="checkbox-group @if ($FormField['manda'] == "1") required @endif">
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

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('after_scripts')
    
<script type="text/javascript">
$(function(){
    $(".custom-form .btn-primary").click(function(event){
        
        var requiredNotValid = false;
        if ($('div.checkbox-group.required').length > 0) {
            if ($('div.checkbox-group.required :checkbox:checked').length > 0) {

            }else{
                requiredNotValid = true;
                alert('checkbox is required');
            }
        }

        var fileNotValid = false;
        $("input[type='file']").each(function(){
          if($(this).get(0).files.length > 0){ // only if a file is selected
            var fileSize = $(this).get(0).files[0].size;
            if (fileSize > 2097152) {
                fileNotValid = true;
                alert('File must be less than 2mb.');
            }
          }
        });

        if (requiredNotValid || fileNotValid) {
            event.preventDefault();
        }
    });
})
</script>

@endsection