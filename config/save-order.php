<?php

require '../config/config.php';

// Check if the POST request contains the orderData parameter
if (isset($_POST['orderData'])) {
    $orderData = json_decode($_POST['orderData'], true);

    // Set date to today's date
    $date = date("Y-m-d H:i:s");

    // Fetch the current maximum receipt ID from the order_table
    $getMaxReceiptIdQuery = "SELECT MAX(CAST(SUBSTRING(receipt_id, 4) AS UNSIGNED)) AS max_receipt_number FROM order_table";
    $maxReceiptIdResult = $mysqli->query($getMaxReceiptIdQuery);

    if ($maxReceiptIdResult && $maxReceiptIdRow = $maxReceiptIdResult->fetch_assoc()) {
        $currentMaxReceiptNumber = $maxReceiptIdRow['max_receipt_number'];

        // Increment the receipt number
        $nextReceiptNumber = $currentMaxReceiptNumber + 1;

        // Generate a unique receipt ID with prefix "REC" and the incremented number
        $receiptId = 'REC' . $nextReceiptNumber;

        $totalPrice = $orderData['totalPrice'];
        $paymentReceived = $orderData['paymentReceived'];
        $exactChange = $orderData['exactChange'];
        $paymentMethod = $orderData['paymentMethod'];

        // Insert order data into the order_table
        $insertOrderQuery = "INSERT INTO order_table (date, receipt_id, total_price, payment_received, exact_change, payment_method) 
                             VALUES ('$date', '$receiptId', $totalPrice, $paymentReceived, $exactChange, '$paymentMethod')";

        if ($mysqli->query($insertOrderQuery) === TRUE) {
            // Get the order ID of the inserted record
            $orderId = $mysqli->insert_id;

            // Insert order items into the order_items table
            foreach ($orderData['products'] as $product) {
                $productName = $mysqli->real_escape_string($product['productName']);
                $size = $mysqli->real_escape_string($product['size']);
                $price = $product['price'];
                $quantity = $product['quantity'];
                $total = $product['total'];

                // Query the product_table to get the product_id
                $getProductIdQuery = "SELECT product_id FROM product_table WHERE product_name = '$productName' AND size = '$size'";
                $productIdResult = $mysqli->query($getProductIdQuery);

                if ($productIdResult && $productIdRow = $productIdResult->fetch_assoc()) {
                    $productId = $productIdRow['product_id'];

                    // Insert order item into the order_items table
                    $insertOrderItemQuery = "INSERT INTO order_items (order_id, product_id, product_name, size, price, quantity, total_price) 
                                             VALUES ($orderId, $productId, '$productName', '$size', $price, $quantity, $total)";

                    $mysqli->query($insertOrderItemQuery);
                } else {
                    echo 'Error getting product ID: ' . $mysqli->error;
                }
            }

            echo 'Order saved successfully';
        } else {
            echo 'Error saving order: ' . $mysqli->error;
        }
    } else {
        echo 'Error getting max receipt number: ' . $mysqli->error;
    }
} else {
    // If the orderData parameter is not present
    echo 'Invalid request';
}
?>
