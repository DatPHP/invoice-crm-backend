<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource as CompanyResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\CompanyRequest as CompanyRequest;

class CompanyController extends Controller
{
    public function index()
    {
        return CompanyResource::collection(Company::all());
    }
 
    public function store(CompanyRequest $request)
    {
        $company = Company::create($request->validated());
 
        return new CompanyResource($company);
    }
 
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }
 
    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->validated());
 
        return new CompanyResource($company);
    }
 
    public function destroy(Company $company)
    {
        $company->delete();
 
        return response()->noContent();
    }
}
