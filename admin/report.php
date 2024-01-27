<?php
    require "../config/admin-authentication.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThirTeaAnn</title>

    <link rel="stylesheet" href="../styles/report.css">

    <?php include('../config/config.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php require "../config/admin-sidebar.php"; ?>

    <div class="main-content">
        <h1>ThirTeaAnn Report</h1>
        
        <p>Visualizing your business data to aid in your business decisions.</p>

        <div class="card_1">
            <?php 
                $result = $mysqli->query("SELECT product_id, product_name, SUM(total_price) AS total_revenue FROM order_items GROUP BY product_id, product_name ORDER BY total_revenue DESC LIMIT 1;");
                
                if ($result && $row = $result->fetch_assoc()) {
                    list($productId, $productName, $totalRevenue) = [$row['product_id'], $row['product_name'], $row['total_revenue']];
                    echo "<p>Highest Selling Product</p>";
                    echo "<p>Product ID: $productId</p>";
                    echo "<p>Product Name: $productName</p>";
                    echo "<p>Total Revenue: $totalRevenue</p>";
                } else {
                    echo "<p>No data found or error: " . $mysqli->error . "</p>";
                }

                $result->free();
            ?>
        </div>

        <div class="card_2">
            <?php 
                $result = $mysqli->query("SELECT date, COUNT(*) AS total_orders FROM order_table GROUP BY date ORDER BY total_orders DESC LIMIT 1;");
                
                if ($result && $row = $result->fetch_assoc()) {
                    list($orderDate, $totalOrders) = [$row['date'], $row['total_orders']];
                    echo "<p>Day with Most Orders</p>";
                    echo "<p>Order Date: $orderDate</p>";
                    echo "<p>Total Orders: $totalOrders</p>";
                } else {
                    echo "<p>No data found or error: " . $mysqli->error . "</p>";
                }

                $result->free();
            ?>
        </div>

        <div class="card_3">
            <?php 
                $result = $mysqli->query("WITH MonthlyRevenue AS (SELECT DATE_FORMAT(date, '%Y-%m') AS month, SUM(total_price) AS total_revenue FROM order_table GROUP BY month)
                SELECT m1.month AS current_month, m1.total_revenue AS current_month_revenue, m2.month AS previous_month, m2.total_revenue AS previous_month_revenue, (m1.total_revenue - m2.total_revenue) / ABS(m2.total_revenue) * 100 AS revenue_growth_percentage FROM MonthlyRevenue m1 JOIN MonthlyRevenue m2 ON m1.month = DATE_FORMAT(CURDATE(), '%Y-%m') AND m2.month = DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m');
                ");

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $currentMonth = $row['current_month'];
                        $currentMonthRevenue = $row['current_month_revenue'];
                        $previousMonth = $row['previous_month'];
                        $previousMonthRevenue = $row['previous_month_revenue'];
                        $revenueGrowthPercentage = $row['revenue_growth_percentage'];

                        echo "<p>Revenue Growth</p>";
                        echo "<p>Current Month Revenue: $currentMonthRevenue</p>";
                        echo "<p>Previous Month Revenue: $previousMonthRevenue</p>";
                        echo "<p>Revenue Growth Percentage: $revenueGrowthPercentage%</p>";
                    }
                    $result->free();
                } else {
                    echo "<p>No data found or error: " . $mysqli->error . "</p>";
                }
            ?>
        </div>

        <!-- Data for Profit Margin Gauge -->
        <?php 
            $profitMargin = 65; // Example value, replace it with your actual data
        ?>

        <div class="SalesByDate">
            <canvas id="SalesByDate"></canvas>
        </div>

        <div class="SalesByCategory">
            <canvas id="SalesByCategory"></canvas>
        </div>

        <div class="Top10ProductsByQuantity">
            <canvas id="Top10ProductsByQuantity"></canvas>
        </div>

        <div class="Top10ProductsBySales">
            <canvas id="Top10ProductsBySales"></canvas>
        </div>
    </div>

    <!-- Data for Sales by Date -->
    <?php 
        $result = $mysqli->query("SELECT date, SUM(total_price) AS total_sales_date FROM order_table GROUP BY date ORDER BY date;");

        if ($result) {
            $dates = array();
            $totalsales_date = array();

            while ($row = $result->fetch_assoc()) {
                $dates[] = $row['date'];
                $totalsales_date[] = $row['total_sales_date'];
            }
            $result->free();
        } else {
            echo "<p>No data found or error: " . $mysqli->error . "</p>";
        }
    ?>

    <!-- Data for Sales by Category -->
    <?php 
        $result = $mysqli->query("SELECT pt.category, COALESCE(SUM(total_price), 0) AS total_sales_category FROM product_table pt LEFT JOIN order_items oi ON pt.product_id = oi.product_id GROUP BY pt.category ORDER BY total_sales_category DESC;");

        if ($result) {
            $categories = array();
            $totalsales_category = array(); 

            while ($row = $result->fetch_assoc()) {
                $categories[] = $row['category'];
                $totalsales_category[] = $row['total_sales_category'];
            }
            $result->free();
        } else {
            echo "<p>No data found or error: " . $mysqli->error . "</p>";
        }
    ?>

    <!-- Data for Top 10 Products By Quantity -->
    <?php 
        $result_quantity = $mysqli->query("SELECT product_name AS product_name_quantity, SUM(quantity) AS total_quantity_sold FROM order_items GROUP BY product_name ORDER BY total_quantity_sold DESC LIMIT 10;");

        if ($result_quantity) {
            $product_name_quantity = array();
            $totalquantitysold = array();

            while ($row = $result_quantity->fetch_assoc()) {
                $product_name_quantity[] = $row['product_name_quantity'];
                $totalquantitysold[] = $row['total_quantity_sold'];
            }
            $result_quantity->free();
        } else {
            echo "<p>No data found or error: " . $mysqli->error . "</p>";
        }
    ?>

    <!-- Data for Top 10 Products By Sales -->
    <?php 
        $result_sales = $mysqli->query("SELECT product_name as product_name_sales, COALESCE(SUM(total_price), 0) AS total_sales_product FROM order_items GROUP BY product_name ORDER BY total_sales_product DESC LIMIT 10;");

        if ($result_sales) {
            $product_name_sales = array();
            $totalsales_product = array();

            while ($row = $result_sales->fetch_assoc()) {
                $product_name_sales[] = $row['product_name_sales'];
                $totalsales_product[] = $row['total_sales_product'];
            }
            $result_sales->free();
        } else {
            echo "<p>No data found or error: " . $mysqli->error . "</p>";
        }
    ?>

    <script>
        // line chart for Sales by Date
        const ctx = document.getElementById('SalesByDate');
        const dates = <?php echo json_encode($dates); ?>;
        const totalsales_date = <?php echo json_encode($totalsales_date); ?>;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Sales by Date',
                    data: totalsales_date,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false, 
                        }
                    }
                }
            }
        });

        // bar chart for Sales By Category
        const ctx1 = document.getElementById('SalesByCategory');
        const categories = <?php echo json_encode($categories); ?>;
        const totalsales_category = <?php echo json_encode($totalsales_category); ?>;

        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Sales by Category',
                    data: totalsales_category,
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            display: false, 
                        }
                    }
                }
            }
        });

        // vertical bar chart for Top 10 Products By Quantity
        const ctx2 = document.getElementById('Top10ProductsByQuantity');
        const product_name_quantity = <?php echo json_encode($product_name_quantity); ?>;
        const totalquantitysold = <?php echo json_encode($totalquantitysold); ?>;

        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: product_name_quantity,
                datasets: [{
                    label: 'Top 10 Products By Quantity',
                    data: totalquantitysold,
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'x',
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false, 
                        }
                    }
                }
            }
        });

        // vertical bar chart for Top 10 Products By Sales
        const ctx3 = document.getElementById('Top10ProductsBySales');
        const product_name_sales = <?php echo json_encode($product_name_sales); ?>;
        const totalsales_product = <?php echo json_encode($totalsales_product); ?>;

        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: product_name_sales,
                datasets: [{
                    label: 'Top 10 Products By Sales',
                    data: totalsales_product,
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'x',
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false, 
                        }
                    }
                }
            }
        });

    </script>

<?php $mysqli->close(); ?>
</body>
</html>