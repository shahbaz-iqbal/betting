@extends('layout.app')
@section('content')

<div id="app">
<div id="hello" class="hide">{{$id}}</div>
  <point-view></point-view>
</div>
<script src="{{url('js/app.js')}}"></script>
@endsection
