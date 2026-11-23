<?php

class Posts
{
    public static function getAll(){
        $posts = json_decode(file_get_contents("posts.json"), true);
        return $posts;
    }

    public static function saveAll($data){
        file_put_contents("posts.json", json_encode($data, JSON_PRETTY_PRINT));
    }

    public static function create($title, $text, $uid){
        $id = uniqid();
        $post = [
            "id" => $id,
            "title" => $title,
            "text" => $text,
            "uid" => $uid
        ];

        $posts = self::getAll();
        array_push($posts, $post);
        self::saveAll($posts);
    }

    public static function delete($id, $uid){
        $posts = self::getAll();

        $i = array_find_key($posts, function($p) use($id, $uid){
            return $p['id'] == $id && $p['uid'] == $uid;
        });

        unset($posts[$i]);
        self::saveAll($posts);
    }
}   