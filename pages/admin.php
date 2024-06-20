<?php
session_start();
include '../assets/connection.php';

if (isset($_SESSION['superAdmin'])) {
    $adminLvl = $_SESSION['superAdmin'];
} else {
    $adminLvl = $_SESSION['admin'];
}

// GET ALL PRODUCTS
$getProd = "SELECT * FROM products";
$setProd = mysqli_query($conn, $getProd);
$totalProducts = mysqli_num_rows($setProd);

// GET ALL PENDING ORDERS
$getPending = "SELECT * FROM orders WHERE status='Pending'";
$setPending = mysqli_query($conn, $getPending);
$totalPending = mysqli_num_rows($setPending);

// GET ALL COMPLETED ORDERS
$getCompleted = "SELECT * FROM orders WHERE status='Completed'";
$setCompleted = mysqli_query($conn, $getCompleted);
$totalCompleted = mysqli_num_rows($setCompleted);

// GET TOTAL PROFIT
$getProfit = "SELECT SUM(CAST(REPLACE(totalPrice, ',', '') AS DECIMAL(10,2))) AS totalProfit FROM orders WHERE status='Completed'";
$setProfit = mysqli_query($conn, $getProfit);

// GET DAILY TOTALPRICE
$getDailyTotalPrice = "SELECT DATE(ordered_at) AS order_date, SUM(CAST(REPLACE(totalPrice, ',', '') AS DECIMAL(10,2))) AS total_price
                      FROM orders
                      WHERE status = 'Completed' AND ordered_at >= CURDATE() - INTERVAL 7 DAY
                      GROUP BY order_date
                      ORDER BY order_date ASC";

$setDailyTotalPrice = mysqli_query($conn, $getDailyTotalPrice);
$dailyTotalPriceData = [];
while ($row = mysqli_fetch_assoc($setDailyTotalPrice)) {
    $date = date("Y-m-d", strtotime($row['order_date'])); // Format the date
    $dailyTotalPriceData[$date] = $row['total_price'];
}

// GET TOP 5 PRODUCTS
$sql = "SELECT cart_data FROM orders WHERE status ='Completed'";
$result = $conn->query($sql);

$cartData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Parse the JSON data in the cart_data column
        $cartData[] = json_decode($row['cart_data'], true);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
    
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
  <link rel="icon" type="image/png" href="../assets/images/icon/logo.png">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

  <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script defer src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script defer src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

  <script defer src="../assets/js/table.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script defer src="../assets/js/alert/alert.js"></script>
  <title>Admin</title>
</head>

