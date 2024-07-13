<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    if (!empty($id)) {
        $query = "SELECT * FROM food_trucks WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $truck = $result->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $menu = isset($_POST['menu']) ? $_POST['menu'] : '';
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';
    $schedule = isset($_POST['schedule']) ? $_POST['schedule'] : '';

    if (!empty($id) && !empty($name) && !empty($menu) && !empty($latitude) && !empty($longitude) && !empty($schedule)) {
        $query = "UPDATE food_trucks SET name=?, menu=?, latitude=?, longitude=?, schedule=? WHERE id=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ssddsi', $name, $menu, $latitude, $longitude, $schedule, $id);

        if ($stmt->execute()) {
            header("Location: add_trucks.php");
            exit();
        } else {
            echo "Error updating food truck: " . $stmt->error;
        }
    } else {
        echo "Missing required fields";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Food Truck</title>
    <style>
        /* Add some basic styling to make the form look nicer */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <h1>Update Food Truck</h1>
    <form action="update_truck.php" method="post">
        <input type="hidden" name="id" value="<?php echo $truck['id']; ?>">

        <label for="name">Food Truck Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $truck['name']; ?>"><br><br>

        <label for="menu">Menu:</label>
        <textarea id="menu" name="menu"><?php echo $truck['menu']; ?></textarea><br><br>

        <label for="latitude">Latitude:</label>
        <input type="text" id="latitude" name="latitude" value="<?php echo $truck['latitude']; ?>"><br><br>

        <label for="longitude">Longitude:</label>
        <input type="text" id="longitude" name="longitude" value="<?php echo $truck['longitude']; ?>"><br><br>

        <label for="schedule">Schedule:</label>
        <textarea id="schedule" name="schedule"><?php echo $truck['schedule']; ?></textarea><br><br>

        <input type="submit" value="Update Food Truck">
    </form>
</body>
</html>