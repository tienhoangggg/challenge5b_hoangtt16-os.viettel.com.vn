<a href='{{ route('home') }}'>Back</a><br>
@if ($assignments !== null)
    @foreach ($assignments as $assignment)
        <h3> Title: {{ $assignment->title }}</h3>
        <p> Teacher: {{ $assignment->poster }}</p>
        <a href='{{ route('assignment.detail', ['id' => $assignment->id]) }}'>Detail</a><br>
        ------------------------<br>
    @endforeach
    @else
    <p>Assignment is empty.</p>
@endif
@if ($curUser['role'] === "teacher")
    <form action='{{ route('assignment') }}' method='post' enctype='multipart/form-data'>
        <input type='text' name='title' placeholder='Title'>
        <input type='text' name='description' placeholder='Description'>
        <input type='file' name='file'>
        <button type='submit' name='submit'>Upload</button>
    </form>
@endif