@extends('emails.master')
@section('content')
<p>Hey {{ $user->first_name }},</p>
<p style="margin-bottom: 30px;">
  Please click the below button to reset your password. If you didn’t request to reset password, you can safely delete this email.
</p>

@include('emails.button', [
  'text' => 'Reset password',
  'url' => url('password/update/' . $token)
])
@endsection