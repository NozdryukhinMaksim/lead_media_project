@extends('layouts.main')
@section('content')
    <div><a href="{{route('tags.create')}}">Создать тэг</a></div>
    @foreach($tags as $tag)
        <div class="single-tag"><a href="{{ route('posts.index', ['tags' => $tag->slug]) }}">{{ $tag->title }}</a>
        <form action="{{ route('tags.destroy', $tag->id) }}" method="post">
            @csrf
            @method('DELETE')
            <input type="submit" value="Удалить">
        </form>
        <a href="{{route('tags.edit', $tag->id)}}">Изменить</a>
        </div>
    @endforeach
@endsection
