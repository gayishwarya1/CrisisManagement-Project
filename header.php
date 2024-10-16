<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>ManageCrisis</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
 
  ======================================================== -->
  <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #map {
            height: 400px;
        }
		#data-table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }
        #data-table th, #data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        #data-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body class="index-page">

  <header id="header" class="header fixed-top">


  
  <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          
        </div>
     
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-cente">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.png" alt=""> -->
          <h1 class="sitename">ManageCrisis</h1>
          <span>.</span>
        </a>

       <nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="index.php" class="">Risk Awareness For Citizen<br></a></li>
       
        <li><a href="CrisisScenario.php">Past Crisis Scenario</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Current Year Crisis Scenario</a>
            <ul class="dropdown-menu">
                <?php
                // Include config.php to establish database connection
                include 'config.php';

                // Get the current year
                $current_year = date('Y');

                // Query to fetch crisis scenarios occurring in the current year
                $query = "SELECT * FROM CrisisScenario WHERE YEAR(StartingTimeC) = '$current_year'";
                $result = $mysqli->query($query);

                // Check if there are any crisis scenarios for the current year
                if ($result->num_rows > 0) {
                    // Loop through each scenario and create dropdown items
                    while ($row = $result->fetch_assoc()) {
                        echo "<li><a href='CrisisScenarioDetails.php?id=" . htmlspecialchars($row['ID_ScenarioC']) . "'>" . htmlspecialchars($row['CrisisName']) . "</a></li>";
                    }
                } else {
                    // No crisis scenarios found for the current year
                    echo "<li>No crisis scenarios found for $current_year</li>";
                }

                // Close database connection
                $mysqli->close();
                ?>
				  
            </ul>
        </li>
        <li><a href="index.php#contact">Contact</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>



      </div>

    </div>


  </header>
