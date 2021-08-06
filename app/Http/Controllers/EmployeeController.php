<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function show(Employee $employee) {
        return response()->json($employee,200);
    }

    public function search(Request $request) {
        $request->validate(['key'=>'string|required']);

        $applicants = Employee::where('name','like',"%$request->key%")
            ->orWhere('age','like',"%$request->key%")->get();

        return response()->json($employees, 200);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'string|required',
            'age' => 'string|required',
            'address' => 'string|required',
            'contact' => 'string|required',
        ]);

        try {
            $employee = Employee::create($request->all());
            return response()->json($employee, 202);
        }catch(Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ],500);
        }

    }

    public function update(Request $request, Employee $employee) {
        try {
            $employee->update($request->all());
            return response()->json($employee, 202);
        }catch(Exception $ex) {
            return response()->json(['message'=>$ex->getMessage()], 500);
        }
    }

    public function destroy(Employee $employee) {
        $employee->delete();
        return response()->json(['message'=>'employee deleted.'],202);
    }

    public function index() {
        $employees = Employee::orderBy('name')->get();
        return response()->json($employees, 200);
    }
}
