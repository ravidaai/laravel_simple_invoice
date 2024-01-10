window.base_url = "{{ asset('/') }}";

window.delete_confirmation_title = "{{ trans('app.delete_confirmation_title') }}";
window.delete_confirmation_message = "{{ trans('app.delete_confirmation_message') }}";
window.delete_confirmation_note = "{{ trans('app.delete_confirmation_note') }}";
window.confirm_label = "{{ trans('app.confirm_label') }}";
window.cancel_label = "{{ trans('app.cancel_label') }}";
window.select_item = "{{ trans('general.select_item') }}";
window.saving = "{{ trans('general.saving') }}";
window.btn_save = "{{ trans('general.save_changes') }}";

window.admin_url = "{{ route('admin.dashboard.view') }}";
window.countries_view = "{{ route('admin.countries.view') }}";
window.countries_list = "{{ route('admin.countries.list') }}";

window.users_view = "{{ route('admin.users.view') }}";
window.users_list = "{{ route('admin.users.list') }}";

window.contacts_view = "{{ route('admin.contacts.view') }}";
window.contacts_list = "{{ route('admin.contacts.list') }}";

window.countries_view = "{{ route('admin.countries.view') }}";
window.countries_list = "{{ route('admin.countries.list') }}";

window.cities_view = "{{ route('admin.cities.view') }}";
window.cities_list = "{{ route('admin.cities.list') }}";

window.currencies_view = "{{ route('admin.currencies.view') }}";
window.currencies_list = "{{ route('admin.currencies.list') }}";

window.companies_view = "{{ route('admin.companies.view') }}";
window.companies_list = "{{ route('admin.companies.list') }}";

window.branches_view = "{{ route('admin.branches.view') }}";
window.branches_list = "{{ route('admin.branches.list') }}";

window.payments_view = "{{ route('admin.payments.view') }}";
window.payments_list = "{{ route('admin.payments.list') }}";

window.items_view = "{{ route('admin.items.view') }}";
window.items_list = "{{ route('admin.items.list') }}";

window.invoices_view = "{{ route('admin.invoices.view') }}";
window.invoices_list = "{{ route('admin.invoices.list') }}";

window.reports_list = "{{ route('admin.reports.list') }}";

////// TRANSLATION SWEET ALERT DELETE //////
////////////////////////////////////////////
{{--window.btn_yes = "{{ trans('delete.yes') }}";--}}
{{--window.btn_no = "{{ trans('delete.no') }}";--}}
{{--window.title = "{{ trans('delete.title') }}";--}}
{{--window.text = "{{ trans('delete.text') }}";--}}

////////// TRANSLATION DATA TABLES //////////
////////////////////////////////////////////
window.sProcessing = "{{ trans('general.processing') }}";
window.sLengthMenu = "{{ trans('general.show') }} _MENU_ {{ trans('general.entries') }}";
window.sZeroRecords = "{{ trans('general.no_matching_records_found') }}";
window.sInfo = "{{ trans('general.showing') }} _START_ {{ trans('general.to') }} _END_ {{ trans('general.of') }} _TOTAL_ {{ trans('general.entries') }}";
window.sInfoEmpty = "{{ trans('general.showing') }} 0 {{ trans('general.to') }} 0 {{ trans('general.of') }} 0 {{ trans('general.entries') }}";
window.sSearch = "{{ trans('general.dashboard') }}:";
