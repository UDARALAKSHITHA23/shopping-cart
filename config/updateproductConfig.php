<?php
require_once '../sql/config.php';
require_once '../function/updateFuntion.php';

if (isset($_GET['action']) && $_GET['action'] == 'getProductDetails' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = fetchProductDetailsForEdit($conn, $id);
    if ($result) {
        echo json_encode([
            "status" => "success",
            "data" => $result
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Product not found"
        ]);
    }
    exit();

} else if ($_POST['action'] == 'submitProductDetails' && isset($_POST['id'])) {
    // Process form submission
    // Make sure to sanitize and validate your inputs
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];

    // Update the product in the database
    $result = updateProduct($conn, $id, $name, $price, $image, $image_tmp_name, $image_folder);
    if ($result) {
        echo json_encode([
            "status" => "success",
            "message" => "Product updated successfully"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to update product"
        ]);
    }
    exit();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request!"]);
}
