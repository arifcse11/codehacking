@extends('layouts.admin')



@section('content')


    <h1>Media</h1>


    <table class="table table-hover">
        <thead>
          <tr>
            <th>Id</th>
            <th>Photo</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody>


        @if($photos)

        @foreach($photos as $photo)

          <tr>
            <td>{{$photo->id}}</td>
            <td><img height="100" src="{{$photo->file}}" alt=""></td>
            <td>{{$photo->created_at->diffForHumans()}}</td>

              <td>

                  {!! Form::open(['method'=>'DELETE', 'action'=>['AdminMediasController@destroy', $photo->id]])!!}


                  <div class="form-group">

                      {!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}


                  </div>

                      {!! Form::close() !!}



              </td>

          </tr>

         @endforeach
         @endif

        </tbody>
      </table>



@stop
