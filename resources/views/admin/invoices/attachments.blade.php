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
                                Attachments
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="m_user_profile_tab_1">
                    <form class="m-form m-form--fit m-form--label-align-right" id="frmAddInvoiceAttachment" method="post" action="{{ route('admin.invoices.attachments', ['id' => $info->id_hash]) }}" data-id="" enctype="multipart/form-data">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group m--margin-top-10 m--hide">
                                <div class="alert m-alert m-alert--default" role="alert">
                                    The example form below demonstrates common HTML form elements that receive updated styles from Bootstrap with additional classes.
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {{--<label for="example-text-input" class="col-3 col-form-label">--}}
                                    {{--{{ trans('providers.images') }}--}}
                                {{--</label>--}}
                                <div class="col-12">
                                    <div class="m-dropzone dropzone m-dropzone--brand" id="attachment">
                                        <div class="m-dropzone__msg dz-message needsclick">
                                            <h3 class="m-dropzone__msg-title">Drop files here or click to upload.</h3>
                                            <span class="m-dropzone__msg-desc">Only image, pdf, docx and doc files are allowed for upload</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            {{--<div class="m-form__actions">--}}
                            {{--</div>--}}
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
                            Attachments Management
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="invoices_attachments_table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
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
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $("div#attachment").dropzone({
            url: "{{ route('admin.invoices.attachments', ['id' => $info->id_hash]) }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            withCredentials: true,
            maxFiles: 16,
            paramName: "attachment",
            createImageThumbnails: true,
            maxThumbnailFilesize: 1,
            method: "post",
            maxFilesize: 5,
            parallelUploads: 2,
            addRemoveLinks: true,
            dictRemoveFile: 'Remove',
            dictFileTooBig: 'Image is bigger than 5MB',
            acceptedFiles:"file/*,application/pdf,.doc,.docx",
            accept: function(file, done) {
                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                }
                else { done(); }
            },
            timeout: 30000,
            success:function(file, response)
            {
                var view_tbl = $('#invoices_attachments_table').DataTable();
                view_tbl.draw();
            },
        });
    </script>
@stop
