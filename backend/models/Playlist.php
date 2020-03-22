<?php

require_once('../../Database.php');

class Playlist {
    public $id;
    public $name;
    public $spotify_url;

    public function __construct(int $id) {
        $playlist = $this->select($id);
        $this->castFields($playlist);
    }

    protected function select(int $id) : stdClass 
    {
        $pdo = Database::connect();
        $selectPlaylist = $pdo->prepare(
            "select * from playlists where id = {$id}"
        );
        $selectPlaylist->execute();
        $playlists = $selectPlaylist->fetchAll(PDO::FETCH_OBJ);
        return $playlists[0];
    }

    protected function castFields(stdClass $playlist)
    {
        $this->id = (int) $playlist->id;
        $this->name = $playlist->playlist_name;
        $this->spotify_url = $playlist->spotify_url;
    }
}