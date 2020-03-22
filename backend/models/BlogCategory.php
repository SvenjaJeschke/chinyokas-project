<?php

require_once('../../Database.php');

class BlogCategory {
    public $id;
    public $name;

    public function __construct(int $id) {
        $category = $this->select($id);
        $this->castFields($category);
    }

    protected function select(int $id) : stdClass 
    {
        $pdo = Database::connect();
        $selectBlogCategory = $pdo->prepare(
            "select * from blog_categories where id = {$id}"
        );
        $selectBlogCategory->execute();
        $categories = $selectBlogCategory->fetchAll(PDO::FETCH_OBJ);
        return $categories[0];
    }

    protected function castFields(stdClass $category)
    {
        $this->id = (int) $category->id;
        $this->name = $category->name;
    }
}