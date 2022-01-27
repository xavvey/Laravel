@extends('layouts.app')

@section('content')

<div class="flex-center position-ref full-height">
    <div class='content'>
        <div class="title m-b-md">
            Profiles Overview
        </div>

        <p class="mssg">{{ session('mssg') }} </p>
        <form action="{{ route('profiles.index') }}" method=get>
            <label for="role">Role:</label>
            <select name="role" id="role">
                <option disabled selected>Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
            <input type="submit" value="Filter">
        </form>

        <form action="{{ route('profiles.index') }}">
            <input type="submit" value="Reset filter">
        </form>

        <table id="profiles-overview">
            <tbody>
                <tr>
                    <th>Profile image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td><img src="{{ $user->profile->getFirstMediaUrl() }}" alt=""></td>
                        <td>{{ $user->profile->name }}</td>
                        <td>{{ $user->profile->email }}</td>
                        <td>{{ $user->profile->phone }}</td>
                        @foreach ($user->roles as $role)
                            <td>{{ucFirst($role->name) }}</td>
                        @endforeach
                        <td>
                            <form action="{{ route( 'profiles.delete', $user->id) }}" method="POST">                    
                            @csrf
                            @method('DELETE')
                            <button>Delete Profile</button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('profiles.edit', $user->profile->id) }}">
                            <button>Edit Profile</button>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        {{ $users->withQueryString()->links() }}

        <div>
            <a href="{{ route('profiles.create') }}" class="links">Create new Profile</a>
            <a href="{{ route('profiles') }}" class="links">Back to Home page</a>
        </div>
    </div>
</div>

@endsection('content')