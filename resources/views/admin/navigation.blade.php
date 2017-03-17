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
					<div class="form-inline">
						<label>Currently Editing: 
							<select id="menuSelector" class="form-control">
				                <option value='TOP' @if ($nav_type == 'TOP') selected @endif >Top Menu</option>
				                <option value='FOOTER' @if ($nav_type == 'FOOTER') selected @endif >Footer Links</option>
				            </select>  
						</label>
                        <a href="#" class="btn btn-success ladda-button" onClick="saveNavigation();return false">
                            <span class="ladda-label"><i class="fa fa-save"></i> Save All</span>
                        </a>
					</div>
		    	</div>

		    	<div class="box-body">
		    		<div class="nav-panel">
                        <ul id="nav-container" class=""></ul>
                        <a href="#" class="btn btn-primary ladda-button clearfix" style="float:left" onClick="openNavEditor(); return false">
                            <span class="ladda-label"><i class="fa fa-plus"></i> Add Another</span>
                        </a>
                    </div>
				</div>
		    </div>

		</div>
	</div>

    <!-- Modal -->
    <div id="navEditor" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Item</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" class="form-control nav_id" name="nav_id"/>
                        <input type="hidden" class="form-control parent_id" name="parent_id"/>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control name" name="name"/>
                        </div>
                        <div class="form-group">
                            <label>Page</label>
                            <select class="form-control page_id" name="page_id">
                                <option value=""></option>
                                @foreach ($pages as $page)
                                    <option value="{{ $page->id }} ">{{ $page->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" class="form-control link" name="link"/>
                            <p class="help-block">Leave this if page is specified.</p>
                        </div>
                        <div class="form-group">
                            <label>Active</label>
                            <select class="form-control active" name="active">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-save">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
            $("#menuSelector").change(function(){
                window.location = '/admin/navigation/' + $(this).val();
            });

            $("#nav-container").sortable();
            
            @foreach ($parentNavElements as $parentNavElement)

			    addParent("#nav-container", "{{ $parentNavElement->name }}", "{{ $parentNavElement->page_id }}", "{{ $parentNavElement->link }}", "{{ $parentNavElement->active }}", "{{ $parentNavElement->id }}");
                  
				@foreach ($childNavElements[$parentNavElement->id] as $childNavElement)
					addChild("#nav-"+ totalNav , "{{ $childNavElement->name }}", "{{ $childNavElement->page_id }}", "{{ $childNavElement->link }}", "{{ $childNavElement->active }}", "{{ $childNavElement->id }}");
				@endforeach
                  
			@endforeach

            $("#navEditor .btn-save").click(function(){
                updateNavigationContainer();
                $("#navEditor").modal('toggle');
            })

        });

        function addParent(id, name, page_id, link, active, origID = '')
        {
            totalNav++;
            var fullID = 'nav-' + totalNav;

            var newLine = '<li id="' + fullID + '" class="nav-item ' + (active == 1 ? '' :'inactive') + '" data-id="' + fullID + '">';
            
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
                        +   '<span class="origid">' + origID + '</span>'
            			+'</div>';
            newLine += '<ul class="nav-inner"></ul>';
            newLine += '</li>';
            $(id).append(newLine);

            $('#' + fullID + ' .btn-add').click(function(){
                openNavEditor('', fullID);
            	return false;
            });

            $('#' + fullID + ' .btn-edit').click(function(){
                openNavEditor(fullID, '');
                return false;
            });

            $('#' + fullID + ' .btn-delete').click(function(){
            	deleteNav(fullID); 
            	return false;
            });
        }

        function addChild(parent, name, page_id, link, active, origID = '')
        {
            var subNavTotal = $(parent + " .sub-nav-item").size();
            subNavTotal++;
            var parentIDArray = parent.split("#");
            var parentID = parentIDArray[1];
            var fullID = parentID + '-sub-nav-' + subNavTotal;

            var newLine = '<li id="' + fullID + '" class="sub-nav-item ' + (active == 1 ? '' :'inactive') + '">';

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
                        +   '<span class="origid">' + origID + '</span>'
            			+'</div>';          
            newLine += '</li>';

            $(parent + " ul").append(newLine);

            $('#' + fullID + ' .btn-edit').click(function(){
                openNavEditor(fullID, parentID);
                return false;
            });

            $('#' + fullID + ' .btn-delete').click(function(){
            	deleteNav(fullID); 
            	return false;
            });

            $(parent + " ul").sortable();
        }

        function openNavEditor(nav_id = '', parent_id = '')
        {
            if (parent_id == '' && nav_id == '') {
                //Add new parent nav item
                $("#navEditor .modal-title").html('New Item');
                $("#navEditor .nav_id").val("");
                $("#navEditor .parent_id").val("");
                $("#navEditor .name").val("");
                $("#navEditor .pageid").val("");
                $("#navEditor .link").val("");
                $("#navEditor .active").val("1");

            }else if(parent_id != '' && nav_id == '') {
                //Add new child nav item   
                $("#navEditor .modal-title").html('New Sub Item of ' + $('#' + parent_id).find('.heading').html());

                $("#navEditor .nav_id").val("");
                $("#navEditor .parent_id").val(parent_id);
                $("#navEditor .name").val("");
                $("#navEditor .pageid").val("");
                $("#navEditor .link").val("");
                $("#navEditor .active").val("1");

            }else if(nav_id != '') {

                $("#navEditor .modal-title").html('Edit Item');

                $("#navEditor .nav_id").val(nav_id);
                $("#navEditor .parent_id").val(parent_id);
                $("#navEditor .name").val($("#" + nav_id).find("> .heading").html());
                $("#navEditor .page_id").val($("#" + nav_id).find("> .data .page_id").text());
                $("#navEditor .link").val($("#" + nav_id).find("> .data .link").text());
                $("#navEditor .active").val($("#" + nav_id).find("> .data .active").text());
                //Update parent/child nav item
            }

            $("#navEditor").modal('show');   
        }

        function updateNavigationContainer()
        {
            var nav_id = $("#navEditor .nav_id").val();
            var parent_id = $("#navEditor .parent_id").val();
            var name = $("#navEditor .name").val();
            var page_id = $("#navEditor .page_id").val();
            var link = $("#navEditor .link").val();
            var active = $("#navEditor .active").val();

            if (parent_id == '' && nav_id == '') {
                addParent("#nav-container", name, page_id, link, active);

            }else if(parent_id != '' && nav_id == '') {

                addChild("#" + parent_id, name, page_id, link, active);

            }else if(nav_id != '') {

                $("#" + nav_id).find("> .heading").html(name);
                $("#" + nav_id).find("> .data .page_id").text(page_id);
                $("#" + nav_id).find("> .data .link").text(link);
                $("#" + nav_id).find("> .data .active").text(active);

                if (active == "1" && $("#" + nav_id).hasClass('inactive') || active == "0" && !$("#" + nav_id).hasClass('inactive')) {
                    $("#" + nav_id).toggleClass('inactive');
                }

            }
        }

        function deleteNav(id)
        {
            if(confirm("Are you sure you want to remove this item?"))
            {
               $("#" + id).remove();
            }
        }

        function saveNavigation()
        {
            var navItems = [];

            var counter = 0;
            $("#nav-container .nav-item").each(function(){

                var parentNav = $(this);
                navItems[counter] = {
                    name : parentNav.find('> .heading').html(),
                    page_id : parentNav.find('> .data .page_id').text(),
                    link : parentNav.find('> .data .link').text(),
                    active : parentNav.find('> .data .active').text(),
                    origid : parentNav.find('> .data .origid').text(),
                    subnavs : []
                }

                var nav_id = parentNav.attr('id');
                var subcounter = 0;
                parentNav.find(".sub-nav-item").each(function(){
                    var sub_nav_id = $(this);
                    navItems[counter].subnavs[subcounter] = {
                        name : $(this).find('.heading').html(),
                        page_id : $(this).find('.page_id').text(),
                        link : $(this).find('.link').text(),
                        active : $(this).find('.active').text(),
                        origid : $(this).find('.origid').text(),
                    }
                    subcounter++;
                });

                counter++;
            });

            var params = {};
            params.nav_type = '{{ $nav_type }}';
            params.nav_items = JSON.stringify(navItems); 

            $.ajax({
                url: '/admin/navigation/save',
                type: 'post',
                data: params,
                dataType: 'JSON',
                success: function (result) {
                    if (result.success) {
                        alert("Navigation is saved");
                    }
                },
                error: function () {
                    alert('Failed.');
                }
            }); 
        }

	</script>
@endsection
