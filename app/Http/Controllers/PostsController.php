<?php

namespace App\Http\Controllers;

use App\Http\Filters\PostFilter;
use App\Http\Requests\Post\FilterRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Services\Post\PostService;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostsController extends BaseController {
    protected function getService() {
        return app( PostService::class );
    }

    public function index( FilterRequest $request ) {

        $data   = $request->validated();
        $filter = app()->make( PostFilter::class, [ 'queryParams' => array_filter( $data ) ] );
        $posts  = Post::filter( $filter )->get();

        return view( 'post.index', compact( 'posts' ) );

        $data   = $request->validated();
        $filter = app()->make( PostFilter::class, [ 'queryParams' => array_filter( $data ) ] );
        $tags   = Tag::with( 'posts' )->get();

        return view( 'post.index', compact( 'tags' ) );

    }

    public function create() {
        $tags = Tag::all();

        return view( 'post.create', compact( 'tags' ) );
    }

    public function store( StoreRequest $request ) {
        $data = $request->validated();
        if ( $request->hasFile( 'image' ) ) {
            $image     = $request->file( 'image' );
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'post-images/' . $imageName;
            $thumbnail = Image::make( $image )->fit( 300, 300 );
            $thumbnail->save( public_path( $imagePath ) );
            $data['image'] = $imagePath;
        }
        $this->service->store( $data );

        return redirect()->route( 'posts.index' );
    }

    public function show( $slug ) {
        $post = Post::where( 'slug', $slug )->firstOrFail();

        return view( 'post.show', compact( 'post' ) );
    }

    public function edit( $slug ) {
        $tags = Tag::all();
        $post = Post::where( 'slug', $slug )->firstOrFail();

        return view( 'post.edit', compact( 'post', 'tags' ) );
    }

    private function deleteImage( $imagePath ) {
        $imagePath = str_replace( "post-images/", "", $imagePath );
        if ( Storage::disk( 'public' )->exists( $imagePath ) ) {
            Storage::disk( 'public' )->delete( $imagePath );
        }
    }

    public function update( UpdateRequest $request, Post $post ) {
        $data             = $request->validated();
        $currentImagePath = $post->image;
        if ( $request->hasFile( 'image' ) ) {
            if ( $currentImagePath ) {
                $this->deleteImage( $currentImagePath );
            }
            $image     = $request->file( 'image' );
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'post-images/' . $imageName;
            $thumbnail = Image::make( $image )->fit( 300, 300 );
            $thumbnail->save( public_path( $imagePath ) );
            $data['image'] = $imagePath;
        }
        $this->service->update( $post, $data );

        return redirect()->route( 'posts.show', $post->slug );
    }

    public function destroy( Post $post ) {
        $currentImagePath = $post->image;
        if ( $currentImagePath ) {
            $this->deleteImage( $currentImagePath );
        }
        $post->postTags()->detach();
        $post->delete();

        return redirect()->route( 'posts.index' );
    }
}
