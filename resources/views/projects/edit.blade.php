@extends('layouts.app')
@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="heading is-1">Edit your project</h1>
        <form method="post" action="{{$project->path()}}">
            @method('PATCH')
            @include('projects.partials.form',['buttonText' =>'Update Project'])
        </form>
    </div>
@endsection
