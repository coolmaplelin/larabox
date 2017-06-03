@if (session('flash_message'))
	<div class="alert alert-success">
		{{ session('flash_message') }}
	</div>
@endif


@if (session('flash_error'))
	<div class="alert alert-danger">
		{{ session('flash_error') }}
	</div>
@endif

