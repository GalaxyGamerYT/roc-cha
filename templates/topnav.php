<?php
    declare(strict_types=1);
    $file = trim($_SERVER['REQUEST_URI'],"/");
    if (strpos($file,"?") != false) {
        $file = substr($file, 0, strpos($file, "?"));
    }

    $albums_active = False;
    if ($file == "albums.php") {
        $albums_active = True;
    }

    function checkActive(string $file, string $link): string | Null{
        if ($file == $link) {
            return "active";
        } else {
            return Null;
        }
    }

?>

<div class="topnav">
    <div class="nav_image"><img src=../assets/logo1_no_text_transparent_background.png class="navbar_image"></div>
    <a class="<?= checkActive($file,'index.php') ?>" href="../index.php">Home</a>
    <a class="<?= checkActive($file,'location.php') ?>" href="../location.php">Location</a>
    <a class="<?= checkActive($file,'about.php') ?>" href="../about.php">About Us</a>
    <a class="<?= checkActive($file,'albums.php') ?>" href="../albums.php">Albums</a>
    <?php
        if ($file == "info.php") {
            if ($searched) {
                echo "<a class='right' href='../albums.php?page={$page}&search={$searched_string}'>Back</a>";
            } else {
                echo "<a class='right' href='../albums.php?page={$page}'>Back</a>";
            }
        }

        if ($file == "albums.php") {
            echo "
            <div class='search_container'>
                <form action='../albums.php' method='get'>
                    <input type='text' placeholder='Search..' name='search'>
                    <button type='submit'><i class='fa fa-search'></i></button>
                </form>
            </div>";
        }
    ?>
</div>