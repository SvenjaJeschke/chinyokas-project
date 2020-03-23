<?php

require_once('../../Database.php');

class BlogCommentController {
    public static function create($comment) {
        if ($comment['username'] && $comment['content']) {
            $pdo = Database::connect();
            $username = htmlspecialchars(addslashes($comment['username']));
            $content = htmlspecialchars(addslashes($comment['content']));
            $createBlogComment = $pdo->prepare(
                "insert into comments (username, content, blog_post_id) values (
                    '{$username}', 
                    '{$content}', 
                    {$comment['blog_post_id']}
                )"
            );
            try {
                $createBlogComment->execute();
            } catch (Exeption $e) {
                var_dump($e->getMessage());
            }
            
            return 'Your comment was sent to the blog creator.';
        }
        return 'Please enter the required information.';
    }

    public static function blogComments($id) {
        $pdo = Database::connect();
        $selectComments = $pdo->prepare("select * from comments where blog_post_id = {$id} order by created_at desc");
        $selectComments->execute();
        $comments = $selectComments->fetchAll(PDO::FETCH_OBJ);
        return $comments;
    }
}