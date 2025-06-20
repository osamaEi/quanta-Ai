<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quantaminds Ai</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('quanta-ai/style.css') }}">
</head>
<body>

<div class="mainDiv pt-5 pb-5">
    <div class="container">
        <!-- START NAVBAR -->
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <!-- Logo -->
                <div class="d-flex align-items-center">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('quanta-ai/photos/logo.png') }}" alt="logo" class="ps-2">
                    </a>
                </div>
                <div class="text-end">
                    <button class="navbar-toggler ms-auto" type="button"
                     data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent"
                         aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <!-- Navigation Links -->
                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link light-text" href="#Quantapricing">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link light-text" href="#">Demo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link light-text" href="#contact">Contact</a>
                        </li>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link light-text" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link light-text" href="{{ route('register') }}">Register</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link light-text" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                        @endguest
                    </ul>
                </div>

                <!-- Search Button -->
                <div class="d-none d-lg-block">
                    <button class="btn custom-btn" type="button">Search</button>
                </div>
            </div>
        </nav>
        <!-- END NAVBAR -->

        <!-- START LANDING -->
        <div class="landing">
            <div class="text-center w-100">
                <div data-aos="zoom-out-right" class="fade-in">
                    <h1>Embed AI Agents into whatsApp, CRM & DB in minutes</h1>
                    <p class="text-light-50 mt-3">Automate support, sales & data-driven insights no dev—required</p>
                </div>
                <div class="land-btn">
                    <button type="button" class="btn custom-btn">View plans</button>
                    <button type="button" class="btn watch-btn">Watch Demo <i class="fa-regular fa-circle-play"></i></button>
                </div>
            </div>
        </div>
        <!-- END LANDING -->
    </div>
</div>

<!-- marquee universities -->
{{-- <div class="univercities pt-5 pb-5">
    <div class="container">
        <div class="head text-center">
            <h2 class="mb-4">Our Partner Universities</h2>
            <p>We collaborate with top institutions worldwide</p>
        </div>
         <div class="marquee">
        <div class="marquee-content">
            <!-- المجموعة الأولى -->
            <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYMPA3S5R1A2ZD712WPY05J.png" alt=""></div>
            <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYMARY1YG7GY2Z7NBZWG7Y8.png" alt=""> </div>
            <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYJCMH3YHSRYYVVWT7NJSEN.jpg" alt=""></div>
            <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYNCC53G1J6XHQZW8S6S3CX.png" alt=""></div>
            <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JTK4YS88PQHBVQBMG46JBZY8.jpg" alt=""></div>
            <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JW19065HY6D0A3ZZBG4H4237.jpg" alt=""></div>
            <!-- المجموعة الثانية (نسخة مكررة) -->
            <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYMPA3S5R1A2ZD712WPY05J.png" alt=""></div>
            <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYMARY1YG7GY2Z7NBZWG7Y8.png" alt=""> </div>
            <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYJCMH3YHSRYYVVWT7NJSEN.jpg" alt=""></div>
            <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYNCC53G1J6XHQZW8S6S3CX.png" alt=""></div>
            <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JTK4YS88PQHBVQBMG46JBZY8.jpg" alt=""></div>
            <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JW19065HY6D0A3ZZBG4H4237.jpg" alt=""></div>
        </div>
            <!-- الشريط الثاني: من اليسار لليمين -->
        <div class="marquee marquee-reverse">
            <div class="marquee-content">
                <!-- المجموعة الأولى -->
                <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYNCC53G1J6XHQZW8S6S3CX.png" alt=""></div>
                <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JTK4YS88PQHBVQBMG46JBZY8.jpg" alt=""></div>
                <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JW19065HY6D0A3ZZBG4H4237.jpg" alt=""></div>
                <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYMPA3S5R1A2ZD712WPY05J.png" alt=""></div>
                <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYMARY1YG7GY2Z7NBZWG7Y8.png" alt=""> </div>
                <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYJCMH3YHSRYYVVWT7NJSEN.jpg" alt=""></div>
                <!-- المجموعة الثانية (نسخة مكررة) -->
                <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYMPA3S5R1A2ZD712WPY05J.png" alt=""></div>
                <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYJCMH3YHSRYYVVWT7NJSEN.jpg" alt=""></div>
                <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYNCC53G1J6XHQZW8S6S3CX.png" alt=""></div>
                <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JTK4YS88PQHBVQBMG46JBZY8.jpg" alt=""></div>
                <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JVYMARY1YG7GY2Z7NBZWG7Y8.png" alt=""> </div>
                <div class="card"><img src="https://uni-advisor.com/storage/university-logos/01JW19065HY6D0A3ZZBG4H4237.jpg" alt=""></div>
            </div>
        </div>
    </div>
    </div>
</div> --}}
<!-- marquee universities -->

