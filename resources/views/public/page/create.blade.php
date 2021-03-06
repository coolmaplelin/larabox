@extends('layouts.app')

@section('pageTitle', 'Create Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        	<h1>Create A Page</h1>

        	@include("public.page._form", ['route_name' => 'page.store', 'Page' => $Page])
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