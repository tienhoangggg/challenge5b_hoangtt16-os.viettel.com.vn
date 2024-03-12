<a href="{{ route('infoUser', ['id' => $id]) }}">Back</a><br>

@if ($chats !== null)
    @foreach ($chats as $msg)
        {{ $msg->username }}: 
        @if ($msg->sender === $curUser['id'])
            <form action="{{ route('editMessage') }}" method="post">
                <input type="hidden" name="isEdit" value="true">
                <input type="hidden" name="id" value="{{ $msg->id }}">
                <input type="hidden" name="id_user" value="{{ $id }}">
                <input type="text" name="message" value="{{ $msg->message }}">
                <input type="submit" value="Edit">
            </form>
        @else
            {{ $msg->message }}<br>
        @endif
        @if ($msg->sender === $curUser['id'])
            <form action="{{ route('deleteMessage') }}" method="post">
                <input type="hidden" name="isDelete" value="true">
                <input type="hidden" name="id" value="{{ $msg->id }}">
                <input type="hidden" name="id_user" value="{{ $id }}">
                <input type="submit" value="Delete">
            </form>
        @endif
        ----------------------------<br>
    @endforeach
    @else
    <p>box chat is empty.</p>
@endif

<form action="{{ route('sendChat', ['id' => $id]) }}" method="post">
    <input type="text" name="message">
    <input type="submit" value="Send">
</form>