@extends('layout.app')
@section('content')
@push('css')
<div id="app">
    <div id="hello" class="hide">{{$id}}</div>
    <div id="cat" class="hide">{{$cat}}</div>
    <match-component></match-component>
</div>
<script src="{{url('js/app.js')}}"></script>
@endsection