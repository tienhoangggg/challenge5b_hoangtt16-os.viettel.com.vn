<a href='{{ route('assignment') }}'>Back</a><br>
<h3> Title: {{ $assignment->title }}</h3>
<p> Teacher: {{ $assignment->poster }}</p>
<p> Description: {{ $assignment->description }}</p>
<a href='{{ route('download', ['id' => $assignment->file]) }}'>Download</a><br>------------------------<br>
<!--show all submissions-->
@if ($submissions !== null)
    @foreach ($submissions as $submission)
        <p> Student: {{ $submission->poster }}</p>
        <a href='{{ route('download', ['id' => $submission->file]) }}'>Download</a>
        <p> Created at: {{ $submission->created_at }}</p>------------------------<br>
    @endforeach
    @else
    <p>Submission is empty.</p>
@endif
@if ($curUser['role'] === "student")
    <form action='{{ route('assignment.submit', ['id' => $id]) }}' method='post' enctype='multipart/form-data'>
        <input type='file' name='file'>
        <button type='submit' name='submit'>Submit</button>
    </form>
@endif
