<?php

require_once('../../Database.php');

class BlogPostController {
    public static function create($postData) {
        if ($postData['title']) {
            $pdo = Database::connect();
            $body = addslashes($postData['body']);
            $title = addslashes($postData['title']);
            $is_public = $postData['is_public'] ? 'true' : 'false';
            $createBlogPost = $pdo->prepare(
                "insert into blog_posts 
                (title, body, is_public, category_id) values 
                ('{$title}', 
                '{$body}', 
                {$is_public}, 
                {$postData['category_id']})"
            );
            $createBlogPost->execute();
            return 'Your new blog post was created.';
        }
        return 'Please enter a title.';
    }

    public static function update($postData) {
        if ($postData['title']) {
            $pdo = Database::connect();
            $is_public = $postData['is_public'] ? 1 : 0;
            $body = addslashes($postData['body']);
            $title = addslashes($postData['title']);
            $updateBlogPost = $pdo->prepare(
                "update blog_posts set 
                title = '{$title}',
                body = '{$body}',
                is_public = {$is_public},
                category_id = {$postData['category_id']}
                where id = {$postData['id']}"
            );
            try {
                $updateBlogPost->execute();
            } catch (Exeption $e) {
                var_dump($e->getMessage());
            }
            
            return 'Your blog was updated and saved.';
        }
        return 'Please enter a title.';
    }
}