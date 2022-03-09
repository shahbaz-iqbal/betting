@extends('layout.app')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Admin Update</h4>
                <form method="POST" action="{{url('admin_update')}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="simpleinput">First Name</label>
                                <input type="text" name="first_name" class="form-control" value="<?php echo $admin['first_name']; ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="simpleinput">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="<?php echo $admin['last_name']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="simpleinput">email</label>
                                <input type="text" name="email" class="form-control" value="<?php echo $admin['email']; ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="simpleinput">Password</label>
                                <input type="text" name="password" class="form-control" value="<?php echo $admin['password']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Image</label>
                            <div class="custom-file">
                                <input type="hidden" name="oldimg" value="<?php echo $admin['image']; ?>">
                                <input type="file" name="img" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary waves-effect waves-light mb-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
@endsection