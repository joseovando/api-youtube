<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Api Youtube - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Bocor - v4.7.1
  * Template URL: https://bootstrapmade.com/bocor-bootstrap-template-nice-animation/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<?php
require_once 'config.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "api-youtube";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT count(*) as total_canal from canal";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while ($row = $result->fetch_assoc()) {
    $total_canal = $row["total_canal"];
  }
}

$sql = "SELECT count(*) as total_video from video";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while ($row = $result->fetch_assoc()) {
    $total_video = $row["total_video"];
  }
}

// Actualizando Orden de Videos

$sql = "SELECT id FROM canal";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $orden = random_int(1, 9999);
    $sql = 'UPDATE canal SET orden=' . $orden . ' WHERE id=' . $row["id"];
    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Error updating record: " . $conn->error;
    }
  }
} else {
  echo "0 results";
}

$contador = 1;
$sql = "SELECT id FROM canal WHERE top = 3 ORDER BY orden ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    if ($contador <= 19) {
      $orden = random_int(1, 9999);
    } else {
      $orden = 0;
    }
    $sql = 'UPDATE canal SET orden=' . $orden . ' WHERE id=' . $row["id"];
    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Error updating record: " . $conn->error;
    }
    $contador++;
  }
} else {
  echo "0 results";
}

$contador = 1;
$sql = "SELECT id FROM canal WHERE top = 2 ORDER BY orden ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    if ($contador <= 19) {
      $orden = random_int(1, 9999);
    } else {
      $orden = 0;
    }
    $sql = 'UPDATE canal SET orden=' . $orden . ' WHERE id=' . $row["id"];
    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Error updating record: " . $conn->error;
    }
    $contador++;
  }
} else {
  echo "0 results";
}

$contador = 1;
$sql = "SELECT id FROM canal WHERE top = 1 ORDER BY orden ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    if ($contador <= 10) {
      $orden = random_int(1, 9999);
    } else {
      $orden = 0;
    }
    $sql = 'UPDATE canal SET orden=' . $orden . ' WHERE id=' . $row["id"];
    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Error updating record: " . $conn->error;
    }
    $contador++;
  }
} else {
  echo "0 results";
}

$sql = "SELECT id FROM canal WHERE top = 0 ORDER BY orden ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $orden = 0;
    $sql = 'UPDATE canal SET orden=' . $orden . ' WHERE id=' . $row["id"];
    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Error updating record: " . $conn->error;
    }
  }
} else {
  echo "0 results";
}

?>

<body>
  <!-- ======= Header ======= -->
  <header id="header">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="logo">
        <h1>
          <a href="index.php">Lister Generate<span>.</span></a>
        </h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="index.php">Home</a></li>
          <li><a class="nav-link scrollto" href="video-test.php">Test Api Videos</a></li>
          <li><a class="nav-link scrollto" href="https://cloud.google.com/?hl=es" target="_blank">Google Cloud</a></li>
          <li><a class="getstarted scrollto" href='<?php echo $client->createAuthUrl() ?>'>Conectar</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="container">
      <div class="row d-flex align-items-center"">
      <div class=" col-lg-6 py-5 py-lg-0 order-2 order-lg-1" data-aos="fade-right">
        <h1>Hola Jose</h1>
        <h2>Feliz Domingo</h2>
        <img src="img/logo.png" alt="youtube" width="30%" height=""><br>
        <a href='<?php echo $client->createAuthUrl() ?>' class="btn-get-started scrollto">Conectar</a>
      </div>
      <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left">
        <img src="assets/img/hero-img.png" class="img-fluid" alt="">
      </div>
    </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about section-bg">
      <div class="container">

        <div class="row gy-4">
          <div class="image col-xl-5"></div>
          <div class="col-xl-7">
            <div class="content d-flex flex-column justify-content-center ps-0 ps-xl-4">
              <h3 data-aos="fade-in" data-aos-delay="100">Estadisticas</h3>
              <div class="row gy-4 mt-3">
                <div class="col-md-6 icon-box" data-aos="fade-up">
                  <i class="bx bx-receipt"></i>
                  <h4><a href="#"><?php echo $total_canal; ?> Canales</a></h4>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                  <i class="bx bx-cube-alt"></i>
                  <h4><a href="#"><?php echo $total_video; ?> Videos</a></h4>
                </div>
              </div>
            </div><!-- End .content-->
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">

      <div class="container">

        <div class="row  justify-content-center">
          <div class="col-lg-6">
            <h3>Youtube Genedor de Listas</h3>
            <p>.:.</p>
          </div>
        </div>

      </div>
    </div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>Lister Generate</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/bocor-bootstrap-template-nice-animation/ -->
        Designed by <a href="#">Pondero</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>