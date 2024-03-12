<!-- resources/views/user/show.blade.php -->

<a href="{{ route('home') }}">Back</a><br>

Role: {{ $user->role }}<br>
Username: {{ $user->username }}<br>
Name: {{ $user->name }}<br>
Email: {{ $user->email }}<br>
Phone: {{ $user->phone }}<br>

@if ($user->avatar !== "")
    <img src="data:image/png;base64,{{ $data_avatar }}" alt="avatar"><br>
@endif

<a href="{{ route('chatBox', ['id' => $id]) }}">Chat</a><br>

@if ($curUser['id'] == $id || ($curUser['role'] === 'teacher' && $user->role === 'student'))
    <a href="{{ route('editInfoUser', ['id' => $id]) }}">Edit</a>
@endif
