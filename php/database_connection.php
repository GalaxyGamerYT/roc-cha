<?php
    declare(strict_types=1);

    $db = new PDO(dsn: 'sqlite:/home/oli/public_html/rock-chard/database/rock_chard.db', username: null, password: null );

    function get_data(string $query, array $args = []): object {
        global $db;
        $statement = $db->prepare($query);
        $statement->execute($args);
        return $statement;
    }

    function get_count(string $table, array $args = []): int {
        $query = "SELECT count(*) FROM {$table}";
        if ($table == "tracks") {
            $query = $query . " WHERE album_id = ?";
        }
        $statement = get_data($query,$args);
        return ($statement->fetch())[0];
    }

    function get_all_albums(int $limit, int $offset): array {
        $query =  "SELECT * FROM albums LIMIT ? OFFSET ?";
        $statement = get_data($query, [$limit,$offset]);
        return $statement->fetchAll();
    }

    function get_one_album($id): object {
        $query = "SELECT albums.*,artists.name as artist FROM albums INNER JOIN artists ON albums.artist_id = artists.id WHERE albums.id = ?";
        $statement = get_data($query, [$id]);
        return $statement->fetchObject();
    }

    function get_tracks($id): array {
        $query = "SELECT * FROM tracks WHERE album_id = ?";
        $statement = get_data($query, [$id]);
        return $statement->fetchAll();
    }

    function get_search_count(string $search): int {
        $statement = get_data(get_search_query($search,true));
        return ($statement->fetch())[0];
    }

    function get_search(string $search, int $limit, int $offset): array {
        $statement = get_data(get_search_query($search,false),[$limit,$offset]);
        return $statement->fetchAll();
    }

    function get_search_query(string $search, bool $count): string {
        if ($count) {
            $query = "SELECT count(*) FROM albums WHERE ";
        } else {
            $query = "SELECT * FROM albums WHERE ";
        }
        $search_array = explode(' ',$search);
        for ($x = 0; $x < count($search_array); $x++) {
            $search_array[$x] = "name LIKE '%{$search_array[$x]}%'";
        }
        $query = $query . implode(" OR ",$search_array);
        if (!$count) {
            $query = $query . "LIMIT ? OFFSET ?";
        }
        return $query;
    }

    function get_artist_id($artist) {
        $query = "SELECT artist_id FROM artists WHERE name = ?";
        $statement = get_data($query,[$artist]);
        return ($statement->fetchObject())->artist_id;
    }

    function get_artist_id_from_album($album) {
        $query = "SELECT artists.artist_id FROM albums INNER JOIN artists ON albums.artist_id = artists.id WHERE albums.name = ?";
        $statement = get_data($query,[$album]);
        return ($statement->fetchObject())->artist_id;
    }

    function get_album_id($album) {
        $query = "SELECT album_id FROM albums WHERE name = ?";
        $statement = get_data($query,[$album]);
        return ($statement->fetchObject())->album_id;
    }

    function get_artist_name_from_album($album) {
        $query = "SELECT artists.name FROM albums INNER JOIN artists ON albums.artist_id = artists.id WHERE albums.name = ?";
        $statement = get_data($query,[$album]);
        return ($statement->fetchObject())->name;
    }
?>