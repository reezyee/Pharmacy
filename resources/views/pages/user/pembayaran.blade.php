@extends('layouts.app')
@section('content')
    <form action="{{ route('orders.uploadProof', $order->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="payment_proof">Upload Bukti Pembayaran:</label>
        <input type="file" name="payment_proof" required>
        <button type="submit">Upload</button>
    </form>

    @if ($order->payment_proof)
        <p>Bukti pembayaran telah diunggah:</p>
        <img src="{{ asset('storage/payments/' . $order->payment_proof) }}" alt="Bukti Pembayaran" width="200">
    @endif
@endsection
