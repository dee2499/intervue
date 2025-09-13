<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intervue - One-Way Video Interview Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
        .hero-section {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-card {
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            <i class="fas fa-video text-primary me-2"></i>Intervue
        </a>
        <div class="ms-auto">
            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
        </div>
    </div>
</nav>

<section class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">One-Way Video Interview Platform</h1>
        <p class="lead mb-5">Streamline your hiring process with asynchronous video interviews</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">Get Started</a>
            <a href="#" class="btn btn-outline-light btn-lg px-4">Learn More</a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">How It Works</h2>
            <p class="text-muted">Simple three-step process for efficient hiring</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card feature-card h-100 text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-user-tie fa-3x text-primary"></i>
                    </div>
                    <h4>Create Interviews</h4>
                    <p class="text-muted">Admins and reviewers create interviews with custom questions and time limits</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card h-100 text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-video fa-3x text-success"></i>
                    </div>
                    <h4>Candidate Responses</h4>
                    <p class="text-muted">Candidates record and upload video answers to interview questions</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card h-100 text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-star fa-3x text-warning"></i>
                    </div>
                    <h4>Review & Score</h4>
                    <p class="text-muted">Reviewers evaluate submissions and provide scores and feedback</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 text-center">
    <div class="container">
        <h2 class="fw-bold mb-4">Ready to Get Started?</h2>
        <p class="lead mb-4">Join thousands of companies using Intervue for efficient hiring</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">Create Account</a>
    </div>
</section>

<footer class="bg-light py-4">
    <div class="container">
        <div class="text-center">
            <p class="mb-0">Intervue &copy; {{ date('Y') }} - All rights reserved</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
