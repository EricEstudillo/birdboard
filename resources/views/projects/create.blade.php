@extends('layouts.app')
@section('content')
    <form method="post" action="/projects">
        @csrf
        <h1 class="heading is-1">Create a project</h1>
        <div class="field">
            <label class='label' for="title">Title</label>
            <div class="control">
                <input type="text" class="input" name="title" placeholder="title">
            </div>
        </div>

        <div class="field">
            <label class='label' for="title">Description</label>
            <div class="control">
                <textarea class="textarea" name="description"></textarea>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">Create project</button>
                <a href="/projects">Cancel</a>
            </div>
        </div>
    </form>
@endsection
