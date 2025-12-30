@extends('admin_master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Withdraw</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{URL::to('/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{URL::to('/withdraws')}}">All Withdraw</a></li>
                        <li class="breadcrumb-item active">Add Withdraw</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Withdraw</h3>
            </div>

            <form action="{{ route('withdraws.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hotel_id">Select Hotel <span class="required">*</span></label>
                                <select name="hotel_id" id="hotel_id" class="form-control select2bs4" required>
                                    <option value="" selected="" disabled="">-- Select Hotel --</option>
                                    @if(count($hotels) > 0)
                                        @foreach ($hotels as $hotel)
                                            <option value="{{ $hotel['id'] }}">{{ $hotel['hotel_name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('hotel_id')
                                    <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
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
                                @error('balance')
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
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
                                @error('acc_no')
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
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
                                @error('payment_method')
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
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
                                @error('title')
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
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
                                @error('payment_type')
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
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
                                @error('amount')
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
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
                                @error('withdraw_at')
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
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
                                @error('trx_id')
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
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
                                @error('reference')
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
    $(document).ready(function () {

        $('#hotel_id').on('change', function () {
            let hotelId = $(this).val();

            if (!hotelId) return;

            $.ajax({
                url: `/hotel/${hotelId}/withdraw-info`,
                type: 'GET',
                success: function (response) {
                    $('#balance').val(response.balance ?? '');
                    $('#acc_no').val(response.acc_no ?? '');
                    $('#payment_method').val(response.payment_method ?? '');
                },
                error: function () {
                    alert('Unable to fetch hotel data');
                }
            });
        });

    });
</script>

@endpush
