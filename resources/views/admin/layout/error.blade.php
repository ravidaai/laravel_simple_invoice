@if(Session::has('success'))
    <div class="m-section__content">
        <div class="alert alert-brand alert-dismissible fade show   m-alert m-alert--square m-alert--air" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            <strong>
                Well done!
            </strong>
            @if(is_object(Session::get('success')))
                @foreach (Session::get('success')->all(':message') as $message)
                    {{ $message }}
                    <br>
                @endforeach
            @else
                {{ Session::get('success') }}
            @endif
        </div>
    </div>
@elseif(Session::has('danger'))
    <div class="alert alert-danger alert-dismissible fade show   m-alert m-alert--air" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <strong>
            Oh snap!<br>
        </strong>
        @if(is_object(Session::get('danger')))
            @foreach (Session::get('danger')->all(':message') as $message)
                {{ $message }}
                <br>
            @endforeach
        @else
            {{ Session::get('danger') }}
        @endif
    </div>
@elseif(Session::has('warning'))
    <div class="alert alert-warning alert-dismissible fade show   m-alert m-alert--air" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <strong>
            Warning!
        </strong>
        @if(is_object(Session::get('warning')))
            @foreach (Session::get('warning')->all(':message') as $message)
                {{ $message }}
                <br>
            @endforeach
        @else
            {{ Session::get('warning') }}
        @endif
    </div>
@elseif(Session::has('info'))
    <div class="alert alert-accent alert-dismissible fade show   m-alert m-alert--square m-alert--air" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <strong>
            Info!
        </strong>
        @if(is_object(Session::get('info')))
            @foreach (Session::get('info')->all(':message') as $message)
                {{ $message }}
            @endforeach
        @else
            {{ Session::get('info') }}
        @endif
    </div>
@endif
