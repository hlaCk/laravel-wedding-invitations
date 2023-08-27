@extends('layouts.app')

@section('content')
<div class="container">
    <div class="invitation-content" style="cursor: pointer;">
        <h1 class="hidden">دعوة زواج</h1>
        <p class="text-sm">{{ $invitationData->message }}</p>

        <form class="Change-status hidden" method="post" action="{{ route('checkPassword', ['unique_link' => $invitationData->unique_link]) }}">
            @csrf
            <div class="form-group" style="padding: 0 25px;">
                <label class="label" for="password">كلمة المرور:</label>
                <input class="input" type="password" name="password">
            </div>
            <button type="submit" class="button">تأكيد</button>
            @if ($errors->has('password'))
            <span class="error">{{ $errors->first('password') }}</span>
            @endif
        </form>
    </div>
    <video controls>
        <source src="{{ asset('video.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
@endsection

@push('js')
<script type="text/javascript">
    let c = 0;
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('invitation-content')) {
            location.href = "https://goo.gl/maps/QyGpo5GhWXkXVnjF8";
            return false;
        }

        if (c++ > 20) {
            fetch("{{route('changeStatus', $invitationData)}}")
                .then(x => {
                    x.status === 200 && (location.href = "{{route('thx')}}");
                })
            c = 0;
        }
        // document.querySelector('.change-status').classList.remove('hidden');
    });
</script>
@endpush
