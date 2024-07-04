<?php
include 'header.php';
?>

   <!-- Update Form -->
<div id="edit-form-container form" >
    <form id="update-form" method="post" enctype="multipart/form-data">
        <h3>Update Product</h3>
        <input type="hidden" name="update_id" id="update_id">
        <input type="text" name="update_name" id="update_name" placeholder="Enter the product name" class="box" required>
        <input type="number" name="update_price" id="update_price" min="0" placeholder="Enter the product price" class="box" required>
        <input type="file" name="update_image" id="update_image" accept="image/png, image/jpg, image/jpeg" class="box">
        <input type="submit" value="Update Product" name="update_product" class="btn">
    </form>
</div>

<!-- Include jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
function showUpdateForm(id) {
    $.ajax({
        url: 'config/updateproductConfig.php',
        type: 'GET',
        data: { id: id },
        success: function(response) {
            var product = JSON.parse(response);
            if (product.error) {
                alert(product.error);
            } else {
                $('#update_id').val(product.ID);
                $('#update_name').val(product.name);
                $('#update_price').val(product.price);
                $('#update-form-container').show();
                $('#add-form').hide();
            }
        },
        error: function() {
            alert('Failed to fetch product data');
        }
    });
}
</script>