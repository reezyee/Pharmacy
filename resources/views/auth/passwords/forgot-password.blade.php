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

        <form method="POST" action="{{ url('/forgot-password') }}">
            @csrf
            <input type="email" name="email" required placeholder="Masukkan email Anda">
            <button type="submit">Kirim Link Reset</button>
        </form>        
        @if (session('status'))
            <p>{{ session('status') }}</p>
        @endif
                    
    </div>
@endsection
