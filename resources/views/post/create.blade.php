@extends('layouts.main')
@section('content')
    <div>
        <form action="{{route('post.store')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input value="{{old('title')}}" type="text" name="title" class="form-control" id="title" placeholder="Title">
                @error('title')
                <p class="text-bg-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea type="text" name="content" class="form-control" id="content" placeholder="Content">{{old('content')}}</textarea>
                @error('content')
                <p class="text-bg-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input value="{{old('image')}}" type="text" name="image" class="form-control" id="image" placeholder="Image">
                @error('image')
                <p class="text-bg-danger">{{$message}}</p>
                @enderror
            </div>

            <select class="form-select mb-3" aria-label="Default select example" id="category" name="category_id">
                @foreach($categories as $category)
                    <option
                        {{old('category_id') == $category->id ? 'selected' : ''}}
                        value="{{$category->id}}">{{$category->title}}</option>
                @endforeach
            </select>

            <select class="form-select mb-3" multiple aria-label="multiple select example" id="tags" name="tags[]">
                @foreach($tags as $tag)
                    <option
                        {{old('tags') != null && in_array($tag->id, old('tags')) ? 'selected' : ''}}
                        value="{{$tag->id}}">{{$tag->title}}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
