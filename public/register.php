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
    <div class="authincation">
        <div class="container">
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
                                    <h4 class="text-center mb-4">Sign up your account</h4>
                                    <form action="index.html">
                                        <div class="mb-3">
                                            <label class="mb-1 form-label">Username</label>
                                            <input type="text" class="form-control" placeholder="username">
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1 form-label">Email</label>
                                            <input type="email" class="form-control" placeholder="hello@example.com">
                                        </div>
                                        <div class="mb-3 position-relative">
                                            <label class="mb-1 form-label">Password</label>
                                            <input type="password" id="dz-password" class="form-control">
                                            <span class="show-pass eye">

                                                <i class="fa fa-eye-slash"></i>
                                                <i class="fa fa-eye"></i>

                                            </span>
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Already have an account? <a class="text-primary" href="page-login.html">Sign in</a></p>
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
</body>

</html>
