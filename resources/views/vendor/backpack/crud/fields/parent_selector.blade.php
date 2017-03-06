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
    <span class="form-control-clear glyphicon glyphicon-remove form-control-feedback" title="Remove Parent"></span>

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

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        {{-- YOUR CSS HERE --}}
        <!-- Bootstrap Tree -->
        <link rel="stylesheet" href="{{ asset('js/bootstrap-treeview/bootstrap-treeview.css') }}">
        <style>
          .form-group.has-clear .form-control-clear {
            z-index: 10;
            pointer-events: auto;
            cursor: pointer;
            top: 25px;
            right: 15px; 
          }
        </style>
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        {{-- YOUR JS HERE --}}
        <!-- Bootstrap Tree -->
        <script src="{{ asset('js/bootstrap-treeview/bootstrap-treeview.js') }}"></script>
        <script>
            jQuery(document).ready(function($) {

              $('.form-control-clear').click(function() {
                $(this).siblings('input[type="hidden"]').val('');
                  $(this).siblings('input[type="text"]').val('').trigger('propertychange').focus();
              });

              $('.parent-selector').each(function(){

                var $this = $(this);

                $.get( $this.data('srcurl'), function( result ) {
                    //console.log(data);
                    var treedata = result.data;
                    var objnames = result.objnames;

                    $this.treeview({data: treedata });
                    $this.treeview('collapseAll', { silent: true });
                    //$('.pagetree').treeview('disableNode', [ 1, { silent: true } ]);

                    var selected_value = $this.data('selected-value');
                    //console.log(nodemap[selected_value]);
                    $this.parent().find('.selected-text').val(objnames[selected_value]);

                    $this.on('nodeSelected', function(event, data) {
                      //console.log(data.id);
                      $this.parent().find('.selected-value').val(data.id);
                      $this.parent().find('.selected-text').val(data.text);
                  });
                });
              })

            });
        </script>


    @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}