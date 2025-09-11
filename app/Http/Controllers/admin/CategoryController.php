<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q', '');

        $categories = Category::query()
            ->search($q)     // من الموديل
            ->ordered()      // من الموديل
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'rows'       => view('admin.categories._rows', compact('categories'))->render(),
                'pagination' => $categories->withPath(route('categories.index'))->links()->toHtml(),
            ]);
        }

        return view('admin.categories.index', compact('categories', 'q'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = new Category();
        return view('admin.categories.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()
            ->route('categories.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'تمت إضافة القسم بنجاح'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('categories.index')->with('toast', [
            'type' => 'success',
            'message' => 'تم تعديل القسم بنجاح'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'تم حذف القسم بنجاح'
            ]);
    }


    public function toggleStatus(Category $category)
    {
        // قلب القيمة
        $category->is_active = !$category->is_active;
        $category->save();

        return response()->json([
            'status'  => $category->is_active ? 'active' : 'inactive',
            'label'   => $category->is_active ? 'نشط' : 'غير نشط',
            'message' => 'تم تغيير الحالة إلى ' . ($category->is_active ? 'نشط' : 'غير نشط'),
            'type'    => 'success',
        ]);
    }
}
