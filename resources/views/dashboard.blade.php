@php
    header('Location: ' . route(Auth::user()->getDashboardRouteAttribute()));
@endphp
