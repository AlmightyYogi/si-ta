@extends('layouts.app')

@section('title', 'Login')

@section('body-class', 'bg-login')

@section('header-text', 'Signed Sistem informasi Aksara Batak Toba')

@section('logo')
<div class="logo-container">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row vh-100">
        {{-- Gambar --}}
        <div class="col-md-5 d-none d-md-block bg-image"></div>

        {{-- Form --}}
        <div class="col-md-7 d-flex align-items-center justify-content-center">
            <div class="w-50">
                <h2 class="text-center mb-4">Sign In</h2>
                
                {{-- Alert Notification --}}
                <div id="alert-container"></div>

                <form id="loginForm">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" required>
                        <div id="username-error" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div id="password-error" class="invalid-feedback"></div>
                    </div>
                    <button type="submit" class="btn btn-custom w-100">Sign In</button>
                </form>
                <p class="mt-3 text-center">Don't have an account? <a href="/register">Register</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('loginForm').addEventListener('submit', async function(event) {
        event.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const alertContainer = document.getElementById('alert-container');
        
        alertContainer.innerHTML = '';

        document.getElementById('username').classList.remove('is-invalid');
        document.getElementById('password').classList.remove('is-invalid');
        document.getElementById('username-error').innerHTML = '';
        document.getElementById('password-error').innerHTML = '';

        const response = await login(username, password);

        if (response.token) {
            localStorage.setItem('token', response.token);
            alertContainer.innerHTML = `
                <div class="alert alert-success" role="alert">
                    Login successful!
                </div>
            `;
            window.location.href = '/dashboard';
        } else {
            if (response.errors) {
                if (response.errors.username) {
                    document.getElementById('username').classList.add('is-invalid');
                    document.getElementById('username-error').innerHTML = response.errors.username.join(', ');
                }
                if (response.errors.password) {
                    document.getElementById('password').classList.add('is-invalid');
                    document.getElementById('password-error').innerHTML = response.errors.password.join(', ');
                }
            }

            alertContainer.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    ${response.message}
                </div>
            `;
        }
    });

    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;

        const icon = type === 'password' ? 'bi-eye' : 'bi-eye-slash';
        togglePassword.querySelector('i').className = `bi ${icon}`;
    });
</script>
@endsection
