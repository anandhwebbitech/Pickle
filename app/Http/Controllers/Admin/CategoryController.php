<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    // ================= FETCH ALL =================
    public function index()
    {
        $categories = Category::latest();

        return DataTables::of($categories)
            ->addColumn('status', function ($row) {
                return $row->status == 1
                    ? '<span class="badge-active">Active</span>'
                    : '<span class="badge-inactive">Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.categoryupdate', $row->id);
                return '
                    <button class="btn btn-sm btn-primary editBtn"
                        data-id="'.$row->id.'"
                        data-name="'.$row->name.'"
                        data-status="'.$row->status.'"
                        data-url="'.$editUrl.'">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button class="btn btn-sm btn-danger deleteBtn"
                        data-id="'.$row->id.'">
                        <i class="fa fa-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    // ================= STORE =================
    public function Store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        Category::create([
            'name'   => $request->name,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category added successfully'
        ], 201);
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category);
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|boolean'
    ]);

    $category = Category::findOrFail($id);

    $category->update([
        'name' => $request->name,
        'status' => $request->status
    ]);

    return response()->json([
        'message' => 'Category updated successfully'
    ]);
}

    // ================= DELETE =================
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}
