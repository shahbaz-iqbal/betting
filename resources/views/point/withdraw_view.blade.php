@extends('layout.app')
@section('content')

<div id="app">
<div id="hello" class="hide">{{$id}}</div>
  <withdraw_view></withdraw_view>
</div>
<script src="{{url('js/app.js')}}"></script>
@endsection
