<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\CreateEmployeeTable;

class ApiController extends Controller
{
    // Create API
    public function createEmployee(Request $request)
    {
        # Validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:create_employee_tables',
            'phone_no' => 'required',
            'gender' => 'required',
            'age' => 'required'
        ]);

        // Creating Data
        $employee = new CreateEmployeeTable();
        
        // Save Data
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone_no = $request->phone_no;
        $employee->gender = $request->gender;
        $employee->age = $request->age;
        $employee->save();

        // Send Response
        return response()->json([
            'status' => 201,
            "Message" => "Employee is Created Successfully"
        ], 201);
    }

    // List API
    public function listEmployee(Type $var = null)
    {
        # code...
        $employees = CreateEmployeeTable::all();

        return response()->json($employees, 200);
    }

    // Single Detail API
    public function getSingleEmployee($id)
    {
        # code...
        if (CreateEmployeeTable::where('id', $id)->exists()) {
            # code...
            return response()->json(
                CreateEmployeeTable::findOrFail($id),
                200
            );
        } else {
            # code...
            return response()->json(["Message"=>"Not Found"], 404);
        }
    }

    // Update API
    public function updateEmployee(Request $request, $id)
    {
        # code...
        if (CreateEmployeeTable::where('id', $id)->exists()) {
            # Validation
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone_no' => 'required',
                'gender' => 'required',
                'age' => 'required'
            ]);
            CreateEmployeeTable::findOrFail($id)->update($request->all());
            return response()->json($request, 200);
        } else {
            # code...
            return response()->json([
                "Message" => "invalid request"
            ], 400);
        }
    }

    // Delete API
    public function deleteEmployee($id)
    {
        # code...
        if (CreateEmployeeTable::where('id', $id)->exists()) {
            # code...
            CreateEmployeeTable::findOrFail($id)->delete();
            return response()->json([
                "Message" => "Employee Deleted"
            ], 200);
        } else {
            # code...
            return response()->json(["Message"=>"Not Found"], 404);
        }
        
    }
}
