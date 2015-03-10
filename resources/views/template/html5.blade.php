<!DOCTYPE html>
<html lang="@yield('lang', 'en')">
<head>
  <title>@yield('title')</title>

  <meta charset="@yield('charset', 'utf-8')">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="_token" content="{!! Crypt::encrypt(csrf_token()) !!}" />
  @yield('meta', '')

  @yield('css', '')
</head>
<body>
  @yield('content')
  @yield('js', '')
</body>
</html>
