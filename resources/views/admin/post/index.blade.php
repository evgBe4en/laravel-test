@extends('layouts.admin')
@section('content')
    <div class="ml-3">
        <div>
            <a href="{{route('post.create')}}" class="btn btn-danger mb-3">Add post</a>
        </div>
        @foreach($posts as $post)
            <div><a href="{{route('post.show', $post->id)}}">{{$post->id}}.{{$post->title}}</a></div>
        @endforeach

        <div class="mt-3">
            {{$posts->withQueryString()->links()}}
        </div>

    </div>
@endsection
