@extends('layouts.main')
@section('content')
    <form action="{{route('tags.update', $tag->id)}}" method="post">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="title">Название записи</label>
            <input type="text" class="form-input" id="title" name="title" placeholder="Введите название" value="{{$tag->title}}">
            @error('title')
            <span class="error-message">{{$message}}</span>
            @enderror
        </div>
        <button type="submit">Обновить</button>
    </form>
@endsection
