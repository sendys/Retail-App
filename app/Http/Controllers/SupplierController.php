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

        // Cek jika ada file foto yang diunggah
        $this->supplierRepo->create($validated);
        return redirect()->route('supplier.index')->with('success', 'Supplier created successfully.');
    }

    public function edit($id)
    {
        $supplier = $this->supplierRepo->find($id);
        return view('supplier.edit', compact('supplier'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:supplier,email,$id",
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $supplier = $this->supplierRepo->find($id); // pastikan repo punya method `find($id)`

        // Cek jika ada file foto yang diunggah
        if ($request->hasFile('foto')) {
            // Hapus file lama jika ada
            if (!empty($supplier->foto) && \Illuminate\Support\Facades\Storage::disk('public')->exists($supplier->foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($supplier->foto);
            }

            // Simpan file baru
            $validated['foto'] = $request->file('foto')->store('photos', 'public');
        }

        $this->supplierRepo->update($id, $validated);

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
    }


    public function destroy($id)
    {
        $this->supplierRepo->delete($id);
        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully.');
    }
}
