<!-- resources/views/dashboard/index.blade.php -->

<a href="{{ route('logout') }}">Logout</a><br>
------------------------<br>
<a href="{{ route('assignment') }}">Assignment</a><br>
------------------------<br>
<a href="{{ route('riddle') }}">Riddle</a><br>
------------------------<br>

@foreach ($users as $user)
    Role: {{ $user->role }}<br>
    Username: {{ $user->username }}<br>
    <a href="{{ route('infoUser', ['id' => $user->id]) }}">Info</a><br>
    ---<br>
@endforeach
