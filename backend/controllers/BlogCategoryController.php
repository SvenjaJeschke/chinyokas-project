<?php

require_once('../../Database.php');

class BlogCategoryController {
    public function create($name) {
        $pdo = Database::connect();
        if ($name) {
            $statement = $pdo->prepare("insert into blog_categories (name) values ('{$name}')");
            $statement->execute();
            return "The category {$name} was created.";
        }
        return 'Please enter a valid name.';
    }

    public function allWithPosts() {
        $pdo = Database::connect();
        $categoryStatement = $pdo->prepare('select * from blog_categories');
        $categoryStatement->execute();
        $categories = $categoryStatement->fetchAll(PDO::FETCH_OBJ);
        foreach ($categories as $category) {
            $blogPostStatement = $pdo->prepare("select * from blog_posts where category_id = {$category->id}");
            $blogPostStatement->execute();
            $posts = $blogPostStatement->fetchAll(PDO::FETCH_OBJ);
            if (count($posts) > 0) {
                $category->posts = $posts;
            }
        }
        return $categories;
    }

    public function all() {
        $pdo = Database::connect();
        $categoryStatement = $pdo->prepare('select * from blog_categories');
        $categoryStatement->execute();
        $categories = $categoryStatement->fetchAll(PDO::FETCH_OBJ);
        return $categories;
    }
}