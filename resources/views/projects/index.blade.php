@extends('layouts.app')
@section('content')
    <div class="flex items-center mb-3">
        <h1 class="mr-auto">Birdboard</h1>
        <a href="/projects/create">New Project</a>
    </div>
    <div class="flex">

        @forelse($projects as $project)
            <div class="bg-white mr-4 p-5 rounded shadow w-1/3" style="height: 200px">
                <div>
                    <h3 class="font-normal text-xl py-4">{{$project->title}}</h3>
                    <div class="text-grey">{{str_limit($project->description,100)}}</div>
                </div>
            </div>
            {{--<li>--}}
                {{--<a href="{{$p->path()}}"><h4>{{$p->title}}</h4></a>--}}
                {{--<p>{{$p->paragraph}}</p>--}}
            {{--</li>--}}
        @empty
            <div>No projects.</div>
        @endforelse
    </div>
@endsection
