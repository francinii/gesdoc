<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gesdoc</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    </head>
<body>
<div class="container">
    <h2 class="text-center">Nuevo Rol</h2>
    
    <form action="{{ url('/rols') }}" method="POST">
     {{csrf_field()}}
      <div class="form-group">
        <label for="rol">Nombre del rol:</label>
        <input type="text" class="form-control" id="rol" placeholder="Nombre del rol" name="description">
      </div>      
      <button type="submit" class="btn btn-success">Agregar</button>
    </form>
  </div>
</body>
</html>