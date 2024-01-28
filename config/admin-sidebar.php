
<style>
    body {
        display: flex;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    .main-content {
        flex-grow: 1;
    }

    .sidebar-wrapper {
        height: 100%;
        flex-basis: 10%;
        color: #00140E;

        display: flex;
        flex-direction: column;
        justify-content: space-between;

        padding: 30px 15px;
    }

    .sidebar-wrapper ol {
        list-style: none;
        padding: 0;
    }

    .logo-container {
        display: flex;
        flex-direction: column;

        margin-bottom: 50px;
    }

    .logo-container h1 {
        font-size: 18px;
        font-weight: 700;
    }

    .logo {
        width: 120px;
        height: 120px;

        border-radius: 50%;
    }

    .link-img {
        width: 24px;
        height: 24px;
        margin-right: 5px;
    }

    .sidebar ol {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    a {
        text-decoration: none;
        color: #00140E;
        display: flex;
        align-items: center;
        
        margin-bottom: 16px;

        font-size: 18px;
    }

    a:hover {
        color: #00DEA3;
        font-weight: 700;
    }

    .active-link {
        color: #00DEA3 !important;
        font-weight: 700;
    }

</style>

<div class="sidebar-wrapper">
    <div class="upper">
        <div class="logo-container">
            <img class="logo" src="../assets/logo-2.svg" alt="ThirTeaAnn">
        </div>

        <ol>
            <li>
                <a class="dashboard" href="dashboard.php">
                    <img class="link-img" src="../assets/sidebar_assets/dashboard-vector.svg">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="hrm.php">
                    <img class="link-img" src="../assets/sidebar_assets/hrm-vector.svg">
                    HRM
                </a>
            </li>
            <li>
                <a href="inventory.php">
                    <img class="link-img" src="../assets/sidebar_assets/inventory-vector.svg">
                    Inventory
                </a>
            </li>
            <li>
                <a href="orders.php">
                    <img class="link-img" src="../assets/sidebar_assets/orders-vector.svg">
                    Orders
                </a>
            </li>
            <li>
                <a href="order-records.php">
                    <img class="link-img" src="../assets/sidebar_assets/records-vector.svg">
                    Records
                </a>
            </li>
            <li>
                <a href="report.php">
                    <img class="link-img" src="../assets/sidebar_assets/report-vector.svg">
                    Report
                </a>
            </li>
        </ol>
    </div>

    <a href="../config/logout.php">
        <img class="link-img" src="../assets/sidebar_assets/logout-vector.svg"> 
        Logout
    </a>
</div>

<script>
    // Get the current page URL
    var currentPage = window.location.href;

    // Add the 'active-link' class to the corresponding link
    document.addEventListener('DOMContentLoaded', function () {
        var links = document.querySelectorAll('.sidebar-wrapper a');
        links.forEach(function (link) {
            if (link.href === currentPage) {
                link.classList.add('active-link');
            }
        });
    });
</script>