@extends('layouts.app')

@section('content')
<div class="container-fluid hero-section homepage">
    <h1>Stay Organized, Stay Productive With Vault</h1>
    <h5>Manage your data efficiently and achieve your goals effortlessly.</h5>
    <div>

        @auth
            @if (auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn btn-custom btn-login">Dashboard</a>
            @else
            <a href="{{ route('user.dashboard') }}" class="btn btn-custom btn-login">Dashboard</a>
            @endif
            <a href="{{ route('public.document') }}" class="btn btn-custom btn-browse">Browse</a>
        
                
        @endauth

     @guest
     <a href="/login" class="btn btn-custom btn-login">Login</a>
     <a href="/register" class="btn btn-custom btn-register">Register</a>
     <a href="{{ route('public.document') }}" class="btn btn-custom btn-browse">Browse</a>
     @endguest
    </div>
</div>
@endsection