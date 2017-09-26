<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Category;

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
            'categories' => $this->getData($page),
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
    protected function getData($group)
    {
        return Category::where('group', $group)->paginate();
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
        $this->validate($request, ['category' => 'required|max:255', 'category' => 'required|max:35', 'description' => 'required|string']);
        Category::create($request->all());

        return back();
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
        return view('categories.edit-category', compact('category'));
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
        $this->validate($request, ['category' => 'required|max:255', 'category' => 'required|max:35', 'description' => 'required|string']);
        $category->update($request->all());

        return with_info();
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
