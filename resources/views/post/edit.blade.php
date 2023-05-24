@extends('layouts.main')
@section('content')
    <form action="{{route('posts.update', $post->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="title">Название записи</label>
            <input type="text" class="form-input" id="title" name="title" placeholder="Введите название" value="{{$post->title}}">
            @error('title')
            <span class="error-message">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="content">Описание записи</label>
            <textarea type="text" class="form-input" id="content" name="content" placeholder="Введите описание" >{{$post->content}}</textarea>
            @error('content')
            <span class="error-message">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="title">Изображение записи</label>
            <input type="file" name="image" id="image" >
            @error('image')
            <span class="error-message">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="title">Тэги</label>
            <select multiple class="form-select" id="tags" name="tags[]">
                @foreach($tags as $tag)
                    <option
                        @foreach($post->tags as $postTag)
                        {{$tag->id === $postTag->id ? 'selected' : ''}}
                        @endforeach
                        value="{{$tag->id}}">{{$tag->title}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Обновить</button>
    </form>
@endsection
