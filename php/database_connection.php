<?php
    declare(strict_types=1);

    $db = new PDO(
        dsn: 'sqlite:/Users/Oliwooton/Documents/Rock Chard/database/rock_chard.db',
        username: null,
        password: null,
    );

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
        $statement = get_data("SELECT * FROM albums LIMIT ? OFFSET ?", [$limit,$offset]);
        return $statement->fetchAll();
    }

    function get_one_album($id): object {
        $statement = get_data("SELECT * FROM albums WHERE id = ?", [$id]);
        return $statement->fetchObject();
    }

    function get_tracks($id): array {
        $statement = get_data("SELECT * FROM tracks WHERE album_id = ?", [$id]);
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
?>