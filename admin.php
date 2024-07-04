<?php
include 'compornent/admin_header.php';
include 'sql/config.php';
include 'header.php';
session_start(); // Start the session

if (isset($_POST['add_product'])) {
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $p_image = $_FILES['p_image']['name'];
    $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
    $p_image_folder = 'uploaded_img/'.$p_image;

    if (!empty($p_name) && !empty($p_price) && !empty($p_image)) {
        // Insert data into the database
        $insert_query = mysqli_query($conn, "INSERT INTO `product` (name, price, image) VALUES ('$p_name', '$p_price', '$p_image')") or die('Query failed: ' . mysqli_error($conn));

        if ($insert_query) {
            move_uploaded_file($p_image_tmp_name, $p_image_folder);
            $_SESSION['message'] = 'Product added successfully';
        } else {
            $_SESSION['message'] = 'Could not add the product';
        }
    } else {
        // Handle the case where fields are empty
        $_SESSION['message'] = 'Please fill all the fields';
    }
    header('Location: admin.php');
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete_query = mysqli_query($conn, "UPDATE `product` SET status = 0 WHERE ID = $id") or die('Query failed: ' . mysqli_error($conn));
    if ($delete_query) {
        $_SESSION['message'] = 'Product Deleted';
    } else {
        $_SESSION['message'] = "Product couldn't be Deleted";
    }
    header('location: admin.php');
    exit();
}

if (isset($_SESSION['message'])) {
    echo '<div class="message"><span>'.$_SESSION['message'].'</span><i class="fas fa-times" onclick="this.parentElement.style.display=\'none\';"></i></div>';
    unset($_SESSION['message']); // Clear message after displaying
}
?>

<div class="container">
    <section>
        <form action="" method="post" enctype="multipart/form-data" class="add-product-form">
            <h3>Add New Product</h3>
            <input type="text" name="p_name" placeholder="Enter the product name" class="box" required>
            <input type="number" name="p_price" min="0" placeholder="Enter the product price" class="box" required>
            <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
            <input type="submit" value="Add the Product" name="add_product" class="btn">
        </form>
    </section>

    <div class="container">
    <section class="display-product-table">
        <table class="table-responsive" id="productTable">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    
                    <th>Product Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-light">
                <?php
                $select_product = mysqli_query($conn, "SELECT * FROM `product` WHERE status = 1") or die('Query failed: ' . mysqli_error($conn));
                if (mysqli_num_rows($select_product) > 0) {
                    while ($row = mysqli_fetch_assoc($select_product)) {
                        ?>
                        <tr>
                        <td><img src="uploaded_img/<?php echo $row['image']; ?>" height='100'></td>
                            <td><?php echo $row['name']; ?></td>
                            
                            <td>$<?php echo $row['price']; ?>/=</td>
                            <td>
                                <a href="admin.php?delete=<?php echo $row['ID']; ?>" class="delete-btn" onclick="return confirmDelete();">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <a href="updateproduct.php" class="option-btn" onclick="showUpdateForm(<?php echo $row['ID']; ?>)"><i class="fas fa-edit"></i> Update </a>
                                </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='4' class='empty'>No Product added</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</div>


<script>
$(document).ready( function () {
    $('.table-responsive').DataTable();
});
</script>
