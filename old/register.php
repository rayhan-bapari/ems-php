<?php
require_once 'classes/Database.php';
require_once 'classes/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = ['success' => false, 'message' => ''];

    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        $response['message'] = 'All fields are required.';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email format.';
    } else {
        try {
            $database = new Database();
            $db = $database->conn;

            $user = new User($db);
            $user->username = $_POST['username'];
            $user->password = $_POST['password'];
            $user->email = $_POST['email'];

            if ($user->register()) {
                $response['success'] = true;
            } else {
                $response['message'] = "Registration failed. Please try again.";
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
    <title>Register - Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                        <h3>Register</h3>
                        <p>Fill in the data below.</p>
                        <form method="post" class="register-form requires-validation" novalidate>
                            <div class="col-md-12">
                                <input class="form-control" type="text" name="username" placeholder="Username" required>
                                <div class="invalid-feedback">Username field cannot be blank!</div>
                            </div>

                            <div class="col-md-12">
                                <input class="form-control" type="email" name="email" placeholder="E-mail Address" required>
                                <div class="invalid-feedback">Email field cannot be blank!</div>
                            </div>

                            <div class="col-md-12">
                                <input class="form-control" type="password" name="password" placeholder="Password" required>
                                <div class="invalid-feedback">Password field cannot be blank!</div>
                            </div>

                            <div class="form-button mt-3">
                                <button id="submit" type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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
            const form = document.querySelector('.register-form');
            const submitButton = document.querySelector('#submit');

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(form);
                const errorAlert = document.querySelector('.alert-danger');
                if (errorAlert) errorAlert.remove();

                submitButton.disabled = true;

                fetch('register.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        submitButton.disabled = false;

                        if (data.success) {
                            const alert = document.createElement('div');
                            alert.className = 'alert alert-success';
                            alert.textContent = 'Registration successful. You can now login.';
                            form.prepend(alert);

                            setTimeout(() => {
                                window.location.href = 'login.php';
                            }, 3000);
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
