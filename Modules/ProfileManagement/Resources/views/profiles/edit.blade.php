@extends('layouts.app') 

@section('content')

<div class="wrapper create-profile container">
    <h1>Edit Profile: {{ $profile->name }}</h1>
    <p class="mssg">{{ session('mssg') }} </p>
    
    <div class='row justify-content-center align-items-center'>
        @if ($errors->any())
            <div class='alert-message'>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <form action="{{ route('profiles.update', $profile->id) }}" method="POST" enctype='multipart/form-data'>
                @csrf
                @method("PUT")
                <label for="image">Upload image:</label>
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
                @if($profile->hasMedia())
                    @foreach($profile_imgs as $profile_img)
                        <div class='form-check'>
                            <img src="{{ $profile_img->getUrl('thumb') }}" alt="picture overview">
                            <input type="radio" name='select_pic' value='{{ $profile_img->id }}'>
                        </div>
                    @endforeach
                @endif
                <input type="hidden" name="id" value="{{ $profile->id }}">
                <input type="submit" name="edit_profile">
            </form>
        </div>

        <div>
            <h3>Selected Profile picture</h3>
            @if($profile->hasMedia())
            <img src="{{ $profile->media()->where('id', $profile->profile_pic_id)->first()->getUrl('big picture') }}" alt="current profile picture">
            @endif
        </div>

    </div>
    <br><a href="{{ route('profiles.index') }}" class="link">Back to Profile Overview</a>
</div>

@endsection('content')