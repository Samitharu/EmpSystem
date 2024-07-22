<?php

namespace App\Http\Controllers;

use App\Mail\UserCreated;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    //load depatments
    public function loadDepartment()
    {
        $departments = Department::all();
        return $departments;
    }

    //Save employee
    public function saveEmployee(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {
            $request->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'contactNo' => 'required|string|max:15|unique:employees,contactNo',
                'email' => 'required|email|unique:users,email',
                'address' => 'required',
                'role'=>'required'

            ]);
            $employee = Employee::create($request->all());

            //Calling user saving function 
            if ($employee) {
                $empId = $employee->employeeId;
                $this->saveUser($empId, $request->input('email'),$request->input('nic'),$request->input('role'));
            }

            DB::commit();
            return response()->json(['status' => true]);
        } catch (Exception $ex) {
            DB::rollBack();
            return $ex;
        }
    }

    //Save user
    private static function saveUser($empId, $email, $nic, $role)
    {
        //$password = Str::random(12);
        $user = User::create([
            'email' => $email,
            'employeeId' => $empId,
            'password' => Hash::make($nic)
        ]);

        $user->assignRole($role);

       // Mail::to($email)->send(new UserCreated($email, $password));
    }
    //Load employees to the table
    public function loadEmployees()
    {
        try {
            $employees = DB::table('employees')
                ->join('departments', 'employees.departmentId', '=', 'departments.departmentId')
                ->select(
                    'employees.employeeId',
                    'employees.contactNo',
                    DB::raw('CONCAT(employees.firstName, " ", employees.lastName) AS name'),
                    'departments.departmentName'
                )
                ->whereNull('employees.deleted_at') 
                ->get();


            if ($employees) {
                return response()->json(['status' => true, 'data' => $employees]);
            } else {
                return response()->json(['status' => false, 'data' => []]);
            }

          
        } catch (Exception $ex) {

            return $ex;
        }
    }

    //Return employee data to view or edit.
    public function getEmployee(Request $request)
    {
        try {

            $employeeData = DB::table('employees AS E')
                ->select('E.firstName', 'E.lastName', 'E.gender', 'E.address', 'E.nic', 'E.joiningDate', 'E.departmentId', 'E.contactNo', 'users.email')
                ->leftJoin('users', 'E.employeeId', '=', 'users.employeeId')
                ->where("E.employeeId", "=", $request->get('empId'))
                ->first();
            if ($employeeData) {
                return response()->json(["status" => true, "data" => $employeeData]);
            } else {
                return response()->json(["status" => false, "data" => []]);
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    //Update employee
    public function updateEmployee(Request $request, $empId)
    {

        DB::beginTransaction();
        try {
            //dd($request->all());
            //Decode the $empId
            $decodedEmpId = base64_decode($empId);

            //Custom validation to email
            $emailUniqueRule = Rule::unique('users', 'email')->where(function ($query) use ($decodedEmpId) {
                return $query->where('employeeId', '!=', $decodedEmpId);
            });

            $validatedData =  $request->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'contactNo' => [
                    'required',
                    'string',
                    'max:15',
                    Rule::unique('employees')->ignore($decodedEmpId, 'employeeId')
                ],
                'email' => ['required', 'email', $emailUniqueRule],
                'address' => 'required|string|max:255'
            ]);



            // Updating employee the record
            DB::table('employees')
                ->where('employeeId', $decodedEmpId)
                ->update($request->except('email'));

            //Updating email in users table
            DB::table('users')
                ->where('employeeId', $decodedEmpId)
                ->update([
                    'email' => $request->get('email')
                ]);

            DB::commit();
            return response()->json(["status" => true]);
        } catch (Exception $ex) {
            DB::rollBack();
            return $ex;
        }
    }

    //Delete EmployeeRecord
    public function deleteEmployee($empId)
    {
        DB::beginTransaction();
        try {
            //Decode $empId
            $decodedEmpId = base64_decode($empId);

            $employee = Employee::find($decodedEmpId);

            if ($employee) {
                $employee->delete();

                //Block user which related to employee
                $user = User::where("employeeId", "=", $decodedEmpId)->first();
                if ($user) {
                    $user->isBlocked = 1;
                    $user->update();
                }
                DB::commit();
                return response()->json(['status' => true]);
            } else {
                DB::rollBack();
                return response()->json(['status' => false]);
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
