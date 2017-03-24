@extends("layouts.email")

@section('header')
	<b>New Form Entry</b>
@endsection

@section('content')

	<h2>Hi Admin, </h2>

	<p>A form has been submitted from the {{ config('app.name') }} website: </p>

	<p>This was sent at {{ date('d/m/Y H:i', strtotime($CustomFormEntry->created_at)) }}. </p>

	<p>{{ str_pad("", 100, "-") }}</p>
	{!! $formdata !!}
    <p>{{ str_pad("", 100, "-") }}</p>

	<p>This is an auto generated email from system, please do not reply.  </p>

	<p>
		Thanks, <br/>
		{{ config('app.name') }}
	</p>
@endsection
