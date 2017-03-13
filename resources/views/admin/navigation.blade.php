@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span >Site Navigation</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    
	    <li class="active">Navigation</li>
	  </ol>
	</section>
@endsection


@section('content')
	<div class="row">
		<div class="col-md-12">

			<div class="box">
		    	<div class="box-header with-border">
					<div class="dataTables_length">
						<label>Currently Editing: 
							<select id="menuSelector" class="form-control">
				                <option value='TOP' @if ($nav_type == 'TOP') selected @endif >Top Menu</option>
				                <option value='FOOTER' @if ($nav_type == 'FOOTER') selected @endif >Footer Links</option>
				            </select>  
						</label>
                        <a href="#" class="btn btn-primary ladda-button" onClick="resetNavEditor(); openNavEditor(); return false">
                        	<span class="ladda-label"><i class="fa fa-plus"></i> Add menu item</span>
                        </a>
					</div>
		    	</div>

		    	<div class="box-body">
		    		<div class="nav-scrollable">
                        <ul id="nav-container" class="clearfix"></ul>
                        
                        
                    </div>
				</div>
		    </div>

		</div>
	</div>
@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('after_scripts')
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/JavaScript">
		var totalNav = 0;
        var navType = '{{ $nav_type }}';

        $(function() {
            $("#nav-container").sortable();
            
            @foreach ($parentNavElements as $parentNavElement)

			    addAnother("#nav-container", "{{ $parentNavElement->name }}", "{{ $parentNavElement->page_id }}", "{{ $parentNavElement->link }}", "{{ $parentNavElement->active }}", "{{ $parentNavElement->id }}");
                  
				@foreach ($childNavElements[$parentNavElement->id] as $childNavElement)
					addAnotherSub("#nav-"+ totalNav , "{{ $childNavElement->name }}", "{{ $childNavElement->page_id }}", "{{ $childNavElement->link }}", "{{ $childNavElement->active }}");
				@endforeach
                  
			@endforeach

        });

        function addAnother(id, name, page_id, link, active, origID)
        {
            totalNav++;
            var newLine = '<li class="nav-item ' + (active == 1 ? 'active' :'inactive') + '" id="nav-' + totalNav + '">';
            
            var buttons = '<button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>';

            newLine += '<div class="controls">' + buttons + '</div>';
            newLine += '<div class="heading">' + name + '</div>';
            newLine += '</li>';
            $(id).append(newLine);
        }
            
	</script>
@endsection
