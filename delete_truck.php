<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    if (!empty($id)) {
        $query = "DELETE FROM food_trucks WHERE id = $id";

        if ($mysqli->query($query)) {
            header("Location: add_trucks.php");
        } else {
            echo "Error deleting food truck: " . $mysqli->error;
        }
    }
}
?>
