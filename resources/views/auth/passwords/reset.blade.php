<!-- resources/views/auth/passwords/reset.blade.php -->

@extends('layouts.auth')

@section('content')
    <div class="container">
        <h2>Masukkan Kata Sandi Baru</h2>

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

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Kata Sandi Baru" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Kata Sandi" required>
            </div>

            <button type="submit" class="btn btn-primary">Reset Kata Sandi</button>
        </form>
    </div>
@endsection
