@extends('admin_master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">All Property Type</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{URL::to('/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">All Property Type</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Property Type</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <a href="{{ route('propertyTypes.create') }}" class="btn btn-primary add-new mb-2">Add New Property Type</a>
                <div class="fetch-data table-responsive">
                    <table id="table" class="table table-bordered table-striped data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Image</th>
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
  		let id;
  		var productTable = $('#table').DataTable({
		        searching: true,
		        processing: true,
		        serverSide: true,
		        ordering: false,
		        responsive: true,
		        stateSave: true,
		        ajax: {
		          url: "{{ url('/propertyTypes') }}",
		        },

		        columns: [
		            {data: 'name', name: 'name'},
		            {data: 'status', name: 'status'},
                    {data: 'image_url', name: 'image_url'},
		            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ]
        });

       $(document).on('click', '.delete-data', function(e){

           e.preventDefault();

           id = $(this).data('id');

           if(confirm('Do you want to delete this?'))
           {
               $.ajax({
                    url: "{{ url('/propertyTypes') }}/"+id,
                     type:"DELETE",
                     dataType:"json",
                     success:function(data) {

                        toastr.success(data.message);

                        $('.data-table').DataTable().ajax.reload(null, false);
                    },
              });
           }

       });

  	});
  </script>

@endpush
