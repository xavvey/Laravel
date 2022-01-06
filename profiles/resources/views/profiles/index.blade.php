@extends('layouts.layout')

@section('content')

<div class="flex-center position-ref full-height">
    <div class='content'>
        <div class="title m-b-md">
            Profiles Overview
        </div>
        <p class="mssg">{{ session('mssg') }} </p>
        <table id="profiles-overview">
            <tbody>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
                @foreach($profiles as $profile)
                <tr>
                    <td>{{ $profile->name }}</td>
                    <td>{{ $profile->email }}</td>
                    <td>{{ $profile->phone }}</td>
                    <td>{{ $profile->role }}</td>
                    <td>
                        <form action="{{ route( 'profiles.delete', $profile->id) }}" method="POST">                    
                        @csrf
                        @method('DELETE')
                        <button>Delete Profile</button>
                        </form>
                    </td>
                    <td><a href="{{ route('profiles.index', $profile->id) }}"><button>Edit Profile</button></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('profiles.create') }}" class="links">Create new Profile</a><br>
        <a href="{{ route('profiles') }}" class="links">Back to Home page</a>
    </div>
</div>

@endsection('content')