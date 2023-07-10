<?php
    $error_page = "templates/404.php";
    $error = false;

    if (empty($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
        if (intval($page) == 0) {
            http_response_code(404);
            $error = true;
            include($error_page);
            die();
        } else {
            $page = intval($page);
        }
    }

    require_once("php/database_connection.php");

    $searching = false;
    if (!empty($_GET['search'])) {
        $search = $_GET['search'];
        $searching = true;
    }

    $max_albums = 4;
    $offset = 0;
    $showing_albums = $max_albums;
    $limit = $max_albums;

    if ($searching) {
        $count_result = get_search_count($search);
        $count = ceil($count_result);
        $page_count = ceil($count_result/$max_albums);
    } else {
        $count_result = get_count("albums");
        $count = ceil($count_result);
        $page_count = ceil($count_result/$max_albums);
    }

    if ($page != 1) {
        $offset = ($max_albums * $page) - $max_albums;
        if ($offset + $max_albums > $count) {
            $limit = $count - $offset;
        }
    }

    if ($searching) {
        $albums = get_search($search,$limit,$offset);
    } else {
        $albums = get_all_albums($limit,$offset);
    }

?>
<html>
    <head>
        <title>Rock Chard Vinyl</title>
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/albums.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="icon" href="favcon.ico">
    </head>

    <body>
        <?php include "templates/topnav.php"; ?>
        <div class="content" style="background-image:url('assets/asset1.png');background-size:cover;background-repeat:none;">
            <h1 class="featured"><?= $searching ? "Search: {$search}" : "Featured"?></h1>
            <div class="container">
                <?php
                    if ($count == 0) {
                        echo "<div class='missing_album_container'>
                        <h2 class='missing_album'>Album Missing?</h2>
                        <a href='forms/album.php'>Click Here!</a>
                        </div>";
                    }
                ?>
                <div class="album_parent_container">

                    <?php 
                        
                        foreach ($albums as $album) {
                            $artist = get_artist_name_from_album($album['name']);
                            if ($searching) {
                                echo "<a href='info.php?id={$album['id']}&page={$page}&search={$search}'>";
                            } else {
                                echo "<a href='info.php?id={$album['id']}&page={$page}'>";
                            }
                            echo "<div class='album_child_container'>
                            <p class='name'>{$album['name']}</p>
                            <p class='artist'>{$artist}</p>
                            <div class='track_container'>
                            <p class='tracks'>Catalogue: {$album['id']}</p>
                            <p class='tracks'>Cost: £{$album['cost']}</p>
                            <p class='tracks'>Released: {$album['released']}</p>
                            </div></div></a>";
                        }
                    ?>
                </div>
                <div class="pagination_container">
                    <?php
                        if ($count > $max_albums) {
                            echo "<div class='pagination'>";
                            if ($page == 1) {
                                if ($searching) {
                                    echo "<a href='albums.php?page={$page}&search={$search}'>&laquo;</a>";
                                } else {
                                    echo "<a href='albums.php?page={$page}'>&laquo</a>";
                                }
                            } else {
                                $previous_page = $page-1;
                                if ($searching) {
                                    echo "<a href='albums.php?page={$previous_page}&search={$search}'>&laquo;</a>";
                                } else {
                                    echo "<a href='albums.php?page={$previous_page}'>&laquo;</a>";
                                }
                            }
                            
                            for ($z = 0; $z < $page_count; $z++) {
                                if ($z == $page-1) {
                                    if ($searching) {
                                        echo "<a href='albums.php?page={$page}&search={$search}' class='active'>{$page}</a>";
                                    } else {
                                        echo "<a href='albums.php?page={$page}' class='active'>{$page}</a>";
                                    }
                                } else {
                                    $page_counter = $z+1;
                                    if ($searching) {
                                        echo "<a href='albums.php?page={$page_counter}&search={$search}'>{$page_counter}</a>";
                                    } else {
                                        echo "<a href='albums.php?page={$page_counter}'>{$page_counter}</a>";
                                    }
                                }
                            }
                            if ($page == $page_count) {
                                if ($searching) {
                                    echo "<a href='albums.php?page={$page}&search={$search}'>&raquo;</a>";
                                } else {
                                    echo "<a href='albums.php?page={$page}'>&raquo;</a>";
                                }
                            } else {
                                $next_page = $page+1;
                                if ($searching) {
                                    echo "<a href='albums.php?page={$next_page}&search={$search}'>&raquo;</a>";
                                } else {
                                    echo "<a href='albums.php?page={$next_page}'>&raquo;</a>";
                                }
                            }
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>