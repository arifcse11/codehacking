@extends('layouts.blog-post')


@section('sidebar')

    <div class="col-lg-6">
        <ul class="list-unstyled">
            <li><a href="#">Category Name</a>
            </li>
            <li><a href="#">Category Name</a>
            </li>
            <li><a href="#">Category Name</a>
            </li>
            <li><a href="#">Category Name</a>
            </li>
        </ul>
    </div>

@stop

@section('content')

    <h1>{{$post->title}}</h1>

    <!-- Author -->
    <p class="lead">
        by <a href="#">{{$post->user->name}}</a>
    </p>

    <hr>

    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Posted {{$post->created_at->diffForHumans()}}</p>

    <hr>

    <!-- Preview Image -->
    <img class="img-responsive" src="{{$post->photo->file}}" alt="">

    <hr>

    <!-- Post Content -->

    <p>{{$post->body}}</p>

    <hr>



    @if(Session::has('comment_message'))

        <p class="bg-success">{{session('comment_message')}}</p>


    @endif


    @if(Session::has('reply_message'))

        <p class="bg-success">{{session('reply_message')}}</p>


    @endif


    @if(Auth::check())

    <div class="well">
        <h4>Leave a Comment:</h4>
        
        
        {!! Form::open(['method'=>'POST', 'action'=>'PostCommentsController@store'])!!}


        <input type="hidden" name="post_id" value="{{$post->id}}">
        
            <div class="form-group">
        
                {!! Form::label('body','Comment:') !!}
        
                {!! Form::textarea('body', null , ['class'=>'form-control', 'rows'=>3]) !!}
        
            </div>


        <div class="form-group">

            {!! Form::submit('Comment', ['class'=>'btn btn-primary']) !!}


        </div>
        
            {!! Form::close() !!}
        
        
        
    </div>

    @endif

    <hr>

    <!-- Posted Comments -->

    <!-- Comment -->

    @if(count($comments) > 0)

        @foreach($comments as $comment)

    <div class="media">
        <a class="pull-left" href="#">
            <img height="64" class="media-object" src="{{$comment->photo ? $comment->photo : '/images/default.jpg'}}" alt="">
        </a>
        <div class="media-body">
            <h4 class="media-heading">{{$comment->author}}
                <small>{{$comment->created_at->diffForHumans()}}</small>
            </h4>
            <p>{{$comment->body}}</p>


            @if(count($comment->replies) > 0)


                @foreach($comment->replies as $reply)

                    @if($reply->is_active == 1)


            <div id="nested-comment" class="media">
                <a class="pull-left" href="#">
                    <img height="64" class="media-object" src="{{$reply->photo ? $reply->photo : '/images/default.jpg'}}" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">{{$reply->author}}
                        <small>{{$reply->created_at->diffForHumans()}}</small>
                    </h4>
                    <p>{{$reply->body}}</p>
                </div>




            </div>

           @endif

                @endforeach

                @endif

            <div class="comment-reply-container">

                <button class="toggle-reply btn btn-primary pull-right">Reply</button>

                <div class="comment-reply col-sm-6">

            {!! Form::open(['method'=>'POST', 'action'=>'CommentRepliesController@createReply'])!!}


            <input type="hidden" name="comment_id" value="{{$comment->id}}">

            <div class="form-group">

                {!! Form::label('body','Reply:') !!}

                {!! Form::textarea('body', null , ['class'=>'form-control', 'rows'=>1]) !!}

            </div>


            <div class="form-group">

                {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}


            </div>

            {!! Form::close() !!}

                </div>

            </div>

        </div>
    </div>

    @endforeach

    @endif

    <!-- Comment -->




@stop


@section('scripts')


    <script>


        $(".comment-reply-container .toggle-reply").click(function () {


            $(this).next().slideToggle("slow");


            
        });



    </script>


@stop