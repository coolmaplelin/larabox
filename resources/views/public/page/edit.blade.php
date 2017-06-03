@extends('layouts.app')

@section('pageTitle', 'Edit Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        	<h1>Edit Page</h1>

        	@include("inc.flash")

        	@include("public.page._form", ['route_name' => 'page.update', 'Page' => $Page])

        </div>
    </div>
</div>
@endsection


@section('after_styles')
    @stack('page_form_styles')
@endsection

@section('after_scripts')
	@stack('page_form_scripts')
@endsection