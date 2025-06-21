<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Quantaminds AI</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --orang-color: #f07d1a;
            --yello: #fab722;
            --Soft-Red: #eb5955;
            --Pink: #c85c9e;
            --Blue-Violet: #5e67ae;
            --violet: #5d4c9a;
            --Dark-blue: #121528;
            --white: #ffffff;
            --p-color: #495057;
            --background: #fdf9f6
        }

        body {
            font-family: 'Cairo', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .login-container {
            background-image: url("{{ asset('quanta-ai/photos/land.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(146deg, rgba(240, 125, 26, 0.6) 0%, rgba(250, 183, 34, 0.6) 17%, rgba(235, 89, 85, 0.6) 38%, rgba(200, 92, 158, 0.6) 58%, rgba(94, 103, 174, 0.6) 75%, rgba(93, 76, 154, 0.6) 88%);
            z-index: 0;
        }

        .login-card {
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 10;
            max-width: 450px;
            width: 100%;
            padding: 2rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header img {
            width: 150px;
            height: auto;
            margin-bottom: 1rem;
        }

        .login-header h2 {
            color: var(--Blue-Violet);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: var(--p-color);
            font-size: 0.9rem;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .form-floating .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 1rem 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-floating .form-control:focus {
            border-color: var(--Blue-Violet);
            box-shadow: 0 0 0 0.2rem rgba(94, 103, 174, 0.25);
        }

        .form-floating label {
            color: var(--p-color);
            font-weight: 500;
        }

        .form-check {
            margin: 1rem 0;
        }

        .form-check-input:checked {
            background-color: var(--Blue-Violet);
            border-color: var(--Blue-Violet);
        }

        .form-check-label {
            color: var(--p-color);
            font-size: 0.9rem;
        }

        .login-btn {
            background-color: var(--Blue-Violet);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 500;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .login-btn:hover {
            background-color: var(--violet);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(94, 103, 174, 0.3);
        }

        .forgot-password {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .forgot-password a {
            color: var(--Blue-Violet);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: var(--violet);
        }

        .register-link {
            text-align: center;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }

        .register-link p {
            color: var(--p-color);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .register-link a {
            color: var(--Blue-Violet);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: var(--violet);
        }

        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .back-home {
            position: absolute;
            top: 2rem;
            right: 2rem;
            z-index: 20;
        }

        .back-home a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-home a:hover {
            color: var(--white);
            transform: translateX(5px);
        }

        @media (max-width: 576px) {
            .login-card {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .back-home {
                top: 1rem;
                left: 1rem;
                right: auto;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- Back to Home -->
    <div class="back-home">
        <a href="{{ route('home') }}">
            <i class="fas fa-arrow-left me-2"></i>
            Back to Home
        </a>
    </div>

    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('quanta-ai/photos/logo.png') }}" alt="Quantaminds AI Logo">
            <h2>Login</h2>
            <p>Welcome to the WhatsApp AI Management System</p>
        </div>

        <!-- Success Message -->
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                <label for="email">
                    <i class="fas fa-envelope me-2"></i>
                    Email Address
                </label>
            </div>

            <!-- Password -->
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">
                    <i class="fas fa-lock me-2"></i>
                    Password
                </label>
            </div>

            <!-- Remember Me -->
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>

            <!-- Login Button -->
            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt me-2"></i>
                Log in
            </button>

            <!-- Forgot Password -->
            <div class="forgot-password">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        <i class="fas fa-key me-1"></i>
                        Forgot your password?
                    </a>
                @endif
            </div>

            <!-- Register Link -->
            <div class="register-link">
                <p>Don't have an account?</p>
                <a href="{{ route('register') }}">
                    <i class="fas fa-user-plus me-1"></i>
                    Request a new service
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>
</html>
