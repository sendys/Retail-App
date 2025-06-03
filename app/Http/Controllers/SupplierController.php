<?php

namespace App\Http\Controllers;

use App\Repositories\Supplier\SupplierRepositoriesInterface;
use Illuminate\Http\Request;
use App\Models\Supplier;

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
        $suppliers = $this->supplierRepo->paginatedBySort($params, 10);
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

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:supplier,email,' . $supplier->id,
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
        ]);
        $this->supplierRepo->update($supplier->id, $validated);
        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $this->supplierRepo->delete($supplier->id);
        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully.');
    }
}