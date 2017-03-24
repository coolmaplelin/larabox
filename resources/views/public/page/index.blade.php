@extends('layouts.app')

@section('pageTitle', ' - '. $Page->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <h1>{{ $Page->title }} </h1>
        {!! $Page->content !!}
        </div>
    </div>
</div>
@endsection


