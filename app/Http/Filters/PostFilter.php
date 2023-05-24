<?php


namespace App\Http\Filters;


use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;

class PostFilter extends AbstractFilter
{
    public const TAG_ID = 'tags';
    protected function getCallbacks(): array
    {
        return [
            self::TAG_ID => [$this, 'tagId'],
        ];
    }
    public function tagId(Builder $builder, $value)
    {
        $tag = Tag::where('slug', $value)->first();
        if ($tag) {
            $builder
                ->rightJoin('post_tags', 'posts.id', '=', 'post_tags.post_id')
                ->where('tag_id', $tag->id);
        }

    }
}
