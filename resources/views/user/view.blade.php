@extends('layout.app')
@section('content')
@push('css')
<div id="app">
    <div id="hello" class="hide">{{$id}}</div>
    <view-component></view-component>
</div>
<script src="{{url('js/app.js')}}"></script>
@endsection