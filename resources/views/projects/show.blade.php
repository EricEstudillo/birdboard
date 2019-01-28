@extends('layouts.app')
@section('content')
    <h4>{{ $project->title }}</h4>
    <p>{{ $project->description }}</p>
    <a href="/projects">Go back</a>
@endsection
