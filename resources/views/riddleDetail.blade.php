<a href='{{ route('home') }}'>Back</a><br>
<h3> Title: {{ $riddles->title }}</h3>
<p> teacher: {{ $riddles->poster }}</p>
<p> Description: {{ $riddles->description }}</p>
<!-- form to upload submission -->
@if ($curUser['role'] === "student")
    <form action='{{ route('riddle.submit', ['id' => $id]) }}' method='post' enctype='multipart/form-data'>
        <input type='hidden' name='teacher' placeholder='teacher' value='{{ $riddles->teacher }}'>
        <input type='hidden' name='title' placeholder='title' value='{{ $riddles->title }}'>
        <input type='text' name='fileName' placeholder='fileName'>
        <button type='submit' name='submit'>Send</button>
    </form>
@endif