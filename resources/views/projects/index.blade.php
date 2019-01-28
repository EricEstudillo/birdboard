@extends('layouts.app')
@section('content')
    <div style="display: flex;align-items: center">
        <h1 style="margin-right: auto">Birdboard</h1>
        <a href="/projects/create">New Project</a>
    </div>
    <ul>
        @forelse($projects as $p)
            <li>
                <a href="{{$p->path()}}"><h4>{{$p->title}}</h4></a>
                <p>{{$p->paragraph}}</p>
            </li>
        @empty
            <li>No projects.</li>
        @endforelse
    </ul>
@endsection
