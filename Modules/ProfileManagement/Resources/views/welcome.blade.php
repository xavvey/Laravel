@extends('layouts.app')

@section('content')
<div class="flex-center position-ref full-height">
    <div class='content'>
        <div class="title m-b-md">
            Profile Management
        </div>
        <a href="{{ route('profiles.index') }}" class="links">Go to Profile Overview</a>
    </div>
</div>


@endsection('content')

