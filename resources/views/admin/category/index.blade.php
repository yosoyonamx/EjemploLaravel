<link rel="stylesheet" href="{{asset('css/app.css')}}">
@if (session('mensaje'))
    <div class="alert alert-success">
        {{session('mensaje')}}
    </div>
@endif

<form  method="get">
    <input type="text" name="buscar">
    <button type="submit">Buscar</button>
</form>

<a href="{{route('admin.category.create')}}" class="btn btn-primary">Crear Category</a>
<ul>
    @foreach ($category as $item)
    <li>{{$item->name}}</li> <a href="{{route('admin.category.edit',$item->id)}}">Editar</a> <form method="POST"  action="{{route('admin.category.destroy',$item->id)}}">
        @csrf
        @method('delete')
        <button type="submit">Eliminar</button>
    </form>
    @endforeach
</ul>

 {{$category->links()}} 