<!-- start section -->
<div class="start-section pt-5 pb-5">
    <div class="container text-center" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
        <p class="start-p">How to</p>
        <h1 class="start-title">How do I get started?</h1>
        <div class="container step-wrapper">
            <div class="row text-center mt-5">
                <div class="col-lg-3 col-md-6 col-sm-6 work-icon text-center">
                    <div class="icon mb-4"><i class="fa-solid fa-credit-card"></i></div>
                    <div class="step-number mb-4"><span class="one">1</span></div>
                    <div class="step-title  mb-4">Subscribe to <span class="start-title">QuantaMinds AI</span></div>
                    <button type="button" class="btn custom-btn mt-lg-5">View plans</button>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 work-icon text-center">
                    <div class="icon mb-4"><i class="fa-solid fa-phone"></i></div>
                    <div class="step-number mb-4"><span class="two">2</span></div>
                    <div class="step-title mb-4">An onboarding manager will contact you within 24 hours</div>
                    <button type="button" class="btn custom-btn mt-lg-4">View kyc requirements</button>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 work-icon">
                    <div class="icon mb-4"><i class="fa-solid fa-laptop"></i></div>
                    <div class="step-number mb-4"><span class="two">3</span></div>
                    <div class="step-title mb-4">Attend our live training</div>
                    <button type="button" class="btn custom-btn mt-lg-5">View training schedules</button>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 work-icon">
                    <div class="icon mb-4"><i class="fa-solid fa-rocket"></i></div>
                    <div class="step-number mb-4 "><span class="two four">4</span></div>
                    <div class="step-title ">Go live</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end section -->

<!-- ready? -->
<div class="ready ">
    <div class="container" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
        <div class="text-center ready-sec pt-5 pb-5">
            <h1>Ready to Begin Your Educational Journey?</h1>
            <p class="text-light-50 pt-3 pb-3">Let our experts guide you through the process of studying abroad. We'll help you find the perfect university match and support you every step of the way.</p>
            <button type="button" class="btn custom-btn">free consultation</button>
            <button class="btn custom-btn">explore universities</button>
        </div>
    </div>
</div>
<!-- ready -->

<!-- start how it work section -->
<div class="HowitWork pt-5 pb-5 text-center" >
    <div class="container" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
        <h1>How <span class="start-title">QuantaMinds AI</span> works</h1>
        <p class="text-black-50">Get you AI Agents up and running in just a few simple steps</p>
        <div class="row g-3 mt-2">
            <div class="col-lg-4 col-md-6">
                <div class="text-center pt-5 pb-5 shadow work-card">
                    <div class="work-icon">
                        <i class="fa-solid fa-plug"></i>
                    </div>
                    <h3 class="mt-4">1. Connect WhatsApp & CRM</h3>
                    <p class="text-black-50">securely integrate your WhatsApp Business account and CRM system using our simple API connections.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="text-center pt-5 pb-5 shadow work-card">
                    <div class="work-icon">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <h3 class="mt-4">2. Build Your AI Agent</h3>
                    <p class="text-black-50">Use our no-code drag-and-drop builder to create intelligent workflows tailored to your business needs</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="text-center pt-5 pb-5 shadow work-card">
                    <div class="work-icon">
                        <i class="fa fa-chart-line"></i>
                    </div>
                    <h3 class="mt-4">3. Go live & Monitor</h3>
                    <p class="text-black-50">deploy instantly and track performance with real-time analytics on our intuitive dashboard.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end how it work section -->

<!-- Blog section -->
<div class="blog pt-5 pb-5">
    <div class="container" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
        <h1 class="mb-4">What's New</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card">
                    <img src="{{ asset('quanta-ai/photos/technology-human-touch-background-modern-remake-creation-adam.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">🧠 The First Signs of AI Burnout Aren't in the Tech — They're in the Team</h5>
                        <p class="card-text">The constant push for automation and speed may be affecting your team more than your systems.</p><p>
