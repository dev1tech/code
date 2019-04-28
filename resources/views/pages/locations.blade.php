@extends('layouts.app')

@section('content')
    <div class="text-center lead p-5">
        {{$title}}
    </div>

    @if (isset($data) && !empty($data) && count($data) > 0) 
        <ul class="list-group">
            @foreach ($data  AS $id => $name)
                <li class="list-group-item">
                    <a href="/locations/{{$id}}">{{$name}}</a>
                </li>
            @endforeach
        </ul>
    @elseif (isset($list) && !empty($list) && count($list) > 0) 
        <ul class="list-group">
            @foreach ($list  AS $id => $name)
                <li class="list-group-item">
                    <a href="/locations/{{$locationid}}/floors/{{$id}}">{{$name}}</a>
                </li>
            @endforeach
        </ul>
    @elseif (isset($info) && !empty($info) && count($info) > 0)
        <ul class="list-group">
            <li class="list-group-item"><b>Number:</b> {{$info['number']}}</li>
            <li class="list-group-item"><b>Desks:</b> {{$info['desks']}}</li>
            <li class="list-group-item"><b>Description:</b> {{$info['description']}}</li>
        </ul>
    @elseif (isset($details) && !empty($details) && count($details) > 0)
        <ul class="list-group">
            <li class="list-group-item"><b>Name:</b> {{$details['name']}}</li>
            <li class="list-group-item"><b>Address:</b> {{$details['address']}}</li>
            <li class="list-group-item"><a href="/locations/{{$locationid}}/floors">List Floors</a></li>
        </ul>
    @else
        <ul class="list-group">
            <li class="list-group-item">{{$message}}</li>
        </ul>
    @endif
@endsection
