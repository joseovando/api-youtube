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
                <div class="alert alert-success" style=" width: 500px; height: 500px; overflow-y: scroll; overflow-x: scroll;" role="alert">
                    <h4 class="alert-heading">Well done!</h4>
                    <p>
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

                        if (!empty($_SESSION['upload_token'])) {
                            $client->setAccessToken($_SESSION['upload_token']);
                            if ($client->isAccessTokenExpired()) {
                                unset($_SESSION['upload_token']);
                                echo 'La sesion expiro. <a href="paso1.php">Volver a comenzar</a>';
                                die;
                            }
                        }

                        // Define an object that will be used to make all API requests.
                        $youtube = new Google_Service_YouTube($client);

                        // Check if an auth token exists for the required scopes
                        $tokenSessionKey = 'token-' . $client->prepareScopes();
                        if (isset($_GET['code'])) {
                            if (strval($_SESSION['state']) !== strval($_GET['state'])) {
                                die('The session state did not match.');
                            }

                            $client->authenticate($_GET['code']);
                            $_SESSION[$tokenSessionKey] = $client->getAccessToken();
                            header('Location: ' . $redirect);
                        }

                        if (isset($_SESSION[$tokenSessionKey])) {
                            $client->setAccessToken($_SESSION[$tokenSessionKey]);
                        }

                        // Check to ensure that the access token was successfully acquired.
                        if ($client->getAccessToken()) {
                            try {
                                // This code creates a new, private playlist in the authorized user's
                                // channel and adds a video to the playlist.

                                // 1. Create the snippet for the playlist. Set its title and description.
                                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                                $nombre = substr(str_shuffle($permitted_chars), 0, 3);

                                $playlistSnippet = new Google_Service_YouTube_PlaylistSnippet();
                                $playlistSnippet->setTitle('Joe ' . $nombre . ' ' . date("m-d H:i:s"));
                                $playlistSnippet->setDescription('A Joe private playlist created with the YouTube API v3');

                                // 2. Define the playlist's status.
                                $playlistStatus = new Google_Service_YouTube_PlaylistStatus();
                                $playlistStatus->setPrivacyStatus('private');

                                // 3. Define a playlist resource and associate the snippet and status
                                // defined above with that resource.
                                $youTubePlaylist = new Google_Service_YouTube_Playlist();
                                $youTubePlaylist->setSnippet($playlistSnippet);
                                $youTubePlaylist->setStatus($playlistStatus);

                                // 4. Call the playlists.insert method to create the playlist. The API
                                // response will contain information about the new playlist.
                                $playlistResponse = $youtube->playlists->insert(
                                    'snippet,status',
                                    $youTubePlaylist,
                                    array()
                                );

                                $playlistId = $playlistResponse['id'];

                                // Insertar foreach Video
                                $API_key = 'AIzaSyC2wPgAGNr5JFm2U5_0n2qrnARK4kV50is';

                                // Base datos
                                $sql = "SELECT * FROM canal WHERE orden > 0 ORDER BY top DESC, orden ASC";
                                //echo "SQL " . $sql;
                                $result = $conn->query($sql);

                                $fecha_actual = date("Y-m-d");
                                $date_future = strtotime('-8 day', strtotime($fecha_actual));
                                $date_future = date('Y-m-d', $date_future);

                                // echo "date_future " . $date_future . "<br>";

                                $htmlBody = "<h3>New Playlist</h3><ul>";

                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    while ($row = $result->fetch_assoc()) {

                                        $channelID  = str_replace("https://www.youtube.com/channel/", "", $row["id_canal"]);
                                        $maxResults = 2;
                                        $videoList = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=' . $channelID . '&maxResults=' . $maxResults . '&key=' . $API_key . ''));

                                        foreach ($videoList->items as $item) {
                                            //Embed video
                                            if (isset($item->id->videoId)) {

                                                $fecha_video = substr($item->snippet->publishedAt, 0, 10);
                                                $llave = 1; //Resetear LLave

                                                // echo "item->id->videoId " . $item->id->videoId . "<br>";
                                                // echo "fecha_video " . $fecha_video . "<br>";

                                                // videos vistos
                                                $sql3 = 'SELECT id_video FROM video WHERE id_video ="' . $item->id->videoId . '"';
                                                $result3 = $conn->query($sql3);
                                                if ($result3->num_rows > 0) {
                                                    while ($row3 = $result3->fetch_assoc()) {
                                                        $llave = 0;
                                                    }
                                                }

                                                // echo "SQL " . $sql3 . "<br>";

                                                if ($llave == 1) {

                                                    // echo "Llave " . $llave . "<br>";

                                                    // tiempo de busqueda de video 8 dias
                                                    if ($fecha_video >= $date_future) {

                                                        // 5. Add a video to the playlist. First, define the resource being added
                                                        // to the playlist by setting its video ID and kind.
                                                        $resourceId = new Google_Service_YouTube_ResourceId();
                                                        $resourceId->setVideoId($item->id->videoId);
                                                        $resourceId->setKind($item->id->kind);

                                                        // Then define a snippet for the playlist item. Set the playlist item's
                                                        // title if you want to display a different value than the title of the
                                                        // video being added. Add the resource ID and the playlist ID retrieved
                                                        // in step 4 to the snippet as well.
                                                        $playlistItemSnippet = new Google_Service_YouTube_PlaylistItemSnippet();
                                                        $playlistItemSnippet->setTitle('First video in the test playlist');
                                                        $playlistItemSnippet->setPlaylistId($playlistId);
                                                        $playlistItemSnippet->setResourceId($resourceId);

                                                        // Finally, create a playlistItem resource and add the snippet to the
                                                        // resource, then call the playlistItems.insert method to add the playlist
                                                        // item.
                                                        $playlistItem = new Google_Service_YouTube_PlaylistItem();
                                                        $playlistItem->setSnippet($playlistItemSnippet);
                                                        $playlistItemResponse = $youtube->playlistItems->insert(
                                                            'snippet,contentDetails',
                                                            $playlistItem,
                                                            array()
                                                        );

                                                        $htmlBody .= sprintf(
                                                            '<li>%s (%s)</li>',
                                                            $playlistResponse['snippet']['title'],
                                                            $playlistResponse['id']
                                                        );
                                                        $htmlBody .= '</ul>';

                                                        $htmlBody .= "<h3>New PlaylistItem</h3><ul>";
                                                        $htmlBody .= sprintf(
                                                            '<li>%s (%s)</li>',
                                                            $playlistItemResponse['snippet']['title'],
                                                            $playlistItemResponse['id']
                                                        );
                                                        $htmlBody .= '</ul>';

                                                        //Grabar video BD                                                  

                                                        $sql33 = 'INSERT INTO video 
                                (id_video, video, fecha, id_canal, canal, id_lista, lista, top) 
                                
                                VALUES (
                                "' . $item->id->videoId . '", 
                                "' . $item->snippet->title . '", 
                                "' . $fecha_actual . '", 
                                "' . $channelID . '", 
                                "' . $row["nombre"] . '", 
                                "' . $playlistItemResponse['id'] . '", 
                                "' . $playlistResponse['snippet']['title'] . '",
                                "' . $row["top"] . '"
                                )';

                                                        // echo "SQL " . $sql33 . "<br>";

                                                        if ($conn->query($sql33) === TRUE) {
                                                            //echo "New record created successfully";
                                                        } else {
                                                            echo "Error: " . $sql . "<br>" . $conn->error;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            } catch (Google_Service_Exception $e) {
                                $htmlBody = sprintf(
                                    '<p>A service error occurred: <code>%s</code></p>',
                                    htmlspecialchars($e->getMessage())
                                );
                            } catch (Google_Exception $e) {
                                $htmlBody = sprintf(
                                    '<p>An client error occurred: <code>%s</code></p>',
                                    htmlspecialchars($e->getMessage())
                                );
                            }

                            $_SESSION[$tokenSessionKey] = $client->getAccessToken();
                        } elseif ($OAUTH2_CLIENT_ID == 'REPLACE_ME') {
                            $htmlBody = <<<END
<h3>Client Credentials Required</h3>
<p>
You need to set <code>\$OAUTH2_CLIENT_ID</code> and
<code>\$OAUTH2_CLIENT_ID</code> before proceeding.
<p>
END;
                        } else {
                            // If the user hasn't authorized the app, initiate the OAuth flow
                            $state = mt_rand();
                            $client->setState($state);
                            $_SESSION['state'] = $state;

                            $authUrl = $client->createAuthUrl();
                            $htmlBody = <<<END
<h3>Authorization Required</h3>
<p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
                        }

                        $sql1 = "SELECT count(*) as total_canal from canal";
                        $result1 = $conn->query($sql1);
                        if ($result1->num_rows > 0) {
                            // output data of each row
                            while ($row1 = $result1->fetch_assoc()) {
                                $total_canal = $row1["total_canal"];
                            }
                        }

                        $sql2 = "SELECT count(*) as total_video from video";
                        $result2 = $conn->query($sql2);
                        if ($result2->num_rows > 0) {
                            // output data of each row
                            while ($row2 = $result2->fetch_assoc()) {
                                $total_video = $row2["total_video"];
                            }
                        }

                        ?>
                    </p>
                    <p> <?= $htmlBody ?></p>
                    <hr>
                    <p class="mb-0"></p>
                </div>
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