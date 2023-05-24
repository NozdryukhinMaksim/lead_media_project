@extends('layouts.main')
@section('content')

    @if ($post->image)
        <img src="{{ asset($post->image) }}" alt="Изображение {{$post->title}}">
    @endif

        <div> {{$post->id}}. {{$post->title}}</div>
    <div> {{$post->content}}</div>
    <a href="{{route('posts.edit', $post->slug)}}">Изменить</a>
        <form action="{{route('posts.destroy', $post->id)}}" method="post">
            @csrf
            @method('delete')
            <input type="submit" value="Удалить">
        </form>

    <a href="{{route('posts.index')}}">Назад</a>
@endsection
