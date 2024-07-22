@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">
        @if(session('userName'))
        
            Welcome {{ session('userName') }} to our HR Partner
        @else
            Welcome to HR Partner
        @endif
    </h1>
    <p id="current-time" class="text-center">Time: </p>
</div>

<script>
    function updateTime() {
        const now = new Date();
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        document.getElementById('current-time').innerText = 'Current Date and Time: ' + now.toLocaleDateString('en-US', options);
    }


    setInterval(updateTime, 1000);


    updateTime();
</script>
@endsection