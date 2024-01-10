<a href="{{ route('admin.contacts.edit', ['id' => $id_hash]) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-{{ $btn_edit }} m-btn--icon m-btn--icon-only m-btn--pill tooltips" title="Edit">
    <i class="la la-edit"></i>
</a>
<a data-url="{{ route('admin.contacts.delete',['id' => $id_hash]) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill tooltips delete_btn" title="Delete">
    <i class="la la-trash-o"></i>
</a>