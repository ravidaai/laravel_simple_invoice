<div class="modal fade" id="addNewContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:100%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m--font-danger" id="exampleModalLabel">
                    Add New Item
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right" id="frmAddContactFromInvoice" action="{{ route('admin.contacts.add') }}" method="post" data-id="">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2">Name</label>
                            <div class="col-lg-4">
                                <input type='text' class="form-control m-input" name="name" value="{{ old('name') }}" placeholder="Name"/>
                            </div>
                            <label class="col-form-label col-lg-2">Display Name</label>
                            <div class="col-lg-4">
                                <input type='text' class="form-control m-input" name="display_name" value="{{ old('display_name') }}" placeholder="Display Name"/>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2">Email</label>
                            <div class="col-lg-4">
                                <input type='text' class="form-control m-input" name="email" value="{{ old('email') }}" placeholder="Email"/>
                            </div>
                            <label class="col-form-label col-lg-2">Mobile</label>
                            <div class="col-lg-4">
                                <input type='text' class="form-control m-input" name="mobile" value="{{ old('mobile') }}" placeholder="Mobile"/>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2">Country</label>
                            <div class="col-4">
                                <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="country_id">
                                    <option value="" {{ old('country_id') == '' ? 'selected' : '' }}>Select Item</option>
                                    @foreach($countries as $row)
                                        <option value="{{ $row->id }}" {{ old('country_id') == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-form-label col-lg-2">City</label>
                            <div class="col-4">
                                <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="city_id">
                                    <option value="" {{ old('city_id') == '' ? 'selected' : '' }}>Select Item</option>
                                    @foreach($cities as $row)
                                        <option value="{{ $row->id }}" {{ old('city_id') == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2">URL</label>
                            <div class="col-lg-4">
                                <input type='text' class="form-control m-input" name="url" value="{{ old('url') }}" placeholder="URL"/>
                            </div>
                            <label class="col-form-label col-lg-2">Company</label>
                            <div class="col-lg-4">
                                <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="company_id">
                                    <option value="" {{ old('company_id') == '' ? 'selected' : '' }}>Select Item</option>
                                    @foreach($companies as $row)
                                        <option value="{{ $row->id }}" {{ old('company_id') == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-2">Address</label>
                        <div class="col-lg-4">
                            <input type='text' class="form-control m-input" name="address" value="{{ old('address') }}" placeholder="Address"/>
                        </div>
                        <label class="col-form-label col-lg-2">Postal Code</label>
                        <div class="col-lg-4">
                            <input type='text' class="form-control m-input" name="postal_code" value="{{ old('postal_code') }}" placeholder="Postal Code"/>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-2">Status</label>
                        <div class="col-lg-10">
                            <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="status">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Enable</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Disable</option>
                            </select>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn m-btn btn-{{ $btn_action }} m-btn--wide save"> Save</button>
{{--                                    <a href="{{ route('admin.contacts.view') }}" class="btn m-btn btn-{{ $btn_cancel }} m-btn--wide">Cancel</a>--}}
                                    {!! csrf_field() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>