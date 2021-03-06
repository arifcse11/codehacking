@extends('layouts.admin')


@section('content')


    @if(Session::has('created_category'))

        <p class="bg-success">{{session('created_category')}}</p>


    @endif

    @if(Session::has('updated_category'))

        <p class="bg-success">{{session('updated_category')}}</p>


    @endif


    @if(Session::has('deleted_category'))

        <p class="bg-danger">{{session('deleted_category')}}</p>


    @endif

    <h1>Categories</h1>



    <div class="col-sm-6">


{!! Form::open(['method'=>'POST', 'action'=>'AdminCategoriesController@store'])!!}


    <div class="form-group">

        {!! Form::label('name','Name:') !!}

        {!! Form::text('name', null , ['class'=>'form-control']) !!}

    </div>


        <div class="form-group">

            {!! Form::submit('Create Category', ['class'=>'btn btn-primary']) !!}


        </div>

    {!! Form::close() !!}



    </div>


    <div class="col-sm-6">

        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Created at</th>
            </tr>
            </thead>
            <tbody>

            @if($categories)

                @foreach($categories as $category)

                    <tr>
                        <td>{{$category->id}}</td>
                        <td><a href="{{route('admin.categories.edit',$category->id)}}">{{$category->name}}</a></td>
                        <td>john@example.com</td>
                    </tr>

                @endforeach

            @endif
            </tbody>
        </table>

    </div>


@stop