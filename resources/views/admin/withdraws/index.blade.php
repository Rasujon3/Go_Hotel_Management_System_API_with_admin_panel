@extends('admin_master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">All Withdraw</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{URL::to('/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{URL::to('/withdraws')}}">All Withdraw</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Withdraw</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <a href="{{ route('withdraws.create') }}" class="btn btn-primary add-new mb-2">Add New Withdraw</a>
                <div class="fetch-data table-responsive">
                    <table id="table" class="table table-bordered table-striped data-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Hotel Name</th>
                                <th>Payment Type</th>
                                <th>Amount</th>
                                <th>Withdraw at</th>
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
                    url: "{{ url('/withdraws') }}",
                },

                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'hotel_name', name: 'hotel_name'},
                    {data: 'payment_type', name: 'payment_type'},
                    {data: 'amount', name: 'amount'},
                    {data: 'withdraw_at', name: 'withdraw_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $(document).on('click', '.delete-data', function(e){

                e.preventDefault();

                id = $(this).data('id');

                if(confirm('Do you want to delete this?'))
                {
                    $.ajax({
                        url: "{{ url('/withdraws') }}/"+id,
                        type: "DELETE",
                        dataType: "json",
                        success:function(data) {
                            if (data.status) {
                                toastr.success(data.message);

                                $('.data-table').DataTable().ajax.reload(null, false);
                            } else {
                                toastr.error(data.message);
                            }
                        },
                    });
                }

            });

        });
    </script>
@endpush
