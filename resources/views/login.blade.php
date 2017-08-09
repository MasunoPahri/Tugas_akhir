<!DOCTYPE html>
<html >
<head>
	<meta charset="UTF-8">
	<title>Day 001 Login Form</title>  
  	<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>
	<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
</head>

<body>
  <div class="login-wrap">
	<div class="login-html">
		@if (Session::has('completed_user'))
			<div class="success-msg">{{ Session::get('completed_user') }}</div>
		@endif
		@if (Session::has('message'))
			<div class="login-error">{{ Session::get('message') }}</div>
		@endif
		<input id="tab-1" type="radio" name="tab" class="sign-in" {{ $cL }}>
		<label for="tab-1" class="tab">Sign In</label>
		<input id="tab-2" type="radio" name="tab" class="sign-up" {{ $cR }}>
        <label for="tab-2" class="tab">Sign Up</label>
		<div class="login-form">
			<form action="/WEB/login" method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="sign-in-htm">
					<div class="group">
						<label for="user" class="label">Username</label>
						<input id="user" type="text" name="username" class="input" required> 
					</div>
					<div class="group">
						<label for="pass" class="label">Password</label>
						<input id="pass" type="password" class="input" name="password" required>
					</div>
					<div class="group">
						<input type="submit" class="button" value="Sign In">
					</div>
					<div class="hr"></div>
					<div class="foot-lnk">
					</div>
				</div>
			</form>
			<form action="/WEB/register" method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="sign-up-htm">
					<div class="group">
						<label for="user" class="label">Username</label>
						<input id="user" type="text" name="username" class="input">
					</div>
					<div class="group">
						<label for="pass" class="label">Email Address</label>
						<input id="pass" type="text" name="email" class="input">
					</div>
					<div class="group">
						<label for="role" class="label">Daftar Sebagai</label>
						<select name="role" id="role" class="input" required>
							<option class="itemSelect">----</option>
							<option class="itemSelect" value="konsumen">Konsumen</option>
							<option class="itemSelect" value="penjahit">Penjahit</option>
						</select>
					</div>
					<div class="group">
						<label for="pass" class="label">Password</label>
						<input id="pass" type="password" name="pwd" class="input" data-type="password">
					</div>
					<div class="group">
						<label for="pass" class="label">Repeat Password</label>
						<input id="pass" type="password" name="repwd" class="input" data-type="password">
					</div>
					<div class="group">
						<input type="submit" class="button" value="Sign Up">
					</div>
					<div class="foot-lnk">
						<label for="tab-1">Sudah punya akun?</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
  
  
</body>
</html>
