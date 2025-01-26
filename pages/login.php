<?php
$showError = false;
$showSuccess = false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Login | Event Management
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include '../partials/css.php'; ?>
</head>

<body>
    <div class="authincation">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href="#">
                                            <img src="../public/images/logo-full.png" alt="">
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
                                            <?= $response['message'] ?>
                                        </div>
                                    <?php endif; ?>

                                    <form method="post" class="form-signin needs-validation" novalidate>
                                        <div class="mb-3">
                                            <label class="mb-1 form-label">Username</label>
                                            <input type="text" class="form-control" placeholder="Enter your username" name="username" required>
                                        </div>
                                        <div class="mb-3 position-relative">
                                            <label class="mb-1 form-label">Password</label>
                                            <input type="password" id="dz-password" class="form-control" placeholder="Enter your password" name="password" required>
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
                                        <p>Don't have an account? <a class="text-primary" href="register.php">Sign up</a></p>
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
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.form-signin');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const username = form.querySelector('input[name="username"]');
                const password = form.querySelector('input[name="password"]');

                if (!username.value || !password.value) {
                    showAlert('All fields are required', 'danger');
                    return;
                }

                const submitButton = document.querySelector('#loginBtn');
                submitButton.disabled = true;

                const formData = new FormData(form);

                fetch('../includes/login.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        submitButton.disabled = false;

                        if (data.success) {
                            showAlert(data.message, 'success');
                            setTimeout(() => {
                                window.location.href = 'dashboard.php';
                            }, 1500);
                        } else {
                            showAlert(data.message, 'danger');
                        }
                    })
                    .catch(error => {
                        submitButton.disabled = false;
                        showAlert('An error occurred. Please try again.', 'danger');
                    });
            });

            function showAlert(message, type) {
                const existingAlerts = form.querySelectorAll('.alert');
                existingAlerts.forEach(alert => alert.remove());

                const alert = document.createElement('div');
                alert.className = `alert alert-${type}`;
                alert.textContent = message;
                form.prepend(alert);
            }
        });
    </script>
</body>

</html>
