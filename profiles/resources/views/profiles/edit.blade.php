@extends('layouts.layout')

@section('content')

<div class="wrapper create-profile">
    <h1>Edit Profile: {{ $profile->name }}</h1>
    <form action="{{ route('profiles.update', $profile->id) }}" method="POST">
        @csrf
        @method("PUT")
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ $profile->name }}">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ $profile->email }}">
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="{{ $profile->phone }}">
        <label for="role">Role:</label>
        <select name="role" id="role">
            <option value="Admin">Admin</option>
            <option value="Power user">Power user</option>
            <option value="User">User</option>
            <option value="{{ $profile->role }}" selected>{{ $profile->role }}</option>
        </select>
        <input type="hidden" name="id" value="{{ $profile->id }}">
        <input type="submit" name="submit"></input>
    </form>
    <br><a href="{{ route('profiles.index') }}" class="link">Back to Profile Overview</a>
</div>

@endsection('content')