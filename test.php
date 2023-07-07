<?php

    require_once("php/album_art_connection.php");
    require_once("php/database_connection.php");
    
    // header('Content-type: application/json');
    // header('Content-type: text/plain');
    $artist = "Alan Walker";
    $album = "Different World";

    $artist_id = getArtist($artist);
    // $artist_id = get_artist_id($artist);
    $album_id = getAlbum($artist_id, $album);
    // $album_id = get_album_id($album);
    // $image = append_filename(getArt($album_id),"1200");


    // $artist = get_artist_name_from_album($album);
    
    // var_dump($artist);
    // var_dump($artist_id);
    // var_dump($album_id);
    // var_dump($image);
?> 

<html>
    <head>
        <style>
            body {
                height: 100%;
                margin: 0;
            }

            .content {
                height: 100%;
            }
        </style>
    </head>

    <body>
        <!-- <div class="content" style="background-image:url(<?= $image ?>);background-size:cover;background-repeat:no-repeat;"></div> -->
    </body>
</html>