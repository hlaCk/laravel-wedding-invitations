{{$invitation->message}}
<br>
{{now()->format("Y-m-d h:i:s a")}}
<hr>
@dump($invitation->toArray())
