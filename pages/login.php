<?php
$showError = false;
$showSuccess = false;

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: admin/dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        Login | Event Management
    </title>

    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include '../partials/css.php' ?>
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2">Welcome back!</h1>
                            <p class="lead">
                                Sign in to your account to continue
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
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

                                    <form id="loginForm" class="needs-validation" novalidate>
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input class="form-control form-control-lg" type="text" name="username" placeholder="Enter your username" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary" id="loginBtn">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-3">
                            Don't have an account? <a href="register.php">Sign up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../partials/js.php' ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('#loginForm');
            const username = form.querySelector('input[name="username"]');
            const password = form.querySelector('input[name="password"]');

            function validateForm() {
                let isValid = true;

                if (!username.value) {
                    isValid = false;
                    username.classList.add('is-invalid');
                } else {
                    username.classList.remove('is-invalid');
                }

                if (!password.value) {
                    isValid = false;
                    password.classList.add('is-invalid');
                } else {
                    password.classList.remove('is-invalid');
                }

                return {
                    isValid
                };
            }

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const {
                    isValid,
                } = validateForm();

                if (!isValid) {
                    showAlert('All fields are required', 'danger');
                    return;
                }

                const formData = new FormData(form);
                submitForm(formData);
            });

            function submitForm(formData) {
                const submitButton = document.querySelector('#loginBtn');
                submitButton.disabled = true;

                fetch('../includes/login.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        submitButton.disabled = false;
                        showAlert(data.message, data.success ? 'success' : 'danger');
                        if (data.success) {
                            setTimeout(() => {
                                window.location.href = 'admin/dashboard.php';
                            }, 1500);
                        }
                    })
                    .catch(error => {
                        submitButton.disabled = false;
                        showAlert('An error occurred. Please try again.', 'danger');
                    });
            }

            function showAlert(message, type) {
                const alertBox = document.createElement('div');
                alertBox.className = `alert alert-${type}`;
                alertBox.textContent = message;
                const existingAlert = document.querySelector('.alert');
                if (existingAlert) {
                    existingAlert.remove();
                }
                form.prepend(alertBox);
            }
        });
    </script>
</body>

</html>
