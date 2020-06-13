@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            @include('users.card', ['user' => $user])
        </aside>
        <div class="col-sm-8">
            @if (Auth::id() == $user->id)
            {!! Form::open(['route' => ['microposts.update', $micropost->id], 'method' => 'put']) !!}
                    <div class="form-group">
                        {!! Form::textarea('content', $micropost->content, ['class' => 'form-control', 'rows' => '2']) !!}
                        {!! Form::submit('edit', ['class' => 'btn btn-primary btn-block']) !!}
                    </div>
            {!! Form::close() !!}
            @endif
        </div>
    </div>
@endsection