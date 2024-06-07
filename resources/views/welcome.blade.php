
@extends('layouts.master')
@section('title') Carriers @endsection

@section('content')
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
  <h2>Welcome to Websocket</h2>
    <span id="socketText"></span>
</div>

@endsection
@section('script')

<script>
    $(document).ready(function(){
        window.Echo.channel("chats").listen("MessageEvent", (event) => {
            console.log(event);
            $('#socketText').text(event.name)
        });

    });

</script>
@endsection


</html>
