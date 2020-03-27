<?php

require_once('../../Database.php');
require('BlogCategory.php');

class Post {
    public $id;
    public $title;
    public $body;
    public $is_public;
    public $category_id;
    public $likes;
    public $created_at;
    public $updated_at;
    public $deleted_at;
    public $category;

    public function __construct(int $id, bool $withCategory) {
        $post = $this->select($id);
        $this->castFields($post);
        if ($withCategory && $this->category_id) {
            $this->withCategory();
        }
    }

    protected function select(int $id) : stdClass 
    {
        $pdo = Database::connect();
        $selectBlogPost = $pdo->prepare(
            "select * from blog_posts where id = {$id}"
        );
        $selectBlogPost->execute();
        $posts = $selectBlogPost->fetchAll(PDO::FETCH_OBJ);
        return $posts[0];
    }

    protected function castFields(stdClass $post) {
        $this->id = (int) $post->id;
        $this->title = $post->title;
        $this->body = $post->body;
        $this->is_public = $post->is_public;
        $this->category_id = (int) $post->category_id;
        if ($post->likes) {
            $this->likes = (int) $post->likes;
        } else {
            $this->likes = 0;
        }
        $this->created_at = $post->created_at;
        $this->updated_at = $post->updated_at;
        $this->deleted_at = $post->deleted_at;
    }

    protected function withCategory() {
        $this->category = new BlogCategory($this->category_id);
    }
}
