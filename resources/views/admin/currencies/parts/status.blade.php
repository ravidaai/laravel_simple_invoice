@if($status == 0)
    <span class="m-badge m-badge--danger m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-danger">Disable</span>
@elseif($status == 1)
    <span class="m-badge m-badge--brand m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-brand">Enable</span>
@endif