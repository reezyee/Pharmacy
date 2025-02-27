<!-- resources/views/auth/reset-password.blade.php -->

@extends('layouts.auth')

@section('content')
    <div class="container">
        <h2>Reset Kata Sandi</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Password Baru</label>
            <input type="password" name="password" required>
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>
            <button type="submit">Reset Password</button>
        </form>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        @endif
        
        
    </div>
@endsection
