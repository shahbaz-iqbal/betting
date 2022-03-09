@extends('layout.app')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>{{ $message }}</strong>
</div>
@endif @if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>{{ $message }}</strong>
</div>
@endif
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-5 align-self-center">
      <h4 class="page-title">Prize Dustribution</h4>
    </div>
    <div class="col-7 align-self-center">
      <div class="d-flex align-items-center justify-content-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Prize Distribution</li>
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
        <div class="table-responsive">
          <table id="zero_config" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Category Name</th>
                <th>Location</th>
                <th>Created By</th>
                <th>created</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            @if (!empty($matches))
            @foreach($matches as $value)
            <tr>

              <td>{{ $value['category_name'] }}</td>
              <td>{{ $value['location'] }}</td>
              <td>{{ $value['createdby'] }}</td>
              <td>{{ $value['created'] }}</td>
              <td><span class="badge badge-warning">Undistributed</span></td>
              <td>
                <div class="form-button-action">
                  <a href="{{url('/match_prize/'.$value['matchid'])}}" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success" data-original-title="Distribute">
                    <i class="fa fa-gift"></i>
                  </a>
                </div>
              </td>
            </tr>
            @endforeach
            @endif
            </tbody>
            <tfoot>
              <tr>
                <th>Category Name</th>
                <th>Location</th>
                <th>Created By</th>
                <th>created</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection