<?php

namespace App\Http\Controllers;

use App\Repositories\Supplier\SupplierRepositoriesInterface;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Crypt;

class SupplierController extends Controller
{
    protected $supplierRepo;

    public function __construct(SupplierRepositoriesInterface $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $suppliers = $this->supplierRepo->paginatedBySort($params, $params['per_page'] ?? 10);
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:supplier,email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
        ]);
        $this->supplierRepo->create($validated);
        return redirect()->route('supplier.index')->with('success', 'Supplier created successfully.');
    }

    public function edit($id)
    {
        $ids = Crypt::decryptString($id);
        $supplier = $this->supplierRepo->find($ids);
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $this->supplierRepo->update($id, $data);
        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
    
    }

    public function destroy($id)
    {
        $this->supplierRepo->delete($id);
        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully.');
    }
}