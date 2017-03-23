@component('mail::message')

	Hi Admin,

	A form has been submitted from the {{ config('app.name') }} website: <br/>

	This was sent at {{ date('d/m/Y H:i', strtotime($CustomFormEntry->created_at)) }}.


	<table>
		<tr><td>Name</td><td>Maple Lin</td></tr>
	</table>


	This is an auto generated email from system, please do not reply.

	Thanks,<br>
	{{ config('app.name') }}

@endcomponent