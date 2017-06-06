<!-- resources/views/vendor/backpack/crud/filters/text.blade.php -->

<li filter-name="{{ $filter->name }}"
    filter-type="{{ $filter->type }}"
    class=" {{ Request::get($filter->name)?'active':'' }}">
    <span style="display: inline-block;color:#777">{{ $filter->label }}</span>
    <input type="text" name="{{ $filter->name }}" value="{{ $filter->currentValue }}" style="width: 150px;" />
</li>

@push('crud_list_scripts')
<script>
    jQuery(document).ready(function($) {
        $("input[name={{ $filter->name }}]").keyup(function(e) {
            if(e.keyCode == 13){
                e.preventDefault();
                var value = $(this).val();
                var parameter = '{{ $filter->name }}';
                @if (!$crud->ajaxTable())
                // behaviour for normal table
                var current_url = normalizeAmpersand("{{ Request::fullUrl() }}");
                var new_url = addOrUpdateUriParameter(current_url, parameter, value);
                // refresh the page to the new_url
                new_url = normalizeAmpersand(new_url.toString());
                window.location.href = new_url.toString();
                @else
                // behaviour for ajax table
                var ajax_table = $("#crudTable").DataTable();
                var current_url = ajax_table.ajax.url();
                var new_url = addOrUpdateUriParameter(current_url, parameter, value);
                console.log(current_url, new_url);
                // replace the datatables ajax url with new_url and reload it
                new_url = normalizeAmpersand(new_url.toString());
                ajax_table.ajax.url(new_url).load();
                // mark this filter as active in the navbar-filters
                if (URI(new_url).hasQuery('{{ $filter->name }}', true)) {
                    $("li[filter-name={{ $filter->name }}]").removeClass('active').addClass('active');
                }
                else
                {
                    $("li[filter-name={{ $filter->name }}]").trigger("filter:clear");
                }
                @endif
            }
        });
        // clear filter event (used here and by the Remove all filters button)
        $("li[filter-name={{ $filter->name }}]").on('filter:clear', function(e) {
            $("li[filter-name={{ $filter->name }}]").removeClass('active');
            $("input[name={{ $filter->name }}]").val('');
        });
    });
</script>
@endpush