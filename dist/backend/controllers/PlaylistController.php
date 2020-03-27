<?php

require_once('../../Database.php');

class PlaylistController {

    public function all() {
        $pdo = Database::connect();
        $statement = $pdo->prepare('select * from playlists');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function urls() {
        $playlists = self::all();
        $urls = [];
        foreach ($playlists as $playlist) {
            $urls[] = $playlist->spotify_url;
        }
        return $urls;
    }

    public function create($name, $url) {
        $pdo = Database::connect();
        if ($url) {
            $statement = $pdo->prepare("insert into playlists (playlist_name, spotify_url) values ('{$name}', '{$url}')");
            $statement->execute();
            return 'success';
        } else {
            return 'Es wurde keine URL angegeben.';
        }
    }
}