We noticed early signals from teams across industries, and here's what leaders can do.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mt-4">
                    <img src="{{ asset('quanta-ai/photos/programming-background-with-person-working-with-codes-computer.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">📈 To Get Smarter, Ask These 3 AI Questions Daily</h5>
                        <p class="card-text">Forget self-help clichés—here's how AI can actually make you think better.</p><p>Simple prompts, deeper reflections, better decisions.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="{{ asset('quanta-ai/photos/futuristic-robot-interacting-with-money.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">💸 How 9 Lines of Prompting Turned into a $10M SaaS Tool</h5>
                        <p class="card-text">It started with an idea to simplify customer service replies. Now it's automating entire workflows.
</p><p>Discover how this founder used GPT to build a tool that major companies rely on daily.
</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog section -->

<!-- pricing section -->
<div class="pricing pt-5 pb-5" id="Quantapricing">
    <div class="container" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
        <div class="text-center mb-5">
            <h1><span class="start-title">QuantaMinds AI</span> Pricing</h1>
            <p>
                Tailored for all business sizes, with customizable options and scalability.
            </p>
            <div class="pricing-toggle d-inline-flex align-items-center">
                <div class="toggle-wrapper">
                    <div class="billing-toggle">
                        <button id="monthlyBtn" class="toggle-btn active">Monthly</button>
                        <button id="yearlyBtn" class="toggle-btn">Yearly</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pricing Cards -->
        <div class="row justify-content-center">
            <!-- Pro Plan -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card pricing-card h-100">
                    <div class="card-body p-4">
                        <h3 class="card-title text-success fw-bold">Pro</h3>
                        <div class="price-section mb-4">
                            <span class="price-currency">US$</span>
                            <span class="price-amount" id="proPrice">149</span>
                            <span class="price-period">per month</span>
                        </div>
                        <p class="card-text text-muted mb-4">For small teams to collaborate better on chats</p>
                        
                        <button class="book-btn  w-100 mb-4">Book a Demo</button>
                        
                        <div class="support-badge text-success mb-4">
                            <i class="fas fa-check-circle me-2"></i>
                            Free onboarding support
                        </div>
                        
                        <h6 class="fw-bold mb-3">Includes</h6>
                        <ul class="feature-list">
                            <li><i class="fas fa-check text-primary me-2"></i>3 user accounts</li>
                            <li><i class="fas fa-check text-primary me-2"></i>2,000 contacts</li>
                            <li><i class="fas fa-check text-primary me-2"></i>3 Flow Builder active flows</li>
                            <li><i class="fas fa-check text-primary me-2"></i>Support via email</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card pricing-card premium-card h-100">
                    <div class="popular-badge">MOST POPULAR</div>
                    <div class="card-body p-4">
                        <h3 class="card-title pric-icon fw-bold">Premium</h3>
                        <div class="price-section mb-4">
                            <span class="price-currency">US$</span>
                            <span class="price-amount" id="premiumPrice">349</span>
                            <span class="price-period">per month</span>
                        </div>
                        <p class="card-text text-muted mb-4">For scaling businesses to automate workflows</p>
                        
                        <button class="book-btn-custom w-100 mb-4">Book a Demo</button>
                        
                        <div class="support-badge pric-icon mb-4">
                            <i class="fas fa-check-circle me-2"></i>
                            Free onboarding support
                        </div>
                        
                        <h6 class="fw-bold mb-3">Includes</h6>
                        <ul class="feature-list">
                            <li><i class="fas fa-check pric-icon me-2"></i>5 user accounts</li>
                            <li><i class="fas fa-check pric-icon me-2"></i>10,000 contacts</li>
                            <li><i class="fas fa-check pric-icon me-2"></i>25 Flow Builder active flows</li>
                            <li><i class="fas fa-check pric-icon me-2"></i>Support via chats and email</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Enterprise Plan -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card pricing-card h-100">
                    <div class="card-body p-4">
                        <h3 class="card-title text-warning fw-bold">Enterprise</h3>
                        <div class="price-section mb-4">
                            <span class="price-custom">Custom</span>
                        </div>
                        <p class="card-text text-muted mb-4">For large businesses to build tailored solutions</p>
                        
                        <button class="book-btn w-100 mb-4">Book a Demo</button>
                        
                        <div class="support-badge text-warning mb-4">
                            <i class="fas fa-check-circle me-2"></i>
                            Free onboarding support
                        </div>
                        
                        <h6 class="fw-bold mb-3">Includes</h6>
                        <ul class="feature-list">
                            <li><i class="fas fa-check text-primary me-2"></i>Custom number of user accounts</li>
                            <li><i class="fas fa-check text-primary me-2"></i>Custom number of contacts</li>
                            <li><i class="fas fa-check text-primary me-2"></i>50 Flow Builder active flows</li>
                            <li><i class="fas fa-check text-primary me-2"></i>Dedicated customer success</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- pricing section -->

