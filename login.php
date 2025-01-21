<?php
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'classes/Session.php';

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
            } else {
                $response['message'] = 'Invalid username or password.';
            }
        } catch (Exception $e) {
            $response['message'] = 'An error occurred: ' . $e->getMessage();
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="form-body">
        <div class="row">
            <div class="form-holder">
                <h1 class="text-white">
                    Event Management System
                </h1>
                <div class="form-content">
                    <div class="form-items">
                        <h3>Login</h3>
                        <p>Enter your credentials below.</p>
                        <form method="post" class="login-form requires-validation" novalidate>
                            <div class="col-md-12">
                                <input class="form-control" type="text" name="username" placeholder="Username" required>
                                <div class="invalid-feedback">Username field cannot be blank!</div>
                            </div>

                            <div class="col-md-12">
                                <input class="form-control" type="password" name="password" placeholder="Password" required>
                                <div class="invalid-feedback">Password field cannot be blank!</div>
                            </div>

                            <div class="form-button mt-3">
                                <button id="submit" type="submit" class="btn btn-primary">Login</button>
                            </div>
                            <p class="mt-3">Don't have an account? <a href="register.php">Register</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function() {
            'use strict';

            var forms = document.querySelectorAll('.requires-validation');

            Array.from(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }

                        form.classList.add('was-validated');
                    }, false);
                });
        })()
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.login-form');
            const submitButton = document.querySelector('#submit');

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
