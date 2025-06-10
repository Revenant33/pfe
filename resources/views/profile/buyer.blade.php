@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h1>Buyer Profile</h1>
    <p>Welcome, {{ $user->name }} (Buyer)!</p>
    <p>Browse discounted products and your orders (feature coming soon).</p>

    {{-- Default Profile Info Form --}}
    <div class="card mb-4">
        <div class="card-body">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- Default Password Update Form --}}
    <div class="card mb-4">
        <div class="card-body">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Default Delete User Form --}}
    <div class="card">
        <div class="card-body">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>
@endsection
