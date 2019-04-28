@extends('layouts.app')

@section('content')
    <div class="text-center lead p-5">
        {{$title}}
    </div>

    @if (isset($data) && !empty($data) && count($data) > 0) 
        <ul class="list-group">
            @foreach ($data  AS $code => $name)
                <li class="list-group-item">
                    <a href="/{{$page}}/{{$code}}">{{$name}}</a>
                </li>
            @endforeach
        </ul>
    @else
        <ul class="list-group">
            <li class="list-group-item">{{$message}}</li>
        </ul>
    @endif   
@endsection