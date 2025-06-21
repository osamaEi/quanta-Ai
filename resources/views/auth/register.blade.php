<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Service Request - Quantaminds AI</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .register-container {
            background-image: url("{{ asset('quanta-ai/photos/land.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .register-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(146deg, rgba(240, 125, 26, 0.6) 0%, rgba(250, 183, 34, 0.6) 17%, rgba(235, 89, 85, 0.6) 38%, rgba(200, 92, 158, 0.6) 58%, rgba(94, 103, 174, 0.6) 75%, rgba(93, 76, 154, 0.6) 88%);
            z-index: 0;
        }

        .register-card {
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 10;
            max-width: 600px;
            width: 100%;
            padding: 2rem;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-header img {
            width: 150px;
            height: auto;
            margin-bottom: 1rem;
        }

        .register-header h2 {
            color: var(--Blue-Violet);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .register-header p {
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

        .register-btn {
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

        .register-btn:hover {
            background-color: var(--violet);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(94, 103, 174, 0.3);
        }

        .login-link {
            text-align: center;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }

        .login-link p {
            color: var(--p-color);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .login-link a {
            color: var(--Blue-Violet);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
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

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .back-home {
            position: absolute;
            top: 2rem;
            left: 2rem;
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
            transform: translateX(-5px);
        }

        .password-requirements {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            color: var(--p-color);
        }

        .password-requirements h6 {
            color: var(--Blue-Violet);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .password-requirements ul {
            margin-bottom: 0;
            padding-left: 1.2rem;
        }

        .password-requirements li {
            margin-bottom: 0.25rem;
        }

        .service-info {
            background: linear-gradient(135deg, var(--Blue-Violet), var(--violet));
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .service-info h4 {
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .service-info ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .service-info li {
            margin-bottom: 0.5rem;
            padding-left: 1.5rem;
            position: relative;
        }

        .service-info li:before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--yello);
            font-weight: bold;
        }

        @media (max-width: 576px) {
            .register-card {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .back-home {
                top: 1rem;
                left: 1rem;
            }
        }
    </style>
</head>
<body>

<div class="register-container">
    <!-- Back to Home -->
    <div class="back-home">
        <a href="{{ route('home') }}">
            <i class="fas fa-arrow-left me-2"></i>
            Back to Home
        </a>
    </div>

    <div class="register-card">
        <div class="register-header">
            <img src="{{ asset('quanta-ai/photos/logo.png') }}" alt="Quantaminds AI Logo">
            <h2>WhatsApp AI Service Request</h2>
            <p>Join us and get a smart assistant for your customer service via WhatsApp</p>
        </div>

        <!-- Service Information -->
        <div class="service-info">
            <h4><i class="fas fa-robot me-2"></i>Service Features</h4>
            <ul>
                <li>24/7 instant response to your customers</li>
                <li>Smart assistant that speaks Arabic</li>
                <li>Advanced conversation management</li>
                <li>Detailed reports and statistics</li>
                <li>Easy to use and control</li>
            </ul>
        </div>

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

        <!-- Success Message -->
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Company Name -->
            <div class="form-floating">
                <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name" value="{{ old('company_name') }}" required autofocus>
                <label for="company_name">
                    <i class="fas fa-building me-2"></i>
                    Company Name
                </label>
            </div>

            <!-- Contact Person Name -->
            <div class="form-floating">
                <input type="text" class="form-control" id="name" name="name" placeholder="Contact Person Name" value="{{ old('name') }}" required>
                <label for="name">
                    <i class="fas fa-user me-2"></i>
                    Contact Person Name
                </label>
            </div>

            <!-- Email Address -->
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                <label for="email">
                    <i class="fas fa-envelope me-2"></i>
                    Email Address
                </label>
            </div>

            <!-- Phone Number -->
            <div class="form-floating">
                <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number') }}" required>
                <label for="phone_number">
                    <i class="fas fa-phone me-2"></i>
                    Phone Number
                </label>
            </div>

            <!-- WhatsApp Number -->
            <div class="form-floating">
                <input type="tel" class="form-control" id="whatsapp_number" name="whatsapp_number" placeholder="WhatsApp Number" value="{{ old('whatsapp_number') }}" required>
                <label for="whatsapp_number">
                    <i class="fab fa-whatsapp me-2"></i>
                    WhatsApp Number
                </label>
            </div>

            <!-- Business Type -->
            <div class="form-floating">
                <select class="form-control" id="business_type" name="business_type" required>
                    <option value="">Select Business Type</option>
                    <option value="retail" {{ old('business_type') == 'retail' ? 'selected' : '' }}>Retail</option>
                    <option value="wholesale" {{ old('business_type') == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                    <option value="services" {{ old('business_type') == 'services' ? 'selected' : '' }}>Services</option>
                    <option value="manufacturing" {{ old('business_type') == 'manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                    <option value="restaurant" {{ old('business_type') == 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                    <option value="healthcare" {{ old('business_type') == 'healthcare' ? 'selected' : '' }}>Healthcare</option>
                    <option value="education" {{ old('business_type') == 'education' ? 'selected' : '' }}>Education</option>
                    <option value="other" {{ old('business_type') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                <label for="business_type">
                    <i class="fas fa-briefcase me-2"></i>
                    Business Type
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

            <!-- Password Requirements -->
            <div class="password-requirements">
                <h6><i class="fas fa-info-circle me-1"></i>Password Requirements:</h6>
                <ul>
                    <li>At least 8 characters long</li>
                    <li>Contains at least one uppercase letter</li>
                    <li>Contains at least one lowercase letter</li>
                    <li>Contains at least one number</li>
                    <li>Contains at least one special character</li>
                </ul>
            </div>

            <!-- Confirm Password -->
            <div class="form-floating">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                <label for="password_confirmation">
                    <i class="fas fa-lock me-2"></i>
                    Confirm Password
                </label>
            </div>

            <!-- Terms and Conditions -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                <label class="form-check-label" for="terms">
                    I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="register-btn">
                <i class="fas fa-paper-plane me-2"></i>
                Submit Service Request
            </button>

            <!-- Info Alert -->
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Note:</strong> Your request will be reviewed by management and you will receive a response within 24 hours. Make sure to verify your account via email.
            </div>

            <!-- Login Link -->
            <div class="login-link">
                <p>Already have an account?</p>
                <a href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt me-1"></i>
                    Sign In
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>
</html>
