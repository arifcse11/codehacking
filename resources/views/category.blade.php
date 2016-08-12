@extends('layouts.blog-home')

@section('content')
    <div class="col-md-8">

        <h1 class="page-header">
            Page Heading
            <small>Secondary Text</small>
        </h1>

        <!-- First Blog Post -->

        @if($posts)

            @foreach($posts as $post)


                <h2>
                    <a href="#">{{$post->title}}</a>
                </h2>
                <p class="lead">
                    by <a href="index.php">{{$post->user->name}}</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span>{{$post->created_at->diffForHumans()}}</p>
                <hr>
                <img class="img-responsive" src="{{$post->photo ? $post->photo->file : '/images/default.jpg'}}" alt="">
                <hr>
                <p>{{str_limit($post->body,30)}}</p>
                <a class="btn btn-primary" href="{{route('post.home', $post->slug)}}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>


            @endforeach

        @endif





        <hr>


        <div class="row">
            <div class="col-sm-6 col-sm-offset-5">

                {{$posts->render()}}

            </div>
        </div>

    </div>
@endsection



{{--@section('category')

    @if($categories)

        @foreach($categories as $category)

            <ul class="list-unstyled">
                <li><a href="{{route('post.category',$category->name)}}">{{$category->name}}</a>
                </li>

            </ul>

        @endforeach

    @endif
@endsection--}}

