<!-- resources/views/auth/confirm-password.blade.php -->

@extends('layouts.auth')

@section('content')
    <div class="container">
        <h2>Konfirmasi Kata Sandi</h2>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-group">
                <label for="password">Masukkan Kata Sandi Anda</label>
                <input type="password" name="password" class="form-control" required autocomplete="current-password">
            </div>

            <button type="submit" class="btn btn-primary">Konfirmasi</button>
        </form>
    </div>
@endsection
