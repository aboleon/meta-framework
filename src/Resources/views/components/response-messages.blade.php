<div class="messages">
    {!! wg_parse_response(session('session_response')) !!}
    @php
    session()->forget('session_response');
    @endphp
</div>
