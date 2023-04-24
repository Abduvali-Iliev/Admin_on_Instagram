@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h1 class="text-center pb-3">Изменить пост</h1>
        <form action="{{ route('posts.update', ['post' => $post])}}" method="post" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="form-group">
                <label>Наименование поста</label>
                <input type="text" class="form-control" name="text" value="{{$post->text}}">
                @error('text')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <div class="custom-file ">
                    <label class="custom-file-label form-control" for="customFile">Фотография</label>
                    @foreach($post->photos as $photo)
                    <img src="{{asset('/storage/' . $photo->picture)}}" alt="{{$photo->picture}}"
                         style="width:50px;height:50px;">
                    @endforeach
                    <input type="file" class="custom-file-input" multiple id="customFile" name="picture[]">
                    @error('picture')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button  type="submit" class="btn btn-primary mt-3">Сохранить</button>
        </form>
        <button  type="submit" class="btn btn-warning mt-3">
            <a href="{{route('posts.index')}}">Назад</a>
        </button>
    </div>
@endsection
