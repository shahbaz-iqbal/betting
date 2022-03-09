@extends('layout.app')
@section('content')
<div id="app">
<div id="id" class="hide">{{$id}}</div>
    <team-edit></team-edit>
</div>
<script src="{{url('js/app.js')}}"></script>
@endsection
