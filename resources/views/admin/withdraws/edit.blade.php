@extends('admin_master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Withdraw</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{URL::to('/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{URL::to('/withdraws')}}">All Withdraw
                                </a></li>
                        <li class="breadcrumb-item active">Edit Withdraw</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Withdraw</h3>
            </div>

            <form id="edit_form">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hotel_id">Select Hotel <span class="required">*</span></label>
                                <select name="hotel_id" id="hotel_id" class="form-control" required>
                                    <option value="">-- Select Hotel --</option>
                                </select>
                                <span class="text-danger" id="hotel_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="balance">Balance <span class="required">*</span></label>
                                <input
                                    type="text"
                                    name="balance"
                                    class="form-control"
                                    id="balance"
                                    placeholder="Balance"
                                    readonly
                                >
                                <span class="text-danger" id="balance_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="acc_no">Acc. No <span class="required">*</span></label>
                                <input
                                    type="text"
                                    name="acc_no"
                                    class="form-control"
                                    id="acc_no"
                                    placeholder="Acc. No"
                                    readonly
                                >
                                <span class="text-danger" id="acc_no_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_method">Payment Method <span class="required">*</span></label>
                                <input
                                    type="text"
                                    name="payment_method"
                                    class="form-control"
                                    id="payment_method"
                                    placeholder="Payment Method"
                                    readonly
                                >
                                <span class="text-danger" id="payment_method_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title <span class="required">*</span></label>
                                <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    id="title"
                                    placeholder="Title"
                                    required
                                >
                                <span class="text-danger" id="title_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_type">Payment Type <span class="required">*</span></label>
                                <input
                                    type="text"
                                    name="payment_type"
                                    class="form-control"
                                    id="payment_type"
                                    placeholder="Payment Type. Ex: Cash Out, Bank Transfer"
                                    required
                                >
                                <span class="text-danger" id="title_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount <span class="required">*</span></label>
                                <input
                                    type="text"
                                    name="amount"
                                    class="form-control"
                                    id="amount"
                                    placeholder="Amount"
                                    required
                                >
                                <span class="text-danger" id="amount_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="withdraw_at">Withdraw At <span class="required">*</span></label>
                                <input
                                    type="datetime-local"
                                    name="withdraw_at"
                                    class="form-control"
                                    id="withdraw_at"
                                    required
                                >
                                <span class="text-danger" id="withdraw_at_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="trx_id">Transaction ID <span class="required">*</span></label>
                                <input
                                    type="text"
                                    name="trx_id"
                                    class="form-control"
                                    id="trx_id"
                                    placeholder="Transaction ID"
                                    required
                                >
                                <span class="text-danger" id="trx_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reference">Reference <span class="required">*</span></label>
                                <input
                                    type="text"
                                    name="reference"
                                    class="form-control"
                                    id="reference"
                                    placeholder="Reference"
                                    required
                                >
                                <span class="text-danger" id="reference_error"></span>
                            </div>
                        </div>

                    </div>

                    <div class="form-group w-100 px-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('popularPlaces.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let token = "{{ session('api_token') }}";   // store your token in session when login
            let apiBaseUrl = '{{ config("app.api_base_url") }}';
            let id = "{{ request()->route('withdraw') }}"; // from /popularPlaces/{id}/edit

            // 🔹 Fetch data
            $.ajax({
                url: apiBaseUrl + 'api/v1/admin/hotel-list',
                type: 'GET',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (resp) {
                    if (resp.success && resp.data.length > 0) {
                        let hotels = resp.data;
                        let hotelSelect = $('#hotel_id');

                        hotelSelect.empty().append('<option value="">-- Select Hotel --</option>');

                        hotels.forEach(hotel => {
                            hotelSelect.append(
                                `<option value="${hotel.id}"
                            data-balance="${hotel.balance || 0}"
                            data-payment="${hotel.withdraw_method?.payment_method || ''}"
                            data-accno="${hotel.withdraw_method?.acc_no || ''}">
                            ${hotel.hotel_name}
                        </option>`
                            );
                        });
                    } else {
                        toastr.warning('No hotels found.');
                    }
                },
                error: function (xhr) {
                    toastr.error('Failed to load hotels.');
                }
            });
            $.ajax({
                url: apiBaseUrl + 'api/v1/withdraws/view/' + id,
                type: 'GET',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function(resp) {
                    if (resp.success) {
                        let data = resp.data;
                        $('#name').val(data.name);
                        $('#status').val(data.status);
                    }
                },
                error: function(xhr) {
                    toastr.error('Something went wrong while fetching popular place data.');
                    window.location.href = "{{ route('withdraws.index') }}";
                }
            });

            // 🔹 Handle update form submit
            $('#edit_form').on('submit', function(e) {
                e.preventDefault();

                // clear errors
                $('#name_error, #image_error, #status_error').text('');

                let form = $(this);
                let submitBtn = form.find('button[type="submit"]');

                submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Submitting...');

                // let formData = {
                //     name: $('#name').val(),
                //     image: $('#image').val(),
                //     status: $('#status').val()
                // };

                let formData = new FormData(this);

                $.ajax({
                    url: apiBaseUrl + 'api/v1/withdraws/update/' + id,
                    type: 'POST',
                    data: formData,
                    processData: false,  // required for file upload
                    contentType: false,  // required for file upload
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader("Authorization", "Bearer " + token);
                    },
                    success: function(resp) {
                        toastr.success(resp.message || 'Withdraw updated successfully');
                        setTimeout(() => {
                            window.location.href = "{{ route('withdraws.index') }}";
                        }, 1500);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.name) $('#name_error').text(errors.name[0]);
                            if (errors.image) $('#image').text(errors.image[0]);
                            if (errors.status) $('#status_error').text(errors.status[0]);
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                        }
                    },
                    complete: function() {
                        // always restore the button
                        submitBtn.prop('disabled', false).html('Submit');
                    }
                });
            });
        });
    </script>
@endpush
