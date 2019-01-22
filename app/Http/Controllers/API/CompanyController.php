<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Company::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|max:191|unique:companies',
            'type' => 'required|string|max:191',
            'phone' => 'required|string|max:191',
            'address' => 'required|string'
        ]);

        return Company::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'phone' => $request['phone'],
            'address' => $request['address']
        ]);

        // return ['message'=>'store method'];
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|max:191|unique:companies,email,'.$company->id,
            'address' => 'required|string|max:191',
            'type' => 'required|string|max:191',
            'phone' => 'required|string|max:191'
        ]);
        $company->update($request->all());
        return ['message' => 'update method'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return ['message' => 'Company deleted'];

    }
}
