@extends('layouts.main')
@section('content')
    <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Название записи</label>
            <input type="text" value="{{old('title')}}" class="form-input" id="title" name="title"
                   placeholder="Введите название">
            @error('title')
            <span class="error-message">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="content">Описание записи</label>
            <textarea type="text" class="form-input" id="content" name="content"
                      placeholder="Введите описание">{{old('content')}}</textarea>
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
                    <option value="{{$tag->id}}">{{$tag->title}}</option>
                @endforeach

            </select>
        </div>
        <button type="submit">Создать</button>
    </form>
@endsection
