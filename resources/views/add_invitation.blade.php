@extends('layouts.app')

@section('content')
<div class="container">
    <div class="invitation-content">
        <h1>إضافة دعوة جديدة</h1>
        <form method="post" action="{{ route('addInvitation') }}">
            @csrf
            <div class="form-group">
                <label class="label" for="unique_link">الرابط المميز:</label>
                <input class="input" type="text" name="unique_link">
            </div>
            <div class="form-group">
                <label class="label" for="message">الاسم:</label>
                <textarea class="input" name="message" rows="3"></textarea>
            </div>
            <button type="submit" class="button">إضافة الدعوة</button>
        </form>
    </div>
</div>
@endsection