<?php

namespace App\Services;

use App\Models\Post;

class Slug {
    public function createSlug( $title, $id = 0 ) {
        $slug     = str_slug( $title );
        $allSlugs = $this->getRelatedSlugs( $slug, $id );
        if ( ! $allSlugs->contains( 'slug', $slug ) ) {
            return $slug;
        }
        for ( $i = 1; $i <= 10; $i ++ ) {
            $newSlug = $slug . '_' . $i;
            if ( ! $allSlugs->contains( 'slug', $newSlug ) ) {
                return $newSlug;
            }
        }
        throw new \Exception( 'Невозможно создать Slug' );
    }

    protected function getRelatedSlugs( $slug, $id = 0 ) {
        return Post::select( 'slug' )->where( 'slug', 'like', $slug . '%' )
                   ->where( 'id', '<>', $id )
                   ->get();
    }
}
