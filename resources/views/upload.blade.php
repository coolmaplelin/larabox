@extends('backpack::layout')

@section('content')
    @include('inc.jquery_file_upload', ['entity_name' => $entity_name, 'entity_id' => $entity_id])
@endsection
 
