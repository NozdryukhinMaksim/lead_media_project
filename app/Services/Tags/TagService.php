<?php

namespace App\Services\Tags;

use App\Models\Tag;
use App\Services\Slug;

class TagService {
    private $slugService;

    public function __construct( Slug $slugService ) {
        $this->slugService = $slugService;
    }

    public function store( $data ) {
        $slug         = $this->slugService->createSlug( $data['title'] );
        $data['slug'] = $slug;
        Tag::create( $data );
    }

    public function update( $tag, $data ) {
        $slug         = $this->slugService->createSlug( $data['title'], $tag->id );
        $data['slug'] = $slug;
        $tag->update( $data );
    }
}
