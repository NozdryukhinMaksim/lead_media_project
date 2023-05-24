@extends('layouts.main')
@section('content')
    <div><a href="{{route('posts.create')}}">Создать пост</a></div>
    @foreach($posts as $post)
        <div><a href="{{route('posts.show', $post->slug)}}"> {{$post->title}} ({{$post->slug}})</a></div>
    @endforeach
@endsection
