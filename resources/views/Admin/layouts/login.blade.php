<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | AnNi's Kitchen</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Reset & Fonts */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body,
        html {
            height: 100%;
        }

        /* Background Gradient */
        body {
            background: linear-gradient(135deg, #80004b, #a01463);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Floating Shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            filter: blur(80px);
            animation: float 10s infinite alternate;
        }

        .shape1 {
            width: 250px;
            height: 250px;
            top: -50px;
            left: -50px;
        }

        .shape2 {
            width: 200px;
            height: 200px;
            top: 150px;
            right: -80px;
        }

        .shape3 {
            width: 350px;
            height: 350px;
            bottom: -120px;
            left: -120px;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            100% {
                transform: translateY(40px);
            }
        }

        /* Container */
        .login-container {
            display: flex;
            width: 900px;
            height: 500px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        /* Left Side */
        .login-left {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff;
        }

        .login-left img.sidebar-logo {
            width: 160px;
            margin-bottom: 25px;
        }

        .login-left p {
            font-size: 1rem;
            line-height: 1.5;
            color: #f0f0f0;
        }

        /* Right Side */
        .login-right {
            flex: 1.5;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
        }

        /* Login Form */
        .login-form {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.1);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }

        .login-form h2 {
            margin-bottom: 25px;
            color: #ffdd57;
            font-weight: 700;
            font-size: 1.8rem;
            text-align: center;
        }

        .login-form input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 1rem;
        }

        .login-form input::placeholder {
            color: #f0f0f0;
        }

        .login-form button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #ffdd57;
            color: #80004b;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-form button:hover {
            background: #e6c846;
        }

        .login-form a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #fff;
            font-size: 0.85rem;
            text-decoration: underline;
        }

        /* Error Message */
        .error-msg {
            color: #ff6b6b;
            text-align: center;
            margin-bottom: 15px;
            display: none;
        }

        /* Responsive */
        @media(max-width: 900px) {
            .login-container {
                flex-direction: column;
                width: 90%;
                height: auto;
            }

            .login-left,
            .login-right {
                flex: unset;
                padding: 30px;
            }
        }
    </style>
</head>

<body>
    <!-- Floating shapes -->
    <div class="shape shape1"></div>
    <div class="shape shape2"></div>
    <div class="shape shape3"></div>

    <div class="login-container">
        <!-- Left Content -->
        <div class="login-left">
            <img src="{{ asset('asset/img/anni-logo.png') }}" class="sidebar-logo" alt="Logo">
            <p style="color: #e9c44d;">• Pure Quality </p>
            <p style="color: #e9c44d;">• Fast Delivery </p>
            <p style="color: #e9c44d;">• Customer Support </p>
        </div>

        <!-- Right Form -->
        <div class="login-right">
            <form class="login-form" id="loginForm">
                @csrf
                <h2>Welcome Back</h2>
                <div class="error-msg" id="errorMsg"></div>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" id="passwordInput"
                        class="form-control" placeholder="••••••••" required style="padding-right: 45px;">
                    <i class="bi bi-eye password-toggle-icon" id="togglePassword"></i>
                <button type="submit">Proceed to My Account</button>
                {{-- <a href="#">Forgot Password?</a> --}}
            </form>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let button = this.querySelector("button[type='submit']");

        // Show loading
        button.disabled = true;
        button.innerHTML = "Please wait...";

        fetch("{{ route('login.submit') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {

                button.disabled = false;
                button.innerHTML = "SIGN IN";

                if (data.status === true) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = data.redirect;
                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: data.message
                    });

                }
            })
            .catch(error => {

                button.disabled = false;
                button.innerHTML = "SIGN IN";

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                });

                console.error(error);
            });
    });
    </script>
</body>

</html>