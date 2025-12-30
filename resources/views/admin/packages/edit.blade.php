@extends('admin_master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Package</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{URL::to('/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{URL::to('/packages')}}">All Package
                                </a></li>
                        <li class="breadcrumb-item active">Edit Package</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Package</h3>
            </div>

            <form action="{{ route('packages.update',$package->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Hotel Type <span class="required">*</span></label>
                                <select name="name" id="name" class="form-control" required>
                                    <option value="">--Select--</option>
                                    <option value="3 Star Hotel" @if($package->name === '3 Star Hotel') selected @endif>3 Star Hotel</option>
                                    <option value="4 Star Hotel" @if($package->name === '4 Star Hotel') selected @endif>4 Star Hotel</option>
                                    <option value="5 Star Hotel" @if($package->name === '5 Star Hotel') selected @endif>5 Star Hotel</option>
                                </select>
                                @error('name')
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="duration">Duration</label>
                                <select name="duration" id="duration" class="form-control" required>
                                    <option value="">--Select--</option>
                                    <option value="monthly" @if($package->duration === 'monthly') selected @endif>Monthly</option>
{{--                                    <option value="yearly">Yearly</option>--}}
                                </select>
                                @error('duration')
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" name="price" class="form-control" id="price" required
                                       value="{{ old('price',$package->price) }}"
                                >
                                @error('price')
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="Active" @if($package->status === 'Active') selected @endif>Active</option>
                                    <option value="Inactive" @if($package->status === 'Inactive') selected @endif>Inactive</option>
                                </select>
                                @error('status')
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="form-group w-100 px-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('packages.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

@endsection

@push('scripts')
    <script>

    </script>
@endpush
