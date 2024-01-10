@extends('admin.invoices.layout.master')
@section('subContent')
@include('admin.layout.error')
            <div class="m-portlet m-portlet--full-height m-portlet--tabs">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools" id="tabs">
                    <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--brand" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                <i class="flaticon-share m--hide"></i>
                                Payments
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="m_user_profile_tab_1">
                        <form class="m-form m-form--fit m-form--label-align-right" id="frmAddPayment" action="{{ route('admin.invoices.payments', ['id' => $info->id_hash]) }}" method="post" data-id="">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-2">Amount</label>
                                    <div class="col-lg-3">
                                        <input type='text' class="form-control m-input" name="amount" value="{{ old('amount') }}" placeholder="Amount"/>
                                    </div>
                                    <label class="col-form-label col-lg-2">Type</label>
                                    <div class="col-3">
                                        <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" id="type" name="type">
                                            <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>Cash</option>
                                            <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>Visa</option>
                                            <option value="3" {{ old('type') == '3' ? 'selected' : '' }}>Transfer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-2">Note</label>
                                    <div class="col-8">
                                        <textarea name="note" id="note" class="form-control m-input" cols="30" rows="10" placeholder="Write something here, ..">{{ old('note') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row m-bank {{ old('type') != '3' ? 'd-none' : '' }}">
                                    <label class="col-form-label col-lg-2">Bank Name</label>
                                    <div class="col-lg-8">
                                        <input type='text' class="form-control m-input" name="bank_name" value="{{ old('bank_name') }}" placeholder="Bank Name"/>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row m-bank {{ old('type') != '3' ? 'd-none' : '' }}">
                                    <label class="col-form-label col-lg-2">Bank Branch</label>
                                    <div class="col-lg-8">
                                        <input type='text' class="form-control m-input" name="bank_branch" value="{{ old('bank_branch') }}" placeholder="Bank Branch"/>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row m-bank {{ old('type') != '3' ? 'd-none' : '' }}">
                                    <label class="col-form-label col-lg-2">Transfer Number</label>
                                    <div class="col-lg-8">
                                        <input type='text' class="form-control m-input" name="transfer_number" value="{{ old('transfer_number') }}" placeholder="Transfer Number"/>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-6">
                                            <button type="submit" class="btn m-btn btn-{{ $btn_action }} m-btn--wide saves"> Save</button>
                                            <a href="{{ route('admin.payments.view') }}" class="btn m-btn btn-{{ $btn_cancel }} m-btn--wide">Cancel</a>
                                            {!! csrf_field() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
            <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Payments Management
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="invoices_payments_table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Invoice Id</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Bank Name</th>
                        <th>Bank Branch</th>
                        <th>Transfer Number</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
@stop

@section('sub-js')
    <script>
        $(document).on('change', '#type', function (e) {
            var val = $(this).val();
            if (val === "3")
            {
                $('.m-bank').removeClass('d-none');
                $('.m-bank').removeClass('d-none');
            }
            else
            {
                $('.m-bank').addClass('d-none');
                $('.m-bank').addClass('d-none');
            }
        });
    </script>
@stop
