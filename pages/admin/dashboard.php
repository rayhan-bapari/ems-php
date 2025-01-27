<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../public/css/app.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.html">
                    <span class="align-middle">AdminKit</span>
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Pages
                    </li>

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="index.html">
                            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="pages-profile.html">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="pages-sign-in.html">
                            <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Sign In</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="pages-sign-up.html">
                            <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Sign Up</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="pages-blank.html">
                            <i class="align-middle" data-feather="book"></i> <span class="align-middle">Blank</span>
                        </a>
                    </li>

                    <li class="sidebar-header">
                        Tools & Components
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="ui-buttons.html">
                            <i class="align-middle" data-feather="square"></i> <span class="align-middle">Buttons</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="ui-forms.html">
                            <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Forms</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="ui-cards.html">
                            <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Cards</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="ui-typography.html">
                            <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">Typography</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="icons-feather.html">
                            <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Icons</span>
                        </a>
                    </li>

                    <li class="sidebar-header">
                        Plugins & Addons
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="charts-chartjs.html">
                            <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Charts</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="maps-google.html">
                            <i class="align-middle" data-feather="map"></i> <span class="align-middle">Maps</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                <img src="https://placehold.co/80x80" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
                                <span class="text-dark">
                                    <?= $username ?>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="../../includes/logout.php">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Dashboard</h1>

                    <div class="row">
                        <div class="col-12">
                            <div class="card flex-fill">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Latest Projects</h5>
                                </div>
                                <table class="table table-hover my-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class="d-none d-xl-table-cell">Start Date</th>
                                            <th class="d-none d-xl-table-cell">End Date</th>
                                            <th>Status</th>
                                            <th class="d-none d-md-table-cell">Assignee</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Project Apollo</td>
                                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                                            <td><span class="badge bg-success">Done</span></td>
                                            <td class="d-none d-md-table-cell">Vanessa Tucker</td>
                                        </tr>
                                        <tr>
                                            <td>Project Fireball</td>
                                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                                            <td><span class="badge bg-danger">Cancelled</span></td>
                                            <td class="d-none d-md-table-cell">William Harris</td>
                                        </tr>
                                        <tr>
                                            <td>Project Hades</td>
                                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                                            <td><span class="badge bg-success">Done</span></td>
                                            <td class="d-none d-md-table-cell">Sharon Lessman</td>
                                        </tr>
                                        <tr>
                                            <td>Project Nitro</td>
                                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                                            <td><span class="badge bg-warning">In progress</span></td>
                                            <td class="d-none d-md-table-cell">Vanessa Tucker</td>
                                        </tr>
                                        <tr>
                                            <td>Project Phoenix</td>
                                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                                            <td><span class="badge bg-success">Done</span></td>
                                            <td class="d-none d-md-table-cell">William Harris</td>
                                        </tr>
                                        <tr>
                                            <td>Project X</td>
                                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                                            <td><span class="badge bg-success">Done</span></td>
                                            <td class="d-none d-md-table-cell">Sharon Lessman</td>
                                        </tr>
                                        <tr>
                                            <td>Project Romeo</td>
                                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                                            <td><span class="badge bg-success">Done</span></td>
                                            <td class="d-none d-md-table-cell">Christina Mason</td>
                                        </tr>
                                        <tr>
                                            <td>Project Wombat</td>
                                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                                            <td><span class="badge bg-warning">In progress</span></td>
                                            <td class="d-none d-md-table-cell">William Harris</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </main>

            <footer class="footer">
                <p class="text-center mb-0">
                    <a href="#" class="text-muted">Event Management</a> &copy; <?php echo date('Y'); ?>
                </p>
            </footer>
        </div>
    </div>

    <script src="../../public/js/app.js"></script>
</body>

</html>
