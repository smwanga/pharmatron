<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Category;
use DataTables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = request()->get('group', 'dispense_unit');
        $data = [
            'forms' => true,
            'pagetitle' => trans('main.'.$page).' '.trans('main.category'),
            'datatables' => true,
        ];

        return view('categories.listing', $data);
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function getData()
    {
        $category = Category::where('group', request()->get('group', 'dispense_unit'));

        return DataTables::eloquent($category)->addColumn('action', function ($stock) {
            return '<a href="#" class="btn btn-small btn-primary"> <i class="fa fa-pencil"></i> Edit </a>';
        })->addColumn('group', function ($category) {
            return trans('main.'.$category->group);
        })->make();
    }

    /**
     * Store a newly created category in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['category' => 'required|max:255', 'category' => 'required|max:355']);
        Category::create($request->all());

        return back();
    }

    /**
     * Display the specified category.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
