<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\COA\COARepositoriesInterface;
use Illuminate\Support\Validator;
use App\Models\ChartOfAccount;
use App\Models\Supplier;

class CoaController extends Controller
{
    protected COARepositoriesInterface $coa;

    public function __construct(COARepositoriesInterface $coa)
    {
        $this->coa = $coa;
    }

    public function index(Request $request)
    {
        /* if (!auth()->user()->can('manage data akun')) {
            abort(403, 'Anda tidak memiliki izin akses.');
        } */

        $params = $request->only(['search', 'account_type', 'account_class', 'sort_by', 'sort_dir']);
        $data = $this->coa->paginatedBySort($params, 20);

        /* dd($data); */
        return view('akuntansi.index', compact('data'));
    }

    public function create()
    {
        $data = ChartOfAccount::orderBy('account_code')->get();
        $suppliers = Supplier::all();
        return view('akuntansi.create', compact('data','suppliers'));
    }

    public function store(Request $request)
    {
        // Validasi input dengan custom error message
        $validated = $request->validate([
            'account_code'    => 'required|string|max:20|unique:chart_of_account,account_code',
            'account_name'    => 'required|string|max:100|unique:chart_of_account,account_name',
            'account_type'    => 'required|in:asset,kewajiban,modal,pendapatan,biaya',
            'account_balance' => 'nullable|numeric',
            'parent_id'       => 'nullable|exists:chart_of_account,id',
            'is_postable'    => 'required|in:yes,no',
        ], [
            'account_code.required' => 'Kode akun wajib diisi.',
            'account_code.unique'   => 'Kode akun sudah ada.',
            'account_name.required' => 'Nama akun wajib diisi.',
            'account_name.unique'   => 'Nama akun sudah digunakan.',
            'account_type.required' => 'Tipe akun wajib diisi.',
            'account_type.in'       => 'Tipe akun tidak valid.',
            'account_balance.numeric' => 'Saldo harus berupa angka.',
            'parent_id.exists'      => 'Parent akun tidak ditemukan.',
            'is_postable.required' => 'Posted akun wajib diisi.',
        ]);

        // Set saldo default jika tidak diisi
        $validated['account_balance'] = $validated['account_balance'] ?? 0;

        // Hitung level akun berdasarkan parent (jika ada)
        $validated['level'] = 1; // default level 1
        if (!empty($validated['parent_id'])) {
            $parent = ChartOfAccount::find($validated['parent_id']);
            if ($parent) {
                $validated['level'] = $parent->level + 1;
            }
        }

        // Simpan data ke database
        ChartOfAccount::create([
            'account_code'    => $validated['account_code'],
            'account_name'    => $validated['account_name'],
            'account_type'    => $validated['account_type'],
            'account_balance' => $validated['account_balance'],
            'parent_id'       => $validated['parent_id'],
            'level'           => $validated['level'],
            'is_postable'     => $validated['is_postable'],
        ]);

        return redirect()->back()->with('success', 'Akun berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $account = $this->coa->find($id);
        $accounts = ChartOfAccount::orderBy('account_code')->get();
        return view('akuntansi.edit', compact('account', 'accounts'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $this->coa->update($id, $data);
        return redirect()->route('akun.index')->with('success', 'Data akun berhasil update.');
    }

    public function destroy($id)
    {
        $this->coa->delete($id);
        return redirect()->route('akun.index')->with('success', 'Data akun berhasil dihapus.');
    }
}
