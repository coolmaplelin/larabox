<!-- pagetree for parent selector -->

<div @include('crud::inc.field_wrapper_attributes') >
    @include('crud::inc.field_translatable_icon')
    <label>{!! $field['label'] !!}</label>
    
    <input class="selected-value" 
      type="hidden" 
      name="{{ $field['name'] }}" 
      value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
      >
    <input type="text" disabled class="form-control selected-text">
    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
    <div id="parent-selector" class="parent-selector"

      data-selected-value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
      @if (isset($field['data_source']))
        data-srcurl = "{{ $field['data_source'] }}"
      @endif
      ></div>
   
</div>

