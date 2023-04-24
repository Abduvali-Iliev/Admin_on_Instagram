@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="header text-center" style="display: flex">
            <h3 class="px-5">Посты</h3>
            <div class="">
                <a href="{{route('posts.create')}}">
                    <button type="submit" class="btn btn-outline-primary">
                        Создать пост
                    </button>
                </a>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-2 pt-5 text-center">
            @foreach($posts as $post)
                <div class="col">
                    <div class="card">
                        <h4 class="card-title">{{$post->text}}</h4>
                        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($post->photos as $photo)
                                    <div class="carousel-item active">
                                        <a href="{{route('posts.show', ['post' => $post])}}">
                                            <img src="{{asset('storage/' . $photo->picture)}}"
                                                 style="width: 250px; height: 250px">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <div class="actions pt-2 px-5" style="display: flex">
                        @can('update-post', $post)
                            <a href="{{route('posts.edit', ['post' => $post])}}">
                                <button class="btn btn-outline-warning">
                                    Изменить
                                </button>
                            </a>
                        @endcan
                        @can('delete-post', $post)
                            <form id="delete-post" action="{{route('posts.destroy', ['post' => $post])}}"
                                  method="post">
                                @method('delete')
                                @csrf
                                <button id="delete-comment-btn" type="submit"
                                        class="mx-4 px-3 btn btn-outline-danger btn-block">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>

            @endforeach
        </div>
        <div class="justify-content-md-center p-5">

            <div class="col-md-auto">

                {{ $posts->links() }}

            </div>

        </div>
    </div>
@endsection
