<?php
$file = $attachment;
$ext = pathinfo($file, PATHINFO_EXTENSION);
?>
<div class="m-widget4">
    <div class="m-widget4__item">
        <div class="m-widget4__img m-widget4__img--icon">
            <img src="assets/admin/app/media/img/files/{{ $ext == 'pdf' ? 'pdf' : 'doc' }}.svg" style="width: 27px; height: 27px;" alt="">
        </div>
        <div class="m-widget4__info">
            <span class="m-widget4__text">
            {{ $attachment }}
            </span>
        </div>
        <div class="m-widget4__ext">
            <a href="{{ asset('uploads/invoices_attachments/' . $attachment) }}" class="m-widget4__icon">
                <i class="la la-download"></i>
            </a>
        </div>
    </div>
</div>