@extends('layouts.app')
@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="heading is-1">Create new project</h1>
        <form method="post" action="/projects">
            @include('projects.partials.form',['project'=>new App\Project(),'buttonText' =>'Create Project'])
        </form>
    </div>
@endsection
