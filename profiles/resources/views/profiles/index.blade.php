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
                <option value="admin">Admin</option>
                <option value="power user">Power user</option>
                <option value="user">User</option>
            </select>
            <input type="submit">
        </form>
        <table id="profiles-overview">
            <tbody>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    @can('delete all profiles')
                    <th>Delete</th>
                    <th>Edit</th>
                    @endcan
                </tr>
                @foreach($profiles as $profile)
                <tr>
                    <td>{{ $profile->name }}</td>
                    <td>{{ $profile->email }}</td>
                    <td>{{ $profile->phone }}</td>
                    <td>{{ $profile->role }}</td>
                    @can('delete all profiles')
                    <td>
                        <form action="{{ route( 'profiles.delete', $profile->id) }}" method="POST">                    
                        @csrf
                        @method('DELETE')
                        <button>Delete Profile</button>
                        </form>
                    </td>
                    <td><a href="{{ route('profiles.edit', $profile->id) }}"><button>Edit Profile</button></a></td>
                    @endcan
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $profiles->withQueryString()->links() }}
        <div>
            <a href="{{ route('profiles.create') }}" class="links">Create new Profile</a>
            <a href="{{ route('profiles') }}" class="links">Back to Home page</a>
        </div>
    </div>
</div>

@endsection('content')