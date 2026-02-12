<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PVM</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background:
                linear-gradient(
                    rgba(0, 0, 0, 0.55),
                    rgba(0, 0, 0, 0.55)
                ),
                url("{{ asset('assets/images/footer.jpg') }}")
                center / cover no-repeat;

            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 18px;
            padding: 35px 30px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo img {
            width: 180px;
            margin: 0 auto 20px;
            display: block;
        }

        .login-card h4 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .login-card p {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 25px;
        }

        .form-control {
            padding: 12px;
            border-radius: 10px;
        }

        .btn-primary {
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            background: linear-gradient(135deg, #ff0000, #fc0000);
            border: none;
        }

        .btn-primary:hover {
            opacity: 0.95;
        }

        .remember {
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <!-- LOGO -->
        <div class="logo">
            <!-- <img src="./assets/images/new-images/logo.png" alt="PVM"> -->
            <img src="{{ asset('assets/images/new-images/logo.png') }}" alt="PVM">

        </div>

        <h4 class="text-center">Welcome</h4>
        <p class="text-center">Sign in to continue</p>

        <form method="POST" action="{{ route('login.check') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email" required placeholder="Enter your email">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required placeholder="Enter your password">
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Login
            </button>
        </form>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
