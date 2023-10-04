<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BlogBloom</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.cdnfonts.com/css/poppins" rel="stylesheet">
        @vite(['resources/js/app.js','resources/css/app.css' ,'resources/css/auth.css'])
    </head>
    <body>
       <div id="app">

       </div>
    </body>
</html>
