<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    @foreach($tasks as $task)
      <li>{{ $task }}</li>
    @endforeach
  </body>
</html>
