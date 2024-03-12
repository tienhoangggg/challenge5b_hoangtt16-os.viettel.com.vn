<a href='{{ route('home') }}'>Back</a><br>
@if ($riddles !== null)
    @foreach ($riddles as $riddle)
        <h3> Title: {{ $riddle->title }}</h3>
        <p> teacher: {{ $riddle->poster }}</p>
        <a href='{{ route('riddle.detail', ['id' => $riddle->id]) }}'>Detail</a><br>
        ------------------------<br>
    @endforeach
    @else
    <p>Riddle is empty.</p>
@endif
@if ($curUser['role'] === "teacher")
    <form action='{{ route('riddle') }}' method='post' enctype='multipart/form-data'>
        <input type='text' name='title' placeholder='Title'>
        <input type='text' name='description' placeholder='Description'>
        <input type='file' name='file'>
        <button type='submit' name='submit'>Upload</button>
    </form>
@endif