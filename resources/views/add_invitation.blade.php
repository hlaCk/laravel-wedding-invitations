@extends('layouts.app')

@section('content')
    <div class="container" style="text-align: right">
        <div class="invitation-content" style="background-image: none">

            @if($errors->any())
            <pre style="text-align: start; font-size: large; color: red; font-weight: bold;">  {!! implode('', $errors->all('<div>:message</div>')) !!}</pre>
            <hr>
            <br/>
            @endif

            <h1>إضافة دعوة جديدة</h1>
            <form method="post" action="{{ route('createInvitation') }}">
                @csrf
                <div class="form-group">
                    <label class="label" for="pass">كلمة المرور:</label>
                    <input class="input" value="{{old('pass', $invitation?->pass??null)}}" type="password" name="pass" required autofocus>
                </div>
                <div class="form-group">
                    <label class="label" for="unique_link">الرابط المميز:</label>
                    <input class="input" type="text" name="unique_link" value="{{old('unique_link', $invitation?->unique_link??null)}}" required>
                </div>
                <div class="form-group">
                    <label class="label" for="message">الاسم:</label>
                    <input value="{{old('message', $invitation?->message??null)}}" class="input" type="text" name="message" required>
                </div>
                <button type="submit" class="button">إضافة الدعوة</button>
            </form>
            <hr>
            <br/>
            <br/>
            <div style="border: 1px solid #ccc;border-collapse: collapse; text-align: center; width: auto;">
                <div style="text-align: left;font-size: small; font-weight: bold;color: blue"><pre>{{collect($invitations??[])->count()}} دعوة </pre></div>
                @foreach($invitations as $invitationData)
                <hr>
                <div style="width: auto;margin: 0 20px;">
                    <a style="width: 50%; text-align: start" target="_blank" href="{{url($invitationData->unique_link)}}">
                        {{$invitationData->id}}. {{$invitationData->unique_link}}: <span>{{$invitationData->message}}</span>
                    </a>
                    <a style="width: 25px; text-align: center;background-color: red;" onclick="confirm('هل انت متاكد؟') && (location.href='{{route('deleteInvitation', ['unique_link' => $invitationData->unique_link])}}')" href="#">
                        حذف
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
