<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tags\StoreRequest;
use App\Http\Requests\Tags\UpdateRequest;
use App\Models\Tag;
use App\Services\Tags\TagService;
use Illuminate\Support\Facades\DB;

class TagsController extends BaseController {
    protected function getService() {
        return app( TagService::class );
    }

    public function index() {
        $tags = Tag::all();

        return view( 'tags.index', compact( 'tags' ) );
    }

    public function destroy( Tag $tag ) {
        DB::transaction( function () use ( $tag ) {
            $tag->posts()->delete(); // Удаляем связанные посты
            $tag->delete(); // Удаляем сам тег
        } );

        return redirect()->route( 'tags.index' );
    }

    public function edit( Tag $tag ) {
        return view( 'tags.edit', compact( 'tag' ) );
    }

    public function update( UpdateRequest $request, Tag $tag ) {
        $data = $request->validated();
        $this->service->update( $tag, $data );

        return redirect()->route( 'tags.index' );
    }

    public function create() {
        return view( 'tags.create' );
    }

    public function store( StoreRequest $request ) {
        $data = $request->validated();
        $this->service->store( $data );

        return redirect()->route( 'tags.index' );
    }
}
