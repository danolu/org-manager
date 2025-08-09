<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ $settings->favicon ?? 'https://www.flaticon.com/free-icons/vote' }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ $settings->favicon ?? 'https://www.flaticon.com/free-icons/vote' }}" type="image/x-icon">
    <title>{{ $settings->name ?? '' }} Election Portal - @yield('title')</title>
    <meta name="description" content="{{ $settings->name ?? '' }} Election Portal" />
    
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    @fluxAppearance
    @yield('style') 
  </head>
  <body>
    @yield('content')  
    @fluxScripts
  </body>
</html>