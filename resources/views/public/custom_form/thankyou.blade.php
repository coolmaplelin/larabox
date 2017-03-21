@extends('layouts.app')

@section('pageTitle', ' - Thank you')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $CustomForm->thankyou_title }}</div>

                <div class="panel-body">
                    {!! $CustomForm->thankyou_content !!}
               </div>
            </div>
        </div>
    </div>
</div>
@endsection
