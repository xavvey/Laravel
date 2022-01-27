@extends('layouts.app') 

@section('content')

<div class="wrapper create-profile">
    <h1>Edit Profile: {{ $profile->name }}</h1>

    @if ($errors->any())
        <div class='alert-message'>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <p class="mssg">{{ session('mssg') }} </p>
    <form action="{{ route('profiles.update', $profile->id) }}" method="POST" enctype='multipart/form-data'>
        @csrf
        @method("PUT")
        <label for="image">Profile image:</label>
        <input type="file" id="image" name="image">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ $profile->name }}">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ $profile->email }}">
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="{{ $profile->phone }}">
        <label for="role">Role:</label>
        <select name="role" id="role">
            <option disabled selected>{{ ucfirst($user_role->name) }}</option>
            @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
            @endforeach
        </select>
        <input type="hidden" name="id" value="{{ $profile->id }}">
        <input type="submit" name="submit">
    </form>
    @foreach($profile_imgs as $profile_img)
        <img src="{{ $profile_img->getUrl('thumb') }}" alt="Small profile picture">
    @endforeach
    <br><a href="{{ route('profiles.index') }}" class="link">Back to Profile Overview</a>
</div>

@endsection('content')