<!-- testimonial -->
<div class="testimonials-section">
    <div class="container">
        <div class="section-title">
            <h2>What Our Clients Say</h2>
            <p>Discover our clients' success stories and how we helped them achieve their goals</p>
        </div>
    </div>

    <!-- First Row -->
    <div class="marquee-container">
        <div class="marquee-row" id="row1">
            <!-- Testimonials will be populated by JavaScript -->
        </div>
    </div>

    <!-- Second Row -->
    <div class="marquee-container">
        <div class="marquee-row" id="row2" style="animation-direction: reverse;">
            <!-- Testimonials will be populated by JavaScript -->
        </div>
    </div>
</div>
<!-- testimonial -->

<!-- contacts -->
<div class="contac pt-5 pb-5" id="contact">
    <div class="container" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="small-card p-5">
                    <h2>contact us</h2>
                    <div class="adress">
                        <p><i class="fa-solid fa-location-dot me-2"></i>
                        42 Sunset Valley Street, Brooktown, CA 90210, USA
                        </p>
                        <p><i class="fa-solid fa-envelope me-1"></i> emerald.sparrow97@example.com</p>
                        <p><i class="fa-solid fa-phone me-2"></i> 45829371
                        </p>
                        <p><i class="me-2">🖨️</i>   92760418
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-6 col-sm-6">
                <div class="main-card shadow p-5">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-lg-4">
                        </div>
                        <form class="col-lg-8" action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class=" text-center ">
                                <h2>GET in touch</h2>
                                <p>feel free to drop us in below!</p>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">name</label>
                                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required value="{{ old('email') }}">
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control" required value="{{ old('subject') }}">
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" name="message" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" required>{{ old('message') }}</textarea>
                                <label for="floatingTextarea2">type your message here</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contacts -->

<!-- DoubleTick -->
<div class="DoubleTick pt-5 pb-5">
    <div class="container" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
        <div class="row d-flex align-items-center">
            <div class="col-lg-8">
                <h1>7x your sales with <span class="start-title">QuantaMinds AI</span> powered by WhatsApp Business API</h1>
                <p>Our team will onboard you and help in setting up your account for free</p>
                <button type="button" class="btn custom-btn">Get a demo</button>
                <button class="custom-btn2">view plans</button>
            </div>
            <div class="col-lg-4">
                <img src="https://doubletick.io/_next/static/media/cta-img.a5714ce3.webp" class="img-fluid img" alt="CTA Image">
            </div>
        </div> 
    </div>
</div>
<!-- DoubleTick -->

<!-- footer -->
<div class="footer pt-5 pb-5">
    <div class="container mt-5">
        <div class="row ">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-brand" data-aos="fade-up">
                    <img src="{{ asset('quanta-ai/photos/logo footer.png') }}" alt="logo" class="ps-2 img-fluid">                    
                    <p class="foot-text">Embed AI Agents into WhatsApp, CRM & DB in minutes. Automate support, sales & data-driven insights—no dev required.</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-title" data-aos="fade-up" data-aos-delay="100">Product</h5>
                <ul class="footer-links">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#demo">Demo</a></li>
                    <li><a href="#">API</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-title" data-aos="fade-up" data-aos-delay="200">Company</h5>
                <ul class="footer-links">
                    <li><a href="#">About</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-title" data-aos="fade-up" data-aos-delay="300">Support</h5>
                <ul class="footer-links">
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Training</a></li>
                    <li><a href="#">Status</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-title" data-aos="fade-up" data-aos-delay="400">Connect</h5>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="footer-copyright">&copy; 2024 QuantaMinds AI. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer -->

<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<script src="{{ asset('quanta-ai/script.js') }}"></script>

