@csrf
<div class="field">
    <label class='label' for="title">Title</label>
    <div class="control">
        <input type="text" class="input" name="title" placeholder="title" value="{{$project->title}}" required>
    </div>
</div>

<div class="field">
    <label class='label' for="title">Description</label>
    <div class="control">
        <textarea class="textarea" name="description" required>{{$project->description}}</textarea>
    </div>
</div>
<div class="field">
    <div class="control">
        <button class="button is-link" type="submit">{{$buttonText}}</button>
        <a href="{{$project->path()}}">Cancel</a>
    </div>
</div>
@if($errors->any())
    <div class="field mt-6">
        @foreach($errors->all() as $error)
            <li class="text-sm text-red">{{$error}}</li>
        @endforeach
    </div>
@endif
