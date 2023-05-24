@extends('layouts.main')
@section('content')
    <form action="{{route('tags.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="title">Название тэга</label>
            <input type="text" value="{{old('title')}}" class="form-input" id="title" name="title" placeholder="Введите название">
            @error('title')
            <span class="error-message">{{$message}}</span>
            @enderror
        </div>
        <button type="submit">Создать</button>
    </form>
@endsection
