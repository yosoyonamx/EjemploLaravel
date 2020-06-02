<?php

namespace App\Http\Controllers\admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*$buscar = $request->get('buscar');
        $category = Category::orderBy('id', 'desc')->where('name', 'LIKE', '%' . $buscar . '%')->paginate(5);
        return view('admin.category.index', compact('category'));*/
        $buscador = $request->get('search');
        $category = Category::orderBy('id','desc')->where('name','LIKE',"%$buscador%")->paginate(8);
        return [
            'pagination' => [
                'total'         => $category->total(),
                'current_page'  => $category->currentPage(),
                'per_page'      => $category->perPage(),
                'last_page'     => $category->lastPage(),
                'from'          => $category->firstItem(),
                'to'            => $category->lastItem()
            ],
            'category' => $category
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return redirect()->route('admin.category.index')->with('mensaje', 'Agregado con existo');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($name)
    {
        $category = Category::select('name')->where('name',$name)->get();
        return json_decode($category);
        // $category = Category::findOrFail($id);
        // return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        // return redirect()->back();
        // return redirect()->route('admin.category.index')->with('mensaje', 'Registro Grabado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        // return redirect()->route('admin.category.index')->with('mensaje', 'Registro Eliminado');
    }
}
