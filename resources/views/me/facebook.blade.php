@extends('layouts.main')
@section('body-id', 'profile')

@section('content')
<div class="d-flex flex-nowrap">
    <div class="col-auto col-3 p-5">
        @section('settings.facebook', 'active')
        @include('me.navigation')
    </div>
    <div class="col border-start min-vh-100 p-5">
        <h2>{{ _gettext('Facebook') }}</h2>
    @if($photo)
        <div class="mb-3">
            <img src="{{ $photo }}">
        </div>
        <p>
            <a href="{{ $url }}">{{ _gettext('Logout') }}</a>
        </p>
    @else
        <p>
            <a href="{{ $url }}">{{ _gettext('Connect to Facebook') }}</a>
        </p>
    @endif
    </div>
</div>
@endsection
