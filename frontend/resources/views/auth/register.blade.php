@extends('layouts.app')

@section('title', 'Register')

@section('body-class', 'bg-register')

@section('header-text', 'Register Sistem informasi Aksara Batak Toba')

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
                <h2 class="text-center mb-4">Sign Up</h2>
                
                {{-- Alert Notification --}}
                <div id="alert-container"></div>

                <form id="registerForm">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullname" required>
                        <div id="fullname-error" class="invalid-feedback"></div>
                    </div>
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

                    <div class="mb-3 form-check">
                        <input type="checkbox" id="termsCheckbox" class="form-check-input">
                        <label class="form-check-label" for="termsCheckbox">By creating an account, you agree to the
                            <a href="/terms" target="_blank">Terms & Conditions</a> and
                            <a href="/privacy-policy" target="_blank">Privacy Policy</a> of
                            Sistem Informasi Aksara Batak Toba.
                        </label>
                    </div>

                    <button type="submit" class="btn btn-custom w-100" id="submitButton" disabled>Create Account</button>
                </form>
                <p class="mt-3 text-center">Already have an account? <a href="/login">Login</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('termsCheckbox').addEventListener('change', function() {
        const submitButton = document.getElementById('submitButton');
        submitButton.disabled = !this.checked;
    });

    document.getElementById('registerForm').addEventListener('submit', async function(event) {
        event.preventDefault();
        const fullname = document.getElementById('fullname').value;
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const alertContainer = document.getElementById('alert-container');
        
        alertContainer.innerHTML = '';

        document.getElementById('fullname').classList.remove('is-invalid');
        document.getElementById('username').classList.remove('is-invalid');
        document.getElementById('password').classList.remove('is-invalid');
        document.getElementById('fullname-error').innerHTML = '';
        document.getElementById('username-error').innerHTML = '';
        document.getElementById('password-error').innerHTML = '';

        const response = await register(fullname, username, password);

        if (response.user) {
            alertContainer.innerHTML = `
                <div class="alert alert-success" role="alert">
                    ${response.message}
                </div>
            `;
            window.location.href = '/login';
        } else {
            if (response.errors) {
                if (response.errors.fullname) {
                    document.getElementById('fullname').classList.add('is-invalid');
                    document.getElementById('fullname-error').innerHTML = response.errors.fullname.join(', ');
                }
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
