<?php
session_start();
if (!isset($_SESSION['admin_id']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

// Include the database connection
include 'db.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $menu = isset($_POST['menu']) ? $_POST['menu'] : '';
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';
    $schedule = isset($_POST['schedule']) ? $_POST['schedule'] : '';

    if (!empty($name) && !empty($menu) && !empty($latitude) && !empty($longitude) && !empty($schedule)) {
        $query = "INSERT INTO food_trucks (name, menu, latitude, longitude, schedule) VALUES ('$name', '$menu', $latitude, $longitude, '$schedule')";

        if ($mysqli->query($query)) {
            $message = "Food truck added successfully";
        } else {
            $message = "Error adding food truck: " . $mysqli->error;
        }
    } else {
        $message = "Missing required fields";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Food Truck Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
        background-color: #d9c9b5; /* Replace with your desired color */
      
        }
    </style>
    <script>
        function confirmDelete(form) {
            if (confirm('Are you sure you want to delete this food truck?')) {
                form.submit();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center my-3">
            <h1>Add Food Truck</h1>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="add_trucks.php" method="post" class="mb-5">
            <div class="form-group">
                <label for="name">Food Truck Name:</label>
                <input type="text" id="name" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="menu">Menu:</label>
                <textarea id="menu" name="menu" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="latitude">Latitude:</label>
                <input type="text" id="latitude" name="latitude" class="form-control">
            </div>
            <div class="form-group">
                <label for="longitude">Longitude:</label>
                <input type="text" id="longitude" name="longitude" class="form-control">
            </div>
            <div class="form-group">
                <label for="schedule">Schedule:</label>
                <textarea id="schedule" name="schedule" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Food Truck</button>
        </form>

        <h1>Food Trucks List</h1>
        <?php
        // Fetch all food trucks
        $query = "SELECT * FROM food_trucks";
        $result = $mysqli->query($query);
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Menu</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Schedule</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['menu']; ?></td>
                        <td><?php echo $row['latitude']; ?></td>
                        <td><?php echo $row['longitude']; ?></td>
                        <td><?php echo $row['schedule']; ?></td>
                        <td>
    <div class="btn-group">
        <form action="delete_truck.php" method="post" onsubmit="event.preventDefault(); confirmDelete(this);">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
        <form action="update_truck.php" method="get">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <button type="submit" class="btn btn-warning btn-sm">Update</button>
        </form>
    </div>
</td>
                              
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
