@extends('layouts.app')

@section('content')
<div class="container">
    <div class="invitation-content" style="cursor: pointer;">
        <h1 class="hidden">دعوة زواج</h1>
        <p class="text-sm">{{ $invitationData->message }}</p>
        <video controls>
            <source src="{{ asset('video.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <form class="change-status hidden" method="post" action="{{ route('checkPassword', ['unique_link' => $invitationData->unique_link]) }}">
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
</div>
@endsection

@push('js')
<script type="text/javascript">
    let c = 0;
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('invitation-content')) {
            location.href = "https://www.google.com/maps?q=%D9%82%D8%A7%D8%B9%D8%A9+%D8%A7%D9%84%D8%A7%D9%85%D9%8A%D8%B1%D8%A9+%D9%84%D9%84%D8%A7%D8%AD%D8%AA%D9%81%D8%A7%D9%84%D8%A7%D8%AA%D8%8C+%D8%A7%D9%84%D8%AF%D8%A7%D8%A6%D8%B1%D9%8A+%D8%A7%D9%84%D8%AC%D9%86%D9%88%D8%A8%D9%8A-+%D9%85%D8%AE%D8%B1%D8%AC+25+%D9%82%D8%A8%D9%84+%D9%82%D8%B5%D8%B1+%D8%A7%D9%84%D9%81%D9%8A%D8%B5%D9%84%D8%8C+%D8%A7%D9%84%D8%B1%D9%8A%D8%A7%D8%B6&ftid=0x3e2f0fde20db06dd:0x2f173300e1d36e45&hl=ar-SA&gl=sa&coh=183438&entry=gps&lucs=,47074637,47071704&g_ep=CAISBjYuNzkuMxgAINeCAyoSLDQ3MDc0NjM3LDQ3MDcxNzA0QgJTQQ%3D%3D&g_st=iw";
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