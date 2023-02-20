<!DOCTYPE html>
<html lang="th">

@include('components.header')

@if (!Request::is('/'))
    @include('components.navbar')
@endif

<body >
    <div class="py-5">
        @if (Request::is('/'))
            @include('pages.home')
        @elseif(Request::is('home'))
            @include('pages.main')
        @elseif(Request::is('test'))
            test
        @endif

    </div>
</body>
@include('components.footer')

</html>
