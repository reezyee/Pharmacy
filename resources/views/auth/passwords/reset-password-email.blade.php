<!-- resources/views/emails/reset-password-email.blade.php -->

<p>Halo,</p>

<p>Anda menerima email ini karena kami menerima permintaan reset kata sandi untuk akun Anda.</p>

<p>Klik tautan berikut untuk mereset kata sandi Anda:</p>

<p>
    <a href="{{ url(route('password.reset', ['token' => $token, 'email' => $email])) }}">
        Reset Kata Sandi
    </a>
</p>

<p>Jika Anda tidak meminta reset kata sandi, abaikan email ini.</p>

<p>Terima kasih,<br>
{{ config('app.name') }}</p>
