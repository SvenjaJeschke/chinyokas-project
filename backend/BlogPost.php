<?php

require('Database.php');

class BlogPost {
    public static function create($postData) {
        if ($postData['title']) {
            $pdo = Database::connect();
            $is_public = $postData['is_public'] ? 1 : 0;
            $createBlogPost = $pdo->prepare(
                "insert into blog_posts (title, body, is_public, category_id) values (
                    '{$postData['title']}', 
                    '{$postData['body']}', 
                    {$is_public}, 
                    {$postData['category_id']}
                )"
            );
            try {
                $createBlogPost->execute();
            } catch (Exeption $e) {
                var_dump($e->getMessage());
            }
            
            return 'Your new blog post was created.';
        }
        return 'Please enter a title.';
    }
}