@extends('layout.app')
@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Score Update</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Score Update</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card">
                    <div class="card-header">Score Add</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('/score_update')}}" enctype='multipart/form-data'>
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{$team1['name']}} Score</label>
                                        <input type="hidden" name="id" class="form-control" placeholder="name" value="{{$id}}">
                                        <input type="text" name="team1" class="form-control" placeholder="name" value="{{$match['score']['team1']['score']}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{$team2['name']}} Score</label>
                                        <input type="text" name="team2" class="form-control" placeholder="name" value="{{$match['score']['team2']['score']}}">
                                    </div>
                                </div>
                               
                            </div>
                            <div class="card-action">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <!-- <button class="btn btn-danger">Cancel</button> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection