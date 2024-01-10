<div class="modal fade" id="addNewItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                <form class="m-form m-form--fit m-form--label-align-right" id="frmAddItemFromInvoice" action="{{ route('admin.items.add') }}" method="post" data-id="">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2">Name</label>
                            <div class="col-lg-4">
                                <input type='text' class="form-control m-input" name="name" value="{{ old('name') }}" placeholder="Name"/>
                            </div>
                            <label class="col-form-label col-lg-2">Price</label>
                            <div class="col-lg-4">
                                <input type='text' class="form-control m-input" name="price" value="{{ old('price') }}" placeholder="Price"/>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2">Description</label>
                            <div class="col-lg-10">
                                <textarea name="description" id="description" class="form-control m-input" cols="30" rows="10" placeholder="Description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2">Type</label>
                            <div class="col-4">
                                <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="type">
                                    <option value="" {{ old('type') == '' ? 'selected' : '' }}>Select Item</option>
                                    <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>Goods</option>
                                    <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>Service</option>
                                </select>
                            </div>
                            <label class="col-form-label col-lg-2">Status</label>
                            <div class="col-4">
                                <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="status">
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Enable</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Disable</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn m-btn btn-{{ $btn_action }} m-btn--wide save"> Save</button>
{{--                                    <a href="{{ route('admin.items.view') }}" class="btn m-btn btn-{{ $btn_cancel }} m-btn--wide">Cancel</a>--}}
                                    {!! csrf_field() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
{{--            <div class="modal-footer">--}}
{{--                <button type="button" class="btn btn-secondary" data-dismiss="modal">--}}
{{--                    Close--}}
{{--                </button>--}}
{{--                <button href="" data-dismiss="modal" aria-hidden="true" class="btn btn-brand delete">--}}
{{--                    Yes, ..--}}
{{--                </button>--}}
{{--                <input type="hidden" id="delete_id">--}}
{{--            </div>--}}
        </div>
    </div>
</div>