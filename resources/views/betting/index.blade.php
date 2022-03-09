@extends('layout.app')
@section('content')

<div id="app">
  <betting-list></betting-list>
</div>
@push('vue')
@endpush
<script src="{{url('js/app.js')}}"></script>
@endsection
