<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{

    public function index()
    {
        $departments = Department::all();
        return response()->json($departments);
    }

    public function store(Request $request)
    {
        $rules = ['name' => 'required|string|min:1|max:100',];
        $validator = Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator -> errors()->all()
            ],400);
        }
        $department= new Department($request->input());
        $department->save();
        return response()->json([
            'status' => true,
            'message' => 'Department created successfully'
        ],200);
    }   

    public function show(Department $department)
    {
        return response()->json(['status'=>true, 'data'=>$department]);
    }

    public function update(Request $request, Department $department)
    {
        DB::connection()->enableQueryLog();
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'hide' => 'required'
        ];
        $validator = Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator -> errors()->all()
            ],400);
        }
        $department->update($request->input());
        return response()->json([
            'status' => true,
            'message' => 'Department update successfully'
        ],200);
    }

    public function destroy(Request $request, Department $department)
    {
        $rules = ['hide' => 'required'];
        $validator = Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator -> errors()->all()
            ],400);
        }
    
        $hide=$request->input('hide');
        dd($hide);
        $data=array('hide'=>$hide);
        $department->update($data);
        dd($department);
        return response()->json([
            'status' => true,
            'message' => 'Department deleted successfully'
        ],200);
    }

}