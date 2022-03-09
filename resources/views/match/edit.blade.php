@extends('layout.app')
@section('content')
<div id="app">
<div id="id" class="hide">{{$id}}</div>
    <match-edit></match-edit>
</div>
<script src="{{url('js/app.js')}}"></script>
@endsection
