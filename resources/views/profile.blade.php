@extends('layouts.admin')
@section('content')
<div class="content-body">
    <div class="container-fluid">
       <div class="row">
           <div class="col-lg-12">
               <div class="card">
                    <h4 class="card-header">User Profile</h4>
                    <div class="card-body">
                        <!-- Display Success Messages -->
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- Display Validation Errors -->
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Update Profile Form -->
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="profile_image">Profile Image</label>
                                <input type="file" id="profile_image" name="profile_image" class="form-control">
                                @if($user->profile_image)
                                    <img src="{{ asset('storage/'.$user->profile_image) }}" alt="Profile Image" width="100" class="mt-2">
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>

                        <hr>

                        <!-- Change Password Form -->
                        <form action="{{ route('profile.change-password') }}" method="POST">
                            @csrf
                            <h4>Change Password</h4>
                            <div class="mb-3">
                                <label for="current_password">Current Password</label>
                                <input type="password" id="current_password" name="current_password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="new_password">New Password</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="new_password_confirmation">Confirm New Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-danger">Change Password</button>
                        </form>
                    </div>
               </div>
           </div>
       </div>
    </div>
</div>
@endsection
