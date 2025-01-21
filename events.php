<?php
require_once 'classes/Database.php';
require_once 'classes/Event.php';
require_once 'classes/Session.php';

Session::start();
$user_id = Session::get('user_id');

if (!$user_id) {
    header("Location: index.php");
    exit;
}

$database = new Database();
$db = $database->conn;

$event = new Event($db);
$event->user_id = $user_id;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $event->name = $_POST['name'];
        $event->description = $_POST['description'];
        $event->date_time = $_POST['date_time'];
        $event->location = $_POST['location'];

        if ($event->create()) {
            $message = "Event created successfully.";
        } else {
            $message = "Event creation failed.";
        }
    } elseif (isset($_POST['edit'])) {
        $event->id = $_POST['id'];
        $event->name = $_POST['name'];
        $event->description = $_POST['description'];
        $event->date_time = $_POST['date_time'];
        $event->location = $_POST['location'];

        if ($event->update()) {
            $message = "Event updated successfully.";
        } else {
            $message = "Event update failed.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete'])) {
    $event->id = $_GET['delete'];
    if ($event->delete()) {
        $message = "Event deleted successfully.";
    } else {
        $message = "Event deletion failed.";
    }
}

$stmt = $event->read();
$events = $stmt->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h1>Event Management System</h1>
            <div>
                <a href="index.php" class="btn btn-outline-primary">Home</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </header>

        <?php if (isset($message)) : ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <h2>Create Event</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date_time" class="form-label">Date and Time</label>
                        <input type="datetime-local" class="form-control" id="date_time" name="date_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <button type="submit" name="create" class="btn btn-success">Create Event</button>
                </form>
            </div>
            <div class="col-md-8">
                <h2>My Events</h2>
                <ul class="list-group">
                    <?php foreach ($events as $event) : ?>
                        <li class="list-group-item">
                            <h5><?php echo htmlspecialchars($event['name']); ?></h5>
                            <p><?php echo htmlspecialchars($event['description']); ?></p>
                            <p><strong>Date and Time:</strong> <?php echo htmlspecialchars($event['date_time']); ?></p>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                            <div class="d-flex">
                                <button class="btn btn-warning me-2" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($event)); ?>)">Edit</button>
                                <a href="?delete=<?php echo htmlspecialchars($event['id']); ?>" class="btn btn-danger">Delete</a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="modal" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editId">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editDateTime" class="form-label">Date and Time</label>
                            <input type="datetime-local" class="form-control" id="editDateTime" name="date_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="editLocation" class="form-label">Location</label>
                            <input type="text" class="form-control" id="editLocation" name="location" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="edit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openEditModal(event) {
            document.getElementById('editId').value = event.id;
            document.getElementById('editName').value = event.name;
            document.getElementById('editDescription').value = event.description;
            document.getElementById('editDateTime').value = event.date_time;
            document.getElementById('editLocation').value = event.location;

            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }
    </script>
</body>

</html>
