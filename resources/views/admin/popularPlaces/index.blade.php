@extends('admin_master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">All Popular Place</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{URL::to('/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{URL::to('/popularPlaces')}}">All Popular Place</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Popular Place</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <a href="{{ route('popularPlaces.create') }}" class="btn btn-primary add-new mb-2">Add New Popular Place</a>
                <div class="fetch-data table-responsive">
                    <table id="table" class="table table-bordered table-striped data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="conts">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            let token = "{{ session('api_token') }}";
            let apiBaseUrl = '{{ config("app.api_base_url") }}';

            var packageTable = $('#table').DataTable({
                searching: true,
                processing: true,
                serverSide: false,
                ordering: false,
                responsive: true,
                ajax: {
                    url: apiBaseUrl + 'api/v1/popularPlaces/list',
                    type: "GET",
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader("Authorization", "Bearer " + token);
                    },
                    dataSrc: function (json) {
                        if(json.success) {
                            return json.data;
                        } else {
                            toastr.error(json.message || 'Failed to load popular Places.');
                            return [];
                        }
                    }
                },
                columns: [
                    {data: 'name'},
                    {
                        data: 'image_url',
                        render: function(data, type, row) {
                            if (data) {
                                return '<img src="' + data + '" alt="package image" width="60" height="60" class="img-thumbnail">';
                            }
                            return '—';
                        }
                    },
                    {data: 'status'},
                    {
                        data: null,
                        render: function(data, type, row) {
                            let btns = '';
                            btns += '<a href="/popularPlaces/' + row.id + '/edit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> ';
                            btns += '<button class="btn btn-danger btn-sm delete-data" data-id="'+row.id+'"><i class="fa fa-trash"></i></button>';
                            return btns;
                        }
                    }
                ]
            });

            // 🔥 delete handler
            $(document).on('click', '.delete-data', function(e){
                e.preventDefault();
                let id = $(this).data('id');

                if(confirm('Do you want to delete this data?')) {
                    $.ajax({
                        url: apiBaseUrl + 'api/v1/popularPlaces/delete/' + id,
                        type: 'DELETE',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader("Authorization", "Bearer " + token);
                        },
                        success: function(resp) {
                            if(resp.success) {
                                toastr.success(resp.message);
                                $('#table').DataTable().ajax.reload(null, false);
                            } else {
                                toastr.error(resp.message || 'Failed to delete');
                            }
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                        }
                    });
                }
            });
        });
    </script>
@endpush
