<?php
    $error_page = "templates/404.php";
    $page = $_GET['page'];
    if (intval($page) == 0) {
        http_response_code(404);
        include($error_page);
        die();
    } else {
        $page = intval($page);
    }

    $album_id = $_GET['id'];
    if (intval($album_id) == 0) {
        http_response_code(404);
        include($error_page);
        die();
    } else {
        $album_id = intval($album_id);
    }

    $searched = false;
    if (!empty($_GET['search'])) {
        $searched_string = $_GET['search'];
        $searched = true;
    }

    require_once("php/database_connection.php");
    
    $album = get_one_album($album_id);

    $name = $album->name;
    $artist = $album->artist;
    $company = $album->company;
    $format = $album->format;
    $genre = $album->genre;
    $released = $album->released;
    $cost = $album->cost;

    $tracks = get_tracks($album_id);

    $count = get_count("tracks",[$album_id]);

    // $artist_string = str_replace(" ","_",$artist);
    // $artist_image = "assets/artists/{$artist_string}";
    // if (file_exists("{$artist_image}.jpeg")) {
    //     $artist_image = "{$artist_image}.jpeg";
    // } else if (file_exists("{$artist_image}.png")) {
    //     $artist_image = "{$artist_image}.png";
    // } else {
    //     $artist_image = "";
    // }
?>

<html>
    <head>
        <title>Rock Chard Vinyl</title>
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/info.css">
        <link rel="icon" href="favcon.ico">
    </head>

    <body>
        <?php include 'templates/topnav.php'?>
        <div class='content' style='background-image:url(<?= $artist_image ?>);background-size:cover;background-repeat:none;'>
            <div class="container">
                <div class="album_parent_container">
                    <div class="album_child_container">
                        <p><?php echo "<span>Name</span>: {$name}"?></p>
                        <p><?php echo "<span>Artist</span>: {$artist}"?></p>
                        <p><?php echo "<span>Company</span>: {$company}"?></p>
                        <p><?php echo "<span>Format</span>: {$format}"?></p>
                        <p><?php echo "<span>Genre</span>: {$genre}"?></p>
                        <p><?php echo "<span>Released</span>: {$released}"?></p>
                        <p><?php echo "<span>Cost</span>: £{$cost}"?></p>
                    </div>
                </div>
                <div class="track_parent_container">
                    <div class="track_child_container">
                        <h2>Tracks</h2>
                        <?php
                            if ($count==0) {
                                echo "<div class='no_tracks_container'><p class='no_tracks'>No Tracks Avaliable</p></div>";
                            } else {
                                echo "<table><tr>
                                <th>Number</th>
                                <th>Name</th>
                                <th>Length</th>
                                </rt>";
                                foreach ($tracks as $track) {
                                    echo "<tr><td>{$track['id']}</td>
                                    <td>{$track['name']}</td>
                                    <td>{$track['length']}</td>
                                    </tr>";
                                }
                                echo "</table>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>