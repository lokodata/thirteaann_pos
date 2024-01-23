<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThirTeaAnn</title>
</head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="../styles/orders.css">

<body>
    <!-- Add Product Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Order Receipt</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div id="order_information" class="modal-body">
                    
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="inventory">
            <h1>Products</h1>

            <div class="categories">
                <?php
                    require '../config/config.php';
                    
                    // Fetch distinct categories from the database
                    $categoryStmt = $mysqli->prepare("SELECT DISTINCT category FROM product_table");
                    $categoryStmt->execute();
                    $categoryStmt->bind_result($distinctCategory);

                    // Generate a button for 'All' category
                    echo "<button class='btn btn-info mx-2 my-2 category-btn' onclick='filterByCategory(\"All\")'>All</button>";

                    // Generate a button for each distinct category
                    while ($categoryStmt->fetch()) {
                        echo "<button class='btn btn-info mx-2 my-2 category-btn' onclick='filterByCategory(\"$distinctCategory\")'>$distinctCategory</button>";
                    }

                    // Close the statement
                    $categoryStmt->close();
                ?>
            </div>

            <table class="table" id="product_table">
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require '../config/config.php';

                        // Fetch products with the initial condition (e.g., size)
                        $stmt = $mysqli->prepare("SELECT * FROM product_table WHERE size IN ('500 ml', 'Regular')");
                        $stmt->execute();
                        $stmt->bind_result($product_id, $product_image, $product_name, $size, $unit_price, $category);

                        while ($stmt->fetch()) {
                            echo "<tr data-product-id='$product_id' data-category='$category'>";
                                echo "<td><img class='product_image' src='data:image/png;base64, " . base64_encode($product_image) . "' alt='Product Image'></td>";
                                echo "<td>$product_name</td>";
                                echo "<td>$unit_price</td>";
                            echo "</tr>";
                        }

                        $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="order" id="order_details">
            <h1>Order</h1>

            <form id="order_form">
                <table class="table" id="order_table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 
                            When any of the row is clicked it will show up to the Order
                        -->
                    </tbody>

                    <tfoot>
                        <tr>
                            <td>Total:</td>
                            <td id="total_price">0.00</td>
                        </tr>

                        <tr>
                            <td>Payment Received:</td>
                            <td id="payment_received">
                                <input type='tel' pattern='[0-9]*' inputmode='numeric' placeholder="Enter amount" oninput="updateExactChange()">
                            </td>
                        </tr>


                        <tr>
                            <td>Exact Change:</td>
                            <td id="change">0.00</td>
                        </tr>

                        <tr>
                            <td>Payment Method:</td>
                            <td id="payment_method">
                                <label>
                                    <input type="radio" name="payment_method" value="Cash"> Cash
                                </label>
                                <label>
                                    <input type="radio" name="payment_method" value="Gcash"> GCash
                                </label>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <button type="button" class="btn btn-primary" id='saveOrderBtn' data-bs-toggle='modal' data-bs-target='#receiptModal'>
                                    Save Order
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>

        function filterByCategory(selectedCategory) {
            var rows = $('#product_table tbody tr');
            
            rows.each(function() {
                var category = $(this).data('category');
                
                // Toggle the visibility based on the selected category
                if (selectedCategory === 'All' || category === selectedCategory) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        var selectedProducts = [];

        $(document).ready(function() {
            // Handle click event on product rows
            $('#product_table tbody tr').click(function() {
                var productId = $(this).data('product-id');

                // Use AJAX to fetch product details
                $.ajax({
                    url: '../config/orders-function.php',
                    method: 'POST',
                    data: { productId: productId },
                    success: function(response) {
                        // Append the new row for the selected product
                        $('#order_table tbody').append(response);
                        
                        updateTotalPrice(); // Trigger updateTotalPrice after appending the row
                        updateExactChange();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });

        window.incrementQuantity = function(button) {
            var inputElement = $(button).parent().prev().find('input[name="quantity"]');
            var currentQuantity = parseInt(inputElement.val(), 10);
            inputElement.val(currentQuantity + 1);

            // Trigger the updatePrices function after incrementing the quantity
            updatePrices(inputElement.closest('tr').find('select[name="size"]')[0]);
            updateTotalPrice();
            updateExactChange();
        }

        window.decrementQuantity = function(button) {
            var inputElement = $(button).parent().prev().find('input[name="quantity"]');
            var currentQuantity = parseInt(inputElement.val(), 10);
            
            if (currentQuantity > 1) {
                inputElement.val(currentQuantity - 1);

                // Trigger the updatePrices function after decrementing the quantity
                updatePrices(inputElement.closest('tr').find('select[name="size"]')[0]);
                updateTotalPrice();
                updateExactChange();
            }
        }

        window.removeItem = function(button) {
            $(button).closest('tr').remove();
            updateTotalPrice();
            updateExactChange();
        }

        // Handle save order button click using event delegation
        $(document).on('click', '#saveOrderBtn', function() {
            updateTotalPrice();
            updateExactChange();
            var formData = gatherFormData(); // Capture the returned formData
            displayOrderInformation(formData);
            saveOrder(formData);
        });

        function saveOrder(formData) {

            // Make an AJAX request to save-order.php
            $.ajax({
                type: 'POST',
                url: '../config/save-order.php',
                data: { orderData: JSON.stringify(formData) }, // Sending the order data as JSON string
                success: function (response) {
                    // Handle the success response if needed
                    console.log('Order saved successfully:', response);
                },
                error: function (xhr, status, error) {
                    // Handle errors if any
                    console.error('Error saving order:', status, error);
                }
            });
        }

        function gatherFormData() {
            var formData = {
                products: []
            };

            // Iterate through each row in the table body
            $('#order_table tbody tr').each(function () {
                var productName = $(this).find('td:nth-child(1)').text().trim();
                
                // Assuming the size is selected through a dropdown (select) element
                var size = $(this).find('select[name="size"]').val().trim();

                var price = parseFloat($(this).find('td:nth-child(3)').text().trim());
                var quantity = parseInt($(this).find('input[name="quantity"]').val());
                var total = price * quantity;

                formData.products.push({
                    productName: productName,
                    size: size,
                    price: price,
                    quantity: quantity,
                    total: total
                });
            });

            // Get other form data
            formData.totalPrice = parseFloat($('#total_price').text().trim());
            formData.paymentReceived = parseFloat($('#payment_received input').val());
            formData.exactChange = parseFloat($('#change').text().trim());
            formData.paymentMethod = $('input[name="payment_method"]:checked').val();

            return formData;
        }

        function displayOrderInformation(formData) {
            var orderInformationHtml = '<h2>Order Information</h2>';
            
            // Display products
            orderInformationHtml += '<h3>Products:</h3>';
            orderInformationHtml += '<ul>';
            formData.products.forEach(function(product) {
                orderInformationHtml += `<li>${product.quantity} x ${product.productName} (${product.size}): $${product.total.toFixed(2)}</li>`;
            });
            orderInformationHtml += '</ul>';

            // Display other form data
            orderInformationHtml += `<p>Total Price: $${formData.totalPrice.toFixed(2)}</p>`;
            orderInformationHtml += `<p>Payment Received: $${formData.paymentReceived.toFixed(2)}</p>`;
            orderInformationHtml += `<p>Exact Change: $${formData.exactChange.toFixed(2)}</p>`;
            orderInformationHtml += `<p>Payment Method: ${formData.paymentMethod}</p>`;

            // Append to the modal body
            $('#order_information').html(orderInformationHtml);

            // Show the modal
            $('#receiptModal').modal('show');
        }

        // Function to update the exact change based on payment received and total price
        function updateExactChange() {
            var paymentReceivedInput = $('#payment_received input');

            // Ensure that the input element is found before attempting to read its value
            if (paymentReceivedInput.length > 0) {
                var paymentReceivedValue = paymentReceivedInput.val().trim();
                var paymentReceived = parseFloat(paymentReceivedValue) || 0;
                var totalPrice = parseFloat($('#total_price').text()) || 0;

                var exactChange = Math.max(0, paymentReceived - totalPrice);

                // Update the exact change in the DOM
                $('#change').text(exactChange.toFixed(2));
            } else {
                console.error('Payment received input not found.');
            }
        }

        // Function to update the total price based on selected products
        function updateTotalPrice() {
            var total = 0;

            // Iterate over each selected product row
            $('#order_table tbody tr').each(function() {
                var priceText = $(this).find('#priceText').text();
                var price = parseFloat(priceText.replace(',', '')); // Remove comma and convert to float
                var quantity = parseInt($(this).find('input[name="quantity"]').val(), 10);

                total += price;
            });

            // Update the total price in the total row
            $('#total_price').text(total.toFixed(2));
        }

        // Modify the updatePrices function to trigger the total price update
        function updatePrices(element) {
            var row = $(element).closest('tr');
            var selectedSize = row.find('select[name="size"]').val();
            var quantity = row.find('input[name="quantity"]').val();

            $.ajax({
                url: '../config/price-function.php',
                method: 'POST',
                data: { size: selectedSize, product_name: row.find('td:first').text(), quantity: quantity },
                success: function(response) {
                    row.find('#priceText').text(response);
                    
                    // Trigger the update of total price after updating individual product price
                    updateTotalPrice();
                    updateExactChange();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

    </script>

</body>
</html>