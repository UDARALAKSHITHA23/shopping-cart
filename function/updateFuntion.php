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

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $stmt->close();
    // Debug: Print the fetched data
    echo '<pre>';
    print_r($data);
    echo '</pre>';

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
