<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Admin\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeCollection;
use Illuminate\Support\Facades\Redirect;

class EmployeeController extends Controller
{
    public function employees(Request $request)
    {
        $filters = $request->all('search', 'selected');
        $employees = new EmployeeCollection(
            Employee::filter(
                $request->all('search', 'selected')
            )
                ->paginate()
                ->appends($request->all())
        );

        return Inertia::render('Employees/Index', ['employees' => $employees, 'filters' => $filters]);
    }

    public function employeeBurn(Employee $employee)
    {
        $message = $employee->state ? "Burned to Pass the gate in" : "Granted to Pass the gate in";
        $employee->update(['state' => !$employee->state]);

        return Redirect::back()->with('success', 'Employee State has ' . $message);
    }
}
