<?php
    declare(strict_types=1);
    $file = trim($_SERVER['REQUEST_URI'],"/");
    if (strpos($file,"?") != false) {
        $file = substr($file, 0, strpos($file, "?"));
    }

    function checkActive($file, $link) {
        if ($file == $link) {
            return "active";
        } else {
            return Null;
        }
    }
    
    if ($file == "rock-chard/forms/album.php") {
        $file_paths = "../../rock-chard/";
    } else {
        $file_paths = "../rock-chard/";
    }

?>

<div class="topnav">
    <div class="nav_image"><img src="<?= $file_paths."assets/logo1_no_text_transparent_background.png" ?>" class="navbar_image"></div>
    <a class="<?= checkActive($file,'rock-chard/index.php') ?>" href="<?= $file_paths."index.php" ?>">Home</a>
    <a class="<?= checkActive($file,'rock-chard/location.php') ?>" href="<?= $file_paths."location.php" ?>">Location</a>
    <a class="<?= checkActive($file,'rock-chard/about.php') ?>" href="<?= $file_paths."about.php" ?>">About Us</a>
    <a class="<?= checkActive($file,'rock-chard/albums.php') ?>" href="<?= $file_paths."albums.php" ?>">Albums</a>
    <?php
        if ($file == "rock-chard/info.php") {
            if ($searched) {
                echo "<a class='right' href='{$file_paths}albums.php?page={$page}&search={$searched_string}'>Back</a>";
            } else {
                echo "<a class='right' href='{$file_paths}albums.php?page={$page}'>Back</a>";
            }
        }

        if ($file == "rock-chard/albums.php") {
            if (!$error) {
                echo "
                <div class='search_container'>
                    <form action='{$file_paths}albums.php' method='get'>
                        <input type='text' placeholder='Search..' name='search'>
                        <button type='submit'><i class='fa fa-search'></i></button>
                    </form>
                </div>";
            }
        }
    ?>
</div>