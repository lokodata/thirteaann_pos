<?php
    require "../config/admin-authentication.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThirTeaAnn</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/dashboard.css">
    <?php include('../config/config.php'); ?>
</head>
<body>
    <?php require "../config/admin-sidebar.php"; ?>

    <div class="main-content">
        <div class="header">
            <div class="card">
                <p>Best Seller</p>
                <?php 
                    $result = $mysqli->query("SELECT product_name, SUM(quantity) as total_quantity FROM order_items GROUP BY product_name ORDER BY total_quantity DESC LIMIT 1;");

                    if ($result && $row = $result->fetch_assoc()) {
                        $productName = $row['product_name'];
                        echo "<p>$productName</p>";
                    } else {
                        echo "<p>No data found or error: " . $mysqli->error . "</p>";
                    }

                    $result->free();
                ?>
            </div>
            <div class="card">
                <p>Orders</p>
                <?php 
                    $result = $mysqli->query("SELECT COUNT(*) AS total_orders FROM order_table;");

                    if ($result && $row = $result->fetch_assoc()) {
                        $totalOrders = $row['total_orders'];
                        echo "<p>$totalOrders</p>";
                    } else {
                        echo "<p>No data found or error: " . $mysqli->error . "</p>";
                    }

                    $result->free();
                ?>
            </div>
            <div class="card">
                <p>Sales</p>
                <?php 
                    $result = $mysqli->query("SELECT SUM(total_price) AS total_sales FROM order_table;");

                    if ($result && $row = $result->fetch_assoc()) {
                        $totalSales = $row['total_sales'];
                        echo "<p>$totalSales</p>";
                    } else {
                        echo "<p>No data found or error: " . $mysqli->error . "</p>";
                    }

                    $result->free();
                ?>
            </div>
            
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require '../config/config.php';

                        $stmt = $mysqli->prepare("SELECT order_id, date, total_price FROM order_table");
                        $stmt->execute();
                        $stmt->bind_result($order_id, $date, $total_price);

                        // Initialize an array to store the results
                        $orderResults = [];

                        while ($stmt->fetch()) {
                            // Store each row in the array
                            $orderResults[] = [
                                'order_id' => $order_id,
                                'date' => $date,
                                'total_price' => $total_price,
                            ];
                        }

                        // Close the statement
                        $stmt->close();

                        $stmt = $mysqli->prepare("SELECT order_id, product_name FROM order_items");
                        $stmt->execute();
                        $stmt->bind_result($order_id, $product_name);

                        $orderItems = [];

                        while ($stmt->fetch()) {
                            $orderItems[] = [
                                'order_id' => $order_id,
                                'product_name' => $product_name,
                            ];
                        }

                        // Echo the results into the table using a different while loop
                        foreach ($orderResults as $order) {
                            echo "<tr>";
                            echo "<td>{$order['order_id']}</td>";
                            echo "<td>{$order['date']}</td>";
                            echo "<td>";
                            foreach ($orderItems as $orderItem) {
                                if ($orderItem['order_id'] == $order['order_id']) {
                                    echo "{$orderItem['product_name']} <br>";
                                }
                            }
                            echo "</td>";
                            echo "<td>{$order['total_price']}</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

<?php $mysqli->close(); ?>
</body>
</html>