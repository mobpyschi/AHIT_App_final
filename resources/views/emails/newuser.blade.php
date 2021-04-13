@component('mail::message')
Dead Mr/Ms {{$name}},
<br>Your accout is :
<br>usesrname : {{$username}}
<br>password : {{$pass}}
@component('mail::button',['url'=>$link])
go to AHIT Page
@endcomponent
Sincerely,
<br>AHIT Corp.
@endcomponent
