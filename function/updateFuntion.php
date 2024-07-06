<?php

function fetchProductDetailsForEdit($conn, $id)
{
    $sql = "SELECT ID, name, price, image FROM product WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = null;
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        // Ensure the image path is correct
        $data['image'] = 'shopping cart/uploaded_img/' . $data['image'];
    }

    $stmt->close();

    return $data;
}
function updateProduct($conn, $id, $name, $price, $image, $image_tmp_name, $image_folder)
{
    $sql = "UPDATE product SET name = ?, price = ?, image = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sdsi", $name, $price, $image, $id);
    $result = $stmt->execute();

    if ($result) {
        move_uploaded_file($image_tmp_name, $image_folder);
    }

    $stmt->close();

    return $result;
}
