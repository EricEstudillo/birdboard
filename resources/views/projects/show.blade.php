@extends('layouts.app')
@section('content')
    <header class="flex items-center py-4">
        <div class="flex justify-between items-center w-full">
            <p class="text-grey text-sm font-normal">
                <a href="/projects" class="text-sm font-normal text-grey no-underline">My Projects</a>
                / {{$project->title}}
            </p>
            <a href="/projects/create" class="button ">New Project</a>
        </div>
    </header>
    <main>
        <div class="lg:flex -m-3">
            <div class="lg:w-3/4 px-3 mb-8">
                <div class="mb-6">
                    <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>
                    {{--TASKS--}}
                    @foreach($project->tasks as $task)
                        <div class="card mb-3">{{$task->body}}</div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{$project->path().'/tasks'}}" method="post">
                            @csrf
                            <input name="body" class="w-full" placeholder="Begin adding tasks...">
                            <input type="submit" value="Create">
                        </form>
                    </div>
                </div>
                <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
                {{--General Notes--}}
                <textarea class="card w-full" style="min-height:200px">Lorem ipsum.</textarea>
            </div>
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects.partials.card')
            </div>
        </div>

    </main>
@endsection