<script>
    AOS.init();
    const testimonials = [
    {
        stars: 5,
        title: "Excited to see new features coming",
        text: "We already use it to answer common HR questions, and it saves us a lot of time. But what we're really looking forward to are the automations! The advisor told us we could soon post job offers, sort CVs, and even automate certain HR tasks. Really excited to see what's next.",
        author: "Stephanie R.",
        role: "Administrative Manager",
        avatar: "S"
    },
    {
        stars: 5,
        title: "John literally saved my networks",
        text: "I give him an idea, he creates the visual, the caption and programs everything for me during the week. My audience doubled in 2 months.",
        author: "Irene R.",
        role: "Jewelry Designer",
        avatar: "I"
    },
    {
        stars: 5,
        title: "Ultra simple implementation",
        text: "What I liked about Limova is that the implementation is so simple. Where other AI agent tools get bogged down in complexity, Limova gets straight to the point.",
        author: "Marcus T.",
        role: "Tech Lead",
        avatar: "M"
    },
    {
        stars: 5,
        title: "Thanks to Lou, we tripled our SEO traffic in three months",
        text: "She publishes an article per day on our blog, with regularity and quality that we had never achieved before on the internet.",
        author: "David L.",
        role: "Marketing Director",
        avatar: "D"
    },
    {
        stars: 5,
        title: "Outstanding customer support",
        text: "The technical support is available 24/7 and the team is very professional. They solved all my problems in record time.",
        author: "Sarah M.",
        role: "Business Owner",
        avatar: "S"
    },
    {
        stars: 5,
        title: "Results exceeded expectations",
        text: "After using the service for 3 months, our sales increased by 150% and team efficiency improved significantly.",
        author: "Michael H.",
        role: "Company Owner",
        avatar: "M"
    },
    {
        stars: 5,
        title: "Easy to use interface",
        text: "Simple and straightforward interface, doesn't require much technical expertise. I was able to master the system in just one week.",
        author: "Emma A.",
        role: "Marketing Manager",
        avatar: "E"
    },
    {
        stars: 5,
        title: "Time and effort saver",
        text: "It saved us hours of daily work. Complex tasks are now completed with the click of a button.",
        author: "James W.",
        role: "Web Developer",
        avatar: "J"
    },
    {
        stars: 5,
        title: "Profitable investment",
        text: "The return on investment was better than I expected. I was able to recover the cost in just two months.",
        author: "Lisa S.",
        role: "Financial Manager",
        avatar: "L"
    },
    {
        stars: 5,
        title: "High security and reliability",
        text: "Our data is completely secure and the system works without any problems. We haven't experienced any service interruptions since the beginning.",
        author: "Robert Y.",
        role: "Technical Manager",
        avatar: "R"
    },
    {
        stars: 5,
        title: "Continuous updates",
        text: "The team continuously develops the product and adds new features based on user suggestions.",
        author: "Anna M.",
        role: "Operations Manager",
        avatar: "A"
    },
    {
        stars: 5,
        title: "Outstanding team",
        text: "Working with the team was great from the start. High professionalism and quick response to inquiries.",
        author: "Daniel H.",
        role: "Startup Founder",
        avatar: "D"
    }
];

function createTestimonialCard(testimonial) {
    const stars = '<i class="fas fa-star"></i>'.repeat(testimonial.stars);
    
    return `
        <div class="testimonial-card">
            <div class="testimonial-content">
                <div class="stars">${stars}</div>
                <h5 class="testimonial-title">${testimonial.title}</h5>
                <p class="testimonial-text">${testimonial.text}</p>
            </div>
            <div class="testimonial-author">
                <div class="author-avatar">${testimonial.avatar}</div>
                <div class="author-info">
                    <h6>${testimonial.author}</h6>
                    <span>${testimonial.role}</span>
                </div>
            </div>
        </div>
    `;
}

function populateRow(rowId, startIndex, repetitions = 4) {
    const row = document.getElementById(rowId);
    let html = '';
    
    // Create multiple copies for seamless loop
    for (let rep = 0; rep < repetitions; rep++) {
        for (let i = 0; i < testimonials.length; i++) {
            const testimonialIndex = (startIndex + i) % testimonials.length;
            html += createTestimonialCard(testimonials[testimonialIndex]);
        }
    }
    
    row.innerHTML = html;
}

// Populate rows with different starting points for variety
populateRow('row1', 0);
populateRow('row2', 4);

</script>

</body>
</html> 