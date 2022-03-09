@extends('layout.app')
@section('content')
@push('css')
<div id="app">
<div id="hello" class="hide">{{$id}}</div>
<!-- <div id="mydiv" ref="myid"><?php echo $id; ?></div> -->
<edit-component></edit-component>
</div>
<script src="{{url('js/app.js')}}"></script>
@endsection
