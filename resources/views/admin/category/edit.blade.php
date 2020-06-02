<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <form action="{{route('admin.category.update',$category->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{$category->name}}">
        </div>
        <div class="form-group">
            <input type="submit" value="Guardar Datos" class="btn btn-primary btn-sm">
        </div>
    </form>
</body>
</html>