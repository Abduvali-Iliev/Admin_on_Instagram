@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row row-cols-1 row-cols-md-4 g-4 text-center">
            <div class="col">
                <h4 class="card-title">
                    Создатель: <br> {{$post->user->name}}
                    @if(isFollow($post->user))
                        <form action="{{route('follow')}}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$post->user->id}}">
                            <button class="btn btn-outline-success">Подписаться</button>
                        </form>
                    @else
                        <form action="{{route('unfollow')}}" method="post">
                            @method("DELETE")
                            @csrf
                            <input type="hidden" name="user_id" value="{{$post->user->id}}">
                            <button class="btn btn-outline-warning">Отписаться</button>
                        </form>
                    @endif
                </h4>
                <br>
                <div class="card">
                    <h4 class="card-title">{{$post->text}}</h4>
                    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($post->photos as $photo)
                                <div class="carousel-item active">
                                    <a href="{{route('posts.show', ['post' => $post])}}">
                                        <img src="{{asset('storage/' . $photo->picture)}}"
                                             style="width: 300px; height: 300px">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="likes" style="display: flex">
                    @if(isLike($post->user))
                        <form action="{{route('like')}}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$post->user->id}}">
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <button class="btn btn-outline-danger"><i class="bi bi-heart-fill">LIKE</i></button>
                        </form>
                    @else
                        <form action="{{route('unlike')}}" method="post">
                            @method("DELETE")
                            @csrf
                            <input type="hidden" name="user_id" value="{{$post->user->id}}">
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <button class="btn btn-outline-warning">Unlike</button>
                        </form>
                    @endif
                    <h5>Likes: {{$post->likes->count()}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <form action="{{route('comments.store')}}" method="post">
            @csrf
            <input type="hidden" name="post_id" value="{{$post->id}}">
            <div class="form-group">
                <label class="text-center">Оставить комментарий</label>
                <input type="text" class="form-control" name="text" value="{{old('text')}}">
                @error('text')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button id="create-rating-btn" type="submit"
                        class="mt-3 btn btn-outline-primary btn-sm btn-block">Add comment
                </button>
            </div>
        </form>

        <div class="row row-cols-1 g-4 pt-5">
            @foreach($post->comments as $comment)
                @if($comment->approved)
                    <div class="media g-mb-30 media-comment mt-3">
                        <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                            <div class="g-mb-15">
                                <h5 class="h5 g-color-gray-dark-v1 mb-0">{{$comment->user->name}}</h5>
                                <h5 class="h5 g-color-gray-dark-v1 mb-0">{{$comment->text}}</h5>
                                <span
                                    class="g-color-gray-dark-v4 g-font-size-12">{{$comment->created_at->diffForHumans()}}</span>
                            </div>
                            <div class="actions pt-2" style="display: flex">
                                @can('delete-comment', $comment)
                                    <form id="delete-comment"
                                          action="{{route('comments.destroy', ['post' => $post,'comment' => $comment])}}"
                                          method="post">
                                        @method('delete')
                                        @csrf
                                        <button id="delete-comment-btn" type="submit"
                                                class="mx-2 btn btn-outline-danger btn-block">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="row pt-1">
            <div class="col">
                {{$post->comments->links()}}
            </div>
        </div>
    </div>
@endsection
