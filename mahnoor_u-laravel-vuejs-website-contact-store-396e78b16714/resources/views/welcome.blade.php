<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>ContactStore</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
  </head>
  <body>
    <div class="container">
      <div id="app">
        <contacts></contacts>
      </div>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
  </body>
</html>
