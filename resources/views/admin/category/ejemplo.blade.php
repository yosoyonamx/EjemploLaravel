<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ejemplo</title>
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
</head>
<body>
    <style>
        .dimensiones{
            height: 200px;
        }
    </style>
    <div id="app">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="row my-3">
                        <div class="col-md-7">
                            <button class="btn btn-outline-primary" @click="formAdd">Agregar</button>
                            <button class="btn btn-outline-secondary" @click="formPrueba">Vistazo</button>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" v-model="nameSearch" @keyup="listCategory" placeholder="Categoria" aria-label="Las categorias">
                                <div class="input-group-append">
                                  <button class="btn btn-outline-secondary" type="button">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col card">
                            <h1 class="text-center">Categorias</h1>
                        </div>
                    </div>

                    <div class="row my-3">
                    {{-- start card --}}
                        <div v-for="(item,index) in arrayCategory" class="col-md-3 my-2">
                        <div class="card dimensiones">
                            <div class="card-body">
                                @{{ item.name }}
                            </div>
                            <div class="card-footer">
                                 <div class="row">
                                    <button type="button" @click="formEdit(item)" class="btn btn-warning btn-block">Edit</button>
                                    <button type="button" @click="formDelete(item.id)" class="btn btn-danger btn-block">Delete</button>
                                </div>
                             </div>
                        </div>
                    </div>

                    {{-- end card --}}
                    </div>

                    {{-- pagination --}}
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                          <li v-if="pagination.current_page > 1" class="page-item">
                            <a class="page-link" href="#" aria-label="Previous" @click.prevent="changePage(pagination.current_page-1)">
                              <span aria-hidden="true">&laquo;</span>
                              <span class="sr-only">Previous</span>
                            </a>
                          </li>
            
                          <li v-for="page in pagesNumber" :class="['page-item', page==isActived ? 'active':'']">
                              <a class="page-link" href="#" @click.prevent="changePage(page)">
                                  @{{ page }}
                              </a>
                           </li>
            
                          <li v-if="pagination.current_page < pagination.last_page" class="page-item">
                            <a class="page-link" href="#" aria-label="Next" @click.prevent="changePage(pagination.current_page+1)">
                              <span aria-hidden="true">&raquo;</span>
                              <span class="sr-only">Next</span>
                            </a>
                          </li>
                        </ul>
                      </nav>
                    {{-- end pagination --}}

                    {{-- <pre> @{{$data}} </pre> --}}

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/category.js') }}"></script>
</body>
</html>