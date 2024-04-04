<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Admin::query();
        // tìm kiếm
        if($request->has('search')) {
            $search = $request->input('search') ?? '';
            $query->where('name','like', '%' . $search . '%');
        }
        // lọc theo status
        if ($request->has('status')) {
         $status = $request->input('status') ?? 1;
         $query->where('status',$status);
        }
        $query->with('roles');
        $listStaff = $query->orderBy('id','DESC')->paginate(PaginationEnum::PER_PAGE);
        return view('admin.staff.list',compact('listStaff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.staff.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaffRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
