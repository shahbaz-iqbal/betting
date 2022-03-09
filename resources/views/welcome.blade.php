<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- <script src="{{ mix('/js/app.js') }}"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
 
</head>

<body class="antialiased">
<div id="app">
<example-component></example-component>
   @{{message}}
   @{{message2}}
   @{{ info }}
</div>

  

<script src="http://localhost/musicapp/public/js/app.js"></script>
<!-- <script src="http://localhost/my-app/resources/js/app.js"></script> -->
 <!-- <script src="{{ mix('/js/app.js') }}"></script> -->
</body>

</html>
