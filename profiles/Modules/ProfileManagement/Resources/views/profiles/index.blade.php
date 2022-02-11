@extends('layouts.app')

@section('content')

<div class="flex-center position-ref full-height">
    <div class='content'>
        <div class="title m-b-md">
            Profiles Overview
        </div>
        <p class="mssg">{{ session('mssg') }} </p>

        <div class='input-group mb-3 justify-content-center align-items-center'>
            <div class='input-group-prepend'>
                <form action="{{ route('profiles.index') }}" method=get>
                    <label for="role">Role:</label>
                    <select name="role" id="role">
                        <option disabled selected>Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" value="Filter" class='mr-1'>Filter</button>
                </form>
                <form action="{{ route('profiles.index') }}">
                    <button type="submit" value="Reset filter" class='mr-1'>Reset</button>
                </form>
            </div>
        </div>

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
                        <td>
                            @if($user->profile->hasMedia())
                                <img src="{{ $user->profile->media()->where('id', $user->profile->profile_pic_id)->first()->getUrl('thumb') }}">
                            @endif
                        </td>
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