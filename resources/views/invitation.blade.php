@extends('layouts.app')

@section('title', $invitation?->message)
@section('content')
    <div class="container">
        <div class="invitation-content" style="cursor: pointer;">
            <h1 class="hidden">دعوة زواج</h1>
            <h1 class="invitation-name">{{ $invitation->message }}</h1>

            <form class="Change-status hidden" method="post" action="{{ route('checkPassword', ['unique_link' => $invitation->unique_link]) }}">
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
        let nameElm = document.querySelector(".invitation-name");
        let videoElm = document.querySelector("video");
        let Attend = function () {
            if ((++c > 5) && confirm("تاكيد الحضور؟")) {
                c = 0;

                return fetch("{{route('changeStatus', $invitation)}}")
                    .then(x => {
                        x.status === 200 && (location.href = "{{route('thx')}}");
                    })
            }

            if (c > 5) {
                c = 0;
            }

            return false;
        }

        videoElm.addEventListener('click', (event)=>{
            event.preventDefault();
            event.stopPropagation();
            Attend();
        });

        nameElm.addEventListener('click', function (event) {
            if (nameElm.style.fontSize) {
                return false;
            }
            nameElm.style.fontSize = "300px";
            nameElm.style.backgroundColor = "#ccc";
            setTimeout(() => {
                nameElm.style.fontSize = '';
                nameElm.style.backgroundColor = '';
            }, 5000)
            return false;
        });
        let c2 = 0;
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('invitation-name')) {
                return false;
            }
            if (event.target.classList.contains('invitation-content')) {
                if (confirm("هل تريد فتح خريطة الموقع؟")) {
                    location.href = "https://goo.gl/maps/QyGpo5GhWXkXVnjF8";
                } else {
                    c2++;
                }

                if (c2 >= 5) {
                    c2 = 0;
                    c = 6;
                    Attend();
                }
                return false;
            }
        });
    </script>
@endpush
