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

			    addParent("#nav-container", "{{ $parentNavElement->name }}", "{{ $parentNavElement->page_id }}", "{{ $parentNavElement->link }}", "{{ $parentNavElement->active }}", "{{ $parentNavElement->id }}");
                  
				@foreach ($childNavElements[$parentNavElement->id] as $childNavElement)
					addChild("#nav-"+ totalNav , "{{ $childNavElement->name }}", "{{ $childNavElement->page_id }}", "{{ $childNavElement->link }}", "{{ $childNavElement->active }}");
				@endforeach
                  
			@endforeach

        });

        function addParent(id, name, page_id, link, active, origID)
        {
            totalNav++;
            var fullID = 'nav-' + totalNav;

            var newLine = '<li id="' + fullID + '" class="nav-item ' + (active == 1 ? 'active' :'inactive') + '" data-id="' + fullID + '">';
            
            var buttons = ' <button type="button" class="btn btn-default btn-add btn-xs">' 
                          + '	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>'
                          + '</button>'
                          + '<button type="button" class="btn btn-default btn-edit btn-xs">'
                          + '	<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                          + '</button>'
                          + '<button type="button" class="btn btn-default btn-delete btn-xs">'
                          + '	<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>'
                          + '</button>';

            newLine += '<div class="controls">' + buttons + '</div>';
            newLine += '<div class="heading">' + name + '</div>';
            newLine += '<div class="data hidden">'
            			+	'<span class="page_id">' + page_id + '</span>'
            			+	'<span class="link">' + link + '</span>'
            			+	'<span class="active">' + active + '</span>'
            			+'</div>';
            newLine += '<ul class="nav-inner"></ul>';
            newLine += '</li>';
            $(id).append(newLine);

            $('#' + fullID + ' .btn-add').click(function(){
            	resetSubNavigation(fullID); 
            	openSubNavEditor(); 
            	return false;
            });

            $('#' + fullID + ' .btn-edit').click(function(){
            	prepareNavEditor(fullID); 
            	openNavEditor(); 
            	return false;
            });

            $('#' + fullID + ' .btn-delete').click(function(){
            	deleteNav(fullID); 
            	return false;
            });
        }

        function addChild(parent, name, page_id, link, active)
        {
            var subNavTotal = $(parent + " .sub-nav-item").size();
            subNavTotal++;
            var parentIDArray = parent.split("#");
            var parentID = parentIDArray[1];
            var fullID = parentID + '-sub-nav-' + subNavTotal;

            var newLine = '<li id="' + fullID + '" class="sub-nav-item ' + (active == 1 ? 'active' :'inactive') + '">';

            var buttons = '<button type="button" class="btn btn-default btn-edit btn-xs">'
                          + '	<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                          + '</button>'
                          + '<button type="button" class="btn btn-default btn-delete btn-xs">'
                          + '	<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>'
                          + '</button>';
            newLine += '<div class="controls">' + buttons + '</div>';  
            newLine += '<div class="heading">' + name + '</div>';  
            newLine += '<div class="data hidden">'
            			+	'<span class="page_id">' + page_id + '</span>'
            			+	'<span class="link">' + link + '</span>'
            			+	'<span class="active">' + active + '</span>'
            			+'</div>';          
            newLine += '</li>';

            $(parent + " ul").append(newLine);

            $('#' + fullID + ' .btn-edit').click(function(){
            	prepareSubnavEditor(fullID); 
            	openSubNavEditor(); 
            	return false;
            });

            $('#' + fullID + ' .btn-delete').click(function(){
            	deleteNav(fullID); 
            	return false;
            });
        }
            
	</script>
@endsection
