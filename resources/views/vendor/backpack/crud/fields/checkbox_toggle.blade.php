<!-- checkbox toggle field -->

<div @include('crud::inc.field_wrapper_attributes') >
    @include('crud::inc.field_translatable_icon')
    <div class="checkbox">
      <span><b>{!! $field['label'] !!}</b>&nbsp;&nbsp;</span>
    	<label>
    	  <input type="hidden" name="{{ $field['name'] }}" value="0">
    	  <input type="checkbox" data-toggle="toggle" data-onstyle="success" value="1"

          name="{{ $field['name'] }}"

          @if (isset($field['value']))
            @if( ((int) $field['value'] == 1 || old($field['name']) == 1) && old($field['name']) !== '0' )
             checked="checked"
            @endif
          @elseif (isset($field['default']) && $field['default'])
            checked="checked"
          @endif

          @if (isset($field['attributes']))
              @foreach ($field['attributes'] as $attribute => $value)
    			{{ $attribute }}="{{ $value }}"
        	  @endforeach
          @endif
          > 
    	</label>

        {{-- HINT --}}
        @if (isset($field['hint']))
            <p class="help-block">{!! $field['hint'] !!}</p>
        @endif
    </div>
</div>


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        {{-- YOUR CSS HERE --}}
        <!-- Bootstrap Toggle -->
        <link rel="stylesheet" href="{{ asset('js/bootstrap-toggle/bootstrap-toggle.min.css') }}">
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        {{-- YOUR JS HERE --}}
        <!-- Bootstrap Toggle -->
        <script src="{{ asset('js/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
    @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}