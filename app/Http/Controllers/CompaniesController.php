<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Companies;
use App\Traits\UploadTrait;
use App\Http\Resources\APIResource;

class CompaniesController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Companies::paginate(10);

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
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
            'name'=>'required',
            'email'=>'required',
            'logo'=>'dimensions:min_width=100,min_height=100'
        ],
        [
            'logo.dimensions'=>'Logo must have dimensions of at least 100x100',
        ]);

        $company = new Companies([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'website' => $request->get('website'),
        ]);

        if ($request->has('logo')) {
            $file_path = $request->logo->store('public');
            $company->logo = substr($file_path, 7);
        }
        else {
            $company->logo = '';
        }

        $company->save();
        return redirect('/companies')->with('success', 'Company saved!');
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
        $company = Companies::find($id);
        return view('companies.edit', compact('company'));  
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
            'name'=>'required',
            'email'=>'required',
            'logo'=>'dimensions:min_width=100,min_height=100'
        ],
        [
            'logo.dimensions'=>'Logo must have dimensions of at least 100x100',
        ]);


        $company = Companies::find($id);
        $company->name =  $request->get('name');
        $company->email =  $request->get('email');
        $company->website =  $request->get('website');
        if ($request->has('logo')) {
            $file_path = $request->logo->store('public');
            $company->logo = substr($file_path, 7);
        }

        $company->save();

        return redirect('/companies')->with('success', 'Company updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Companies::find($id);
        $company->delete();

        return redirect('/companies')->with('success', 'Company deleted!');
    }

    public function get_companies()
    {
        $companies = Companies::get();
        return APIResource::collection($companies);
    }
}
