<a href="{{ route('infoUser', ['id' => $id]) }}">Back</a><br>

<form method='post' action="{{ route('editInfoUser', ['id' => $id]) }}" enctype='multipart/form-data'>
    <input type='hidden' name='id' value='{{ $id }}'>
    Empty field if you don't want to change<br>
    New Username: <input type='text' name='username'><br>
    Name: <input type='text' name='name'><br>
    Email: <input type='text' name='email'><br>
    Phone: <input type='text' name='phone'><br>
    New Password: <input type='password' name='password'><br>
    Avatar: <input type='file' name='avatar' accept='image/*'><br>
    <input type='submit' value='Submit'>
</form>