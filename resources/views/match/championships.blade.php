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
      <h4 class="page-title">Championships</h4>
    </div>
    <div class="col-7 align-self-center">
      <div class="d-flex align-items-center justify-content-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Championships Table</li>
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
      <a href="{{url('/championship_add')}}" class="btn btn-success mb-3">Add Champianship</a>
        <div class="table-responsive">
          <table id="zero_config" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Region</th>
                <th>Action</th>
              </tr>
            </thead>
            @if (!empty($championships))
            @foreach($championships as $value)
            <tr>
              <td>
                <div class="avatar-sm">
                  <img src="{{ $value['icon'] }}" alt="..." class="avatar-img rounded-circle" height="35">
                </div>
              </td>
              <td>{{ $value['name'] }}</td>
              <td>{{ $value['region'] }}</td>
              <td>
                <div class="form-button-action">
                  <a href="{{url('/championship_edit/'.$value['id'])}}" type="button" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Edit">
                    <i class="fa fa-edit"></i>
                  </a>
                </div>
              </td>
            </tr>
            @endforeach
            @endif
            </tbody>
            <tfoot>
              <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Region</th>
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