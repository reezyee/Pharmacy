<!-- resources/views/auth/forgot-password.blade.php -->

@extends('layouts.auth')

@section('content')
    <div class="container">
        <h2>Lupa Kata Sandi</h2>

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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan Email Anda" required>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Link Reset</button>
        </form>
    </div>
@endsection
