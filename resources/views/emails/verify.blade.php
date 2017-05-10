<h1>Hey there, {{ $user->first_name }}!</h1>
<a href="{{ route('verify', ['id' => $user->id, 'token' => $user->verification_token]) }}">Click here to activate your account!</a>