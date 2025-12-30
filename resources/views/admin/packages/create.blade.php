@extends('admin_master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Package</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{URL::to('/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{URL::to('/packages')}}">All Package
                                </a></li>
                        <li class="breadcrumb-item active">Add Package</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Package</h3>
            </div>

            <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <!--
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Package Name <span class="required">*</span></label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Package Name" required>
                                <span class="text-danger" id="name_error"></span>
                            </div>
                        </div>
                        -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Hotel Type <span class="required">*</span></label>
                                <select name="name" id="name" class="form-control" required>
                                    <option value="">--Select--</option>
                                    <option value="3 Star Hotel">3 Star Hotel</option>
                                    <option value="4 Star Hotel">4 Star Hotel</option>
                                    <option value="5 Star Hotel">5 Star Hotel</option>
                                </select>
                                @error('name')
                                    <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="duration">Duration <span class="required">*</span></label>
                                <select name="duration" id="duration" class="form-control" required>
                                    <option value="">--Select--</option>
                                    <option value="monthly">Monthly</option>
{{--                                    <option value="yearly">Yearly</option>--}}
                                </select>
                                @error('duration')
                                    <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Price <span class="required">*</span></label>
                                <input
                                    type="text"
                                    name="price"
                                    class="form-control numericInput"
                                    id="price"
                                    placeholder="Price"
                                    value="{{ old('price') }}"
                                    required
                                >
                                @error('price')
                                    <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <span class="required">*</span></label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                @error('status')
                                    <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="form-group w-100 px-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </section>
</div>

@endsection

@push('scripts')

  <script src="{{asset('custom/multiple_files.js')}}"></script>

  <script>

  </script>
@endpush
