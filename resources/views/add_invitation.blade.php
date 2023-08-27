@extends('layouts.app')

@section('content')
    <div class="container" style="text-align: right">
        <div class="invitation-content" style="background-image: none">
            <h1>إضافة دعوة جديدة</h1>
            <form method="post" action="{{ route('createInvitation') }}">
                @csrf
                <div class="form-group">
                    <label class="label" for="pass">الرابط المميز:</label>
                    <input class="input" type="password" name="pass" required autofocus>
                </div>
                <div class="form-group">
                    <label class="label" for="unique_link">الرابط المميز:</label>
                    <input class="input" type="text" name="unique_link" required>
                </div>
                <div class="form-group">
                    <label class="label" for="message">الاسم:</label>
                    <input class="input" type="text" name="message" required>
                </div>
                <button type="submit" class="button">إضافة الدعوة</button>
            </form>
            <hr>
            <br/>
            <br/>
            <div style="border: 1px solid black; text-align: center">
                @foreach($invitations as $invitationData)
                    <hr>
                    <br>
                    <br>
                    <div style="width: 100%">
                        {{$invitationData->id}}.
                        <a target="_blank" href="{{url($invitationData->unique_link)}}">{{$invitationData->unique_link}}</a> -
                        <span>{{$invitationData->message}}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
