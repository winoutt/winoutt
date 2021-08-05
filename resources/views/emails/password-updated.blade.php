@extends('emails.master')
@section('content')
<p>Hey {{ $user->first_name }},</p>
<p style="margin-bottom: 30px;">
  We noticed the password for your Oceanpace account was recently changed. If this was you, you can safely disregard this email. If this wasn't you, you can report us by clicking the below link.
</p>

@include('emails.button', [
  'text' => 'Report this Activity',
  'url' => url('help')
])
@endsection
