@extends('emails.master')
@section('content')
<p>Hey {{ $user->first_name }},</p>
<p style="margin-bottom: 30px;">
  Please click the below button to verify your email. If you didn’t create an account, you can safely delete this email.
</p>

@include('emails.button', [
  'text' => 'Verify Email',
  'url' => url('verify/' . $token)
])
@endsection