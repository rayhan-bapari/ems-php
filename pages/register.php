<?php
$showError = false;
$showSuccess = false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Register | Event Management
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
                                    <h4 class="text-center mb-4">Sign up your account</h4>
                                    <?php if ($showError) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $response['message'] ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($showSuccess) : ?>
                                        <div class="alert alert-success" role="alert">
                                            Registration successful. Redirecting...
                                        </div>
                                    <?php endif; ?>
                                    <form method="post" class="form-register needs-validation" novalidate>
                                        <div class="mb-3">
                                            <label class="mb-1 form-label">Username</label>
                                            <input type="text" class="form-control" placeholder="Enter your username" name="username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1 form-label">Email</label>
                                            <input type="email" class="form-control" placeholder="hello@example.com" name="email" required>
                                        </div>
                                        <div class="mb-3 position-relative">
                                            <label class="mb-1 form-label">Password</label>
                                            <input type="password" id="dz-password" class="form-control" name="password" required>
                                            <span class="show-pass eye">
                                                <i class="fa fa-eye-slash"></i>
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" id="registerBtn" class="btn btn-primary btn-block">Sign me up</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Already have an account? <a class="text-primary" href="login.php">Sign in</a></p>
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
            const form = document.querySelector('.form-register');
            const username = form.querySelector('input[name="username"]');
            const email = form.querySelector('input[name="email"]');
            const password = form.querySelector('input[name="password"]');

            function validateForm() {
                let isValid = true;
                const errors = [];

                if (username.value.length < 3 || username.value.length > 50) {
                    isValid = false;
                    errors.push('Username must be between 3 and 50 characters');
                    username.classList.add('is-invalid');
                } else {
                    username.classList.remove('is-invalid');
                }

                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email.value)) {
                    isValid = false;
                    errors.push('Invalid email format');
                    email.classList.add('is-invalid');
                } else {
                    email.classList.remove('is-invalid');
                }

                if (password.value.length < 8) {
                    isValid = false;
                    errors.push('Password must be at least 8 characters long');
                    password.classList.add('is-invalid');
                } else {
                    password.classList.remove('is-invalid');
                }

                return {
                    isValid,
                    errors
                };
            }

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const {
                    isValid,
                    errors
                } = validateForm();

                if (!isValid) {
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-danger';
                    alert.textContent = errors.join(', ');
                    form.prepend(alert);
                    return;
                }

                const formData = new FormData(form);
                submitForm(formData);
            });

            function submitForm(formData) {
                const submitButton = document.querySelector('#registerBtn');
                submitButton.disabled = true;

                fetch('../includes/register.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        submitButton.disabled = false;

                        const existingAlerts = form.querySelectorAll('.alert');
                        existingAlerts.forEach(alert => alert.remove());

                        if (data.success) {
                            const alert = document.createElement('div');
                            alert.className = 'alert alert-success';
                            alert.textContent = 'Registration successful! Redirecting...';
                            form.prepend(alert);

                            setTimeout(() => {
                                window.location.href = 'login.php';
                            }, 2000);
                        } else {
                            const alert = document.createElement('div');
                            alert.className = 'alert alert-danger';
                            alert.textContent = data.message;
                            form.prepend(alert);
                        }
                    })
                    .catch(error => {
                        submitButton.disabled = false;
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-danger';
                        alert.textContent = 'An error occurred. Please try again.';
                        form.prepend(alert);
                    });
            }
        });
    </script>
</body>

</html>
