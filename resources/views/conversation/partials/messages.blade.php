@foreach($conversation as $conv)
    @include('conversation.partials.message', ['msg' => $conv, 'user' => $user, 'ticket' => $ticket])
@endforeach