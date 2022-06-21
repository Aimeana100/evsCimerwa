<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Admin\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\CompanyCollection;

class CompanyController extends Controller
{
    public function companies()
    {
        $companies = new CompanyCollection(Company::all());
        return Inertia::render('Companies/Index', ['companies' => $companies]);
    }
    public function store(Request $request)
    {
        $request->validate(['Cname' => 'required|unique:companies,company_name,except,id']);

        $company = new Company();
        $company->company_name = $request->Cname;
        $company->state = true;

        try {
            $company->save();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->errorInfo]);
        }

        return redirect()->back()->with('success', 'Company added successfully');
    }

    public function companyBurn(Company $company)
    {
        $message = $company->state ? "Burned to Pass the gate in" : "Granted to Pass the gate in";
        $company->update(['state' => !$company->state]);
        Session::flash('alert-class', 'alert-danger'); 
        return back()->with('success', 'All '. $company->company_name . '\'s Employee ' . $message);
    }
}
 