<body>
  <div class="grid-container">
    <!-- Sidebar -->
    <?php include "../assets/php/extensions/sidebar.php" ?>
    <!-- End Sidebar -->

    <!-- Main -->
    <main class="main-container" id="main-container">
      <div class="main-title">
        <p class="font-weight-bold">DASHBOARD</p>
      </div>

      <div class="main-cards">

        <div class="ad-card">
          <div class="card-inner">
            <p class="text-primary" style="font-size: 1.3rem">PRODUCTS</p>
            <span class="text-primary font-weight-bold"><?php echo $totalProducts; ?></span>
          </div>
          <span class="material-icons-outlined text-blue" style="font-size: 1.5rem">inventory_2</span>
        </div>

        <div class="ad-card">
          <div class="card-inner">
            <p class="text-primary" style="font-size: 1.3rem">PENDING ORDERS</p>
            <span class="text-primary font-weight-bold"><?php echo $totalPending; ?></span>
          </div>
          <span class="material-icons-outlined text-orange" style="font-size: 1.5rem">add_shopping_cart</span>
        </div>

        <div class="ad-card">
          <div class="card-inner">
            <p class="text-primary" style="font-size: 1.3rem">COMPLETED ORDERS</p>
            <span class="text-primary font-weight-bold"><?php echo $totalCompleted; ?></span>
          </div>
          <span class="material-icons-outlined text-green" style="font-size: 1.5rem">shopping_cart</span>
        </div>

        <?php
        if ($setProfit) {
              $totalProfitRow = mysqli_fetch_assoc($setProfit);
              $totalProfit = $totalProfitRow['totalProfit'];

              // Output the total profit in the specified HTML format
              echo '<div class="ad-card">
                      <div class="card-inner">
                          <p class="text-primary" style="font-size: 1.3rem">PROFIT</p>
                          <span class="text-primary font-weight-bold">₱' . number_format($totalProfit, 2) . '</span>
                      </div>
                      <span class="material-icons-outlined text-red" style="font-size: 1.5rem">trending_up</span>
                    </div>';
          } else {
              // Handle the case where the query failed
              echo 'Error executing query: ' . mysqli_error($conn);
          }
        ?>

      </div>

      <div class="charts">
         <div class="charts-card">
            <p class="chart-title">Most Ordered Products</p>
            <div id="bar-chart"></div>
        </div>
        <div class="charts-card">
          <p class="chart-title">Daily Total Income</p>
          <div id="area-chart"></div>
        </div>

      </div>

    <?php include '../assets/php/extensions/session.php'; ?>
    </main>

    </div>

  <!-- Scripts -->
  <!-- ApexCharts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
  <!-- Custom JS -->
  <script src="../assets/js/dashboard.js"></script>
  <script defer src="../assets/js/ajax/admin.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Get the daily totalPrice data from PHP
    var dailyTotalPriceData = <?php echo json_encode($dailyTotalPriceData); ?>;
    
    // Extract dates and total prices
    var dates = Object.keys(dailyTotalPriceData);
    var totalPrices = Object.values(dailyTotalPriceData);

    // Render the area chart for daily total prices using ApexCharts
    var areaChartOptions = {
        series: [{
            name: 'Daily Total Price',
            data: totalPrices
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: {
                show: false,
            },
        },
        colors: ["#4f35a1"],
        dataLabels: {
            enabled: true,
        },
        stroke: {
            curve: 'smooth'
        },
        labels: dates,
        markers: {
            size: 1
        },
        yaxis: {
            title: {
                text: 'Profit Per Day',
            },
        },
        tooltip: {
            shared: true,
            intersect: false,
        }
    };

    var areaChart = new ApexCharts(document.querySelector("#area-chart"), areaChartOptions);
    areaChart.render();
});
</script>

 <script>
        // Use the fetched data to determine the top 5 most ordered products
        const cartData = <?php echo json_encode($cartData); ?>;
        const flattenedData = cartData.flat();

        const productQuantities = flattenedData.reduce((acc, curr) => {
            const prodName = curr.prod_name;
            const quantity = parseInt(curr.quantity) || 0; // Assuming quantity is a numeric field

            // Using prodName as the key and accumulating quantities
            acc[prodName] = (acc[prodName] || 0) + quantity;
            return acc;
        }, {});

        const sortedData = Object.entries(productQuantities)
            .sort((a, b) => b[1] - a[1])
            .slice(0, 5);

        const labels = sortedData.map(item => item[0]);
        const values = sortedData.map(item => item[1]);

        // Custom colors for the bars
        const barColors = ['#4CAF50', '#2196F3', '#FFC107', '#FF5722', '#9C27B0'];

        // Create the bar chart using ApexCharts with custom colors
        const options = {
            chart: {
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    colors: {
                        ranges: [{
                            from: 0,
                            to: 1,
                            color: barColors[0],
                        }, {
                            from: 1,
                            to: 2,
                            color: barColors[1],
                        }, {
                            from: 2,
                            to: 3,
                            color: barColors[2],
                        }, {
                            from: 3,
                            to: 4,
                            color: barColors[3],
                        }, {
                            from: 4,
                            to: 5,
                            color: barColors[4],
                        }],
                    },
                },
            },
            series: [{
                name: 'Quantity',
                data: values,
            }],
            xaxis: {
                categories: labels,
            },
        };

        const chart = new ApexCharts(document.getElementById('bar-chart'), options);
        chart.render();
    </script>
</body>

</html>
