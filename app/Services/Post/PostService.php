<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Services\Slug;


class PostService {
    protected $slug;

    public function __construct( Slug $slug ) {
        $this->slug = $slug;
    }

    public function store( $data ) {
        $tags = $data['tags'];
        unset( $data['tags'] );

        $slug         = $this->slug->createSlug( $data['title'] ); //
        $data['slug'] = $slug;

        $post         = Post::create( $data );
        $post->tags()->attach( $tags );
    }

    public function update( $post, $data ) {
        $tags = $data['tags'];
        unset( $data['tags'] );

        $slug         = $this->slug->createSlug( $data['title'], $post->id ); // Генерация уникального слага
        $data['slug'] = $slug;

        $post->update( $data );
        $post->tags()->sync( $tags );
    }
}
