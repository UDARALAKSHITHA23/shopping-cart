<?php

function updateProduct($id, $name, $price, $image, $image_tmp_name) {
    global $conn;
    $image_folder = 'uploaded_img/'.$image;
    
    if (!empty($name) && !empty($price)) {
        if (!empty($image)) {
            move_uploaded_file($image_tmp_name, $image_folder);
            $update_query = $conn->prepare("UPDATE product SET name = ?, price = ?, image = ? WHERE ID = ?");
            $update_query->bind_param("sdsi", $name, $price, $image, $id);
        } else {
            $update_query = $conn->prepare("UPDATE product SET name = ?, price = ? WHERE ID = ?");
            $update_query->bind_param("sdi", $name, $price, $id);
        }

        if ($update_query->execute()) {
            return 'Product updated successfully';
        } else {
            return 'Failed to update product';
        }
    } else {
        return 'Please fill all the fields';
    }
}

?>