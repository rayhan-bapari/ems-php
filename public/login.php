<?php
$showError = false;
$showSuccess = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = ['success' => false, 'message' => ''];

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $response['message'] = 'All fields are required.';
    } else {
        try {
            $database = new Database();
            $db = $database->conn;

            $user = new User($db);
            $user->username = $_POST['username'];
            $user->password = $_POST['password'];

            if ($user->login()) {
                Session::start();
                Session::set('user_id', $user->id);
                $response['success'] = true;
                $showSuccess = true;
            } else {
                $response['message'] = 'Invalid username or password.';
                $showError = true;
            }
        } catch (Exception $e) {
            $response['message'] = 'An error occurred: ' . $e->getMessage();
            $showError = true;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>Ventic - Event Ticketing Bootstrap 5 Admin Template</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="">

    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="">
    <meta name="format-detection" content="telephone=no">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon.png">

    <link class="main-css" href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>
    <div class="authincation ">
        <div class="container ">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href="../public/login.php">
                                            <img src="../assets/images/logo-full.png" alt="">
                                        </a>
                                    </div>
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <?php if ($showError) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $response['message'] ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($showSuccess) : ?>
                                        <div class="alert alert-success" role="alert">
                                            Login successful. Redirecting...
                                        </div>
                                    <?php endif; ?>
                                    <form method="post" class="form-signin needs-validation" novalidate>
                                        <div class="mb-3">
                                            <label class="mb-1 form-label">Username</label>
                                            <input type="text" class="form-control" placeholder="Enter your username" name="username" required>
                                        </div>
                                        <div class="mb-3 position-relative">
                                            <label class="mb-1 form-label">Password</label>
                                            <input type="password" id="dz-password" class="form-control" placeholder="Enter your password" required>
                                            <span class="show-pass eye">
                                                <i class="fa fa-eye-slash"></i>
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" id="loginBtn" class="btn btn-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary" href="../public/register.php">Sign up</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('dz-password').addEventListener('input', function() {
            document.querySelector('.eye').classList.add('active');
        });
        document.querySelector('.eye').addEventListener('click', function() {
            if (this.classList.contains('active')) {
                this.classList.remove('active');
                document.getElementById('dz-password').setAttribute('type', 'password');
            } else {
                this.classList.add('active');
                document.getElementById('dz-password').setAttribute('type', 'text');
            }
        });
    </script>

    <script>
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.form-signin');

            const submitButton = document.querySelector('#loginBtn');

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(form);

                submitButton.disabled = true;

                fetch('login.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        submitButton.disabled = false;

                        if (data.success) {
                            const alert = document.createElement('div');
                            alert.className = 'alert alert-success';
                            alert.textContent = 'Login successful! Redirecting...';
                            form.prepend(alert);

                            setTimeout(() => {
                                window.location.href = 'index.php';
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        submitButton.disabled = false;
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-danger';
                        alert.textContent = 'An error occurred. Please try again.';
                        form.prepend(alert);
                    });
            });
        });
    </script>
</body>

</html>
