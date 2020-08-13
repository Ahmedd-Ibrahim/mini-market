<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->latest()->paginate(5);
        return view('dashboard.categories.index',compact('categories'));
    } // End of Index

    public function create()
    {
        return view('dashboard.categories.create');
    } // End of create

    public function store(CategoryRequest $request)
    {
        Category::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

    public function edit(Category $category)
    {

        return view('dashboard.categories.edit',compact('category'));
    } /*End of Edit */

    public function update(CategoryRequest $request, Category $category)
    {
        if(!$category){
            session()->flash('success', __('site.no_records'));
            return redirect()->route('dashboard.categories.index');
        }
        $category->update($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');
    } /*End of Update */

    public function destroy(Category $category)
    {

        if(!$category){
            session()->flash('success', __('site.no_records'));
            return redirect()->route('dashboard.clients.index');
        }
        $category->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
    }
} // End of Controller
