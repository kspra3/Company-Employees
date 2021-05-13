<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employees;
use App\Http\Resources\APIResource;
use Illuminate\Support\Facades\Auth;


class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            $employees = Employees::where('company', Auth::user()->employee()->first()->company)->paginate(10);
        }
        else {
            $employees = Employees::paginate(10);
        }

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|unique:employees',
            'company'=>'required|exists:companies,id',
            'phone'=>'required'
        ],
        [
            'company.exists'=>'This company does not exist'
        ]);

        $employee = new Employees([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'company' => $request->get('company'),
            'phone' => $request->get('phone'),
        ]);
        $employee->save();
        return redirect('/employees')->with('success', 'Employee saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employees::find($id);
        return view('employees.edit', compact('employee'));       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'company'=>'required|exists:companies,id',
            'phone'=>'required'
        ],
        [
            'company.exists'=>'This company does not exist'
        ]);

        $employee = Employees::find($id);
        $employee->first_name =  $request->get('first_name');
        $employee->last_name = $request->get('last_name');
        $employee->company = $request->get('company');
        $employee->save();

        return redirect('/employees')->with('success', 'Employee updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employees::find($id);
        $employee->delete();

        return redirect('/employees')->with('success', 'Employee deleted!');
    }

    public function get_employees()
    {
        $employees = Employees::get();
        return APIResource::collection($employees);
    }
}
