<!-- form fields panel -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <textarea class="hidden customformme"
      name="{{ $field['name'] }}"
        @include('crud::inc.field_attributes')

      >{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}</textarea>

    <div class="nav-panel">
        <ul id="nav-container" class=""></ul>
        <a href="#" class="btn btn-primary ladda-button clearfix" style="float:left" onClick="openFormFieldEditor(); return false">
            <span class="ladda-label"><i class="fa fa-plus"></i> Add Another</span>
        </a>
        <div class="clearfix"></div>
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

<!-- Modal -->
<div id="formElementEditor" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Form Element</h4>
            </div>
            <div class="modal-body row">
                <input type="hidden" class="nav_id" name="nav_id"/>
                <div class="form-group col-md-6">
                    <label>Title</label>
                    <input type="text" class="form-control title" name="title"/>
                </div>
                <div class="form-group col-md-6">
                    <label>Type</label>
                    <select class="form-control type" name="type">
                        <option value='text'>Text</option>
                        <option value='textbox'>Text box</option>
                        <option value='email'>Email</option>
                        <option value='select'>Select box</option>
                        <option value='radio'>Radio buttons</option>
                        <option value='checkbox'>Checkbox</option>
                        <option value='image'>Image file</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Mandatory</label>
                    <select class="form-control manda" name="manda">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Active</label>
                    <select class="form-control active" name="active">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Options</label>
                    <textarea class="form-control options" name="options"></textarea>
                    <p class="help-block">New line per option.</p>
                </div>
                
                <div class="form-group col-md-12">
                    <label>Help Text</label>
                    <textarea class="form-control help" name="help"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-save">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        {{-- YOUR CSS HERE --}}
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        {{-- YOUR JS HERE --}}
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="{{ asset('js/custom-form.js') }}"></script>
    @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}