<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
class CompanyController extends Controller
{
    
    public function index():Response
    {
        $companies = Company::orderBy('created_at', 'desc')->paginate(4);
        return Inertia::render('Company/Company', ['companies'=>($companies)->toArray() ]);
    }

    public function create()
    {
       
    }

    
    public function store(CompanyRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('public/logos');
            $validatedData['logo'] = Storage::url($logoPath);
        }

        $company = Company::create($validatedData);
        return response()->json(['message' => 'Company created successfully','data'=>(new CompanyResource($company))]);
    }

    
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    
    public function update(CompanyRequest $request, Company $company)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('public/logos');
            $validatedData['logo'] = Storage::url($logoPath);
        }
        $company->update($validatedData);
        return response()->json(['message' => 'Company updated successfully','data'=>(new CompanyResource($company))]);
        
    }

    public function destroy(Company $company)
    {
        $company->employees()->delete();
        $company->delete();
        return response()->json(['message' => 'Company deleted successfully']);
    }
}
