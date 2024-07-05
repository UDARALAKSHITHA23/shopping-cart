<?php
include 'header.php';
include 'compornent/admin_header.php';

$id = isset($_GET['id']) ? $_GET['id'] : 0;
?>
<form id="updateForm" data-id="<?php echo htmlspecialchars($id); ?>">
    <div class="row">
        <div class="col-md-5 mb-3">
            <label>Name:</label>
            <input type="text" class="form-control capitalize" id="name" name="name" placeholder="Name" required>
        </div>
        <div class="col-md-5 mb-3">
            <label>Price:</label>
            <input type="text" class="form-control capitalize" id="price" name="price" placeholder="Price" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 mb-3">
            <label>Image:</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
    </div>
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
    <button type="button" class="btn btn-primary" onclick="submitUpdateForm()">Save</button>
</form>


<script>

    $(document).ready(function () {
        var id = $('#updateForm').data('id');
        if (id) {
            $.ajax({
                url: 'config/updateproductConfig.php',
                type: 'GET',
                data: {
                    id: id,
                    action: 'getProductDetails'
                },
                dataType: 'json',
                success: function (response) {
                    console.log(response); // Print the response to the console
                    if (response.status === 'success' && response.data) {
                        $('#name').val(response.data.name);
                        $('#price').val(response.data.price);
                        // Handle image loading if needed
                    } else {
                        alert('Failed to fetch product details');
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText); // Print error response to the console
                    alert('Error fetching product details');
                }
            });
        }
    });

    function submitUpdateForm() {
        var form = document.getElementById('updateForm');
        var formData = new FormData(form);

        $.ajax({
            url: 'config/updateproductConfig.php',
            type: 'POST',
            data: { id: id, action: 'submitProductDetails' },
            contentType: false,
            processData: false,
            success: function (response) {
                alert(response);
                // Optionally, you can close the modal or perform any other action after successful update
            },
            error: function (xhr, status, error) {
                alert('Error updating product');
            }
        });
    }
</script>