<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\COA\COARepositoriesInterface;
use Illuminate\Support\Validator;
use App\Models\ChartOfAccount;

class CoaController extends Controller
{
    protected COARepositoriesInterface $coa;

    public function __construct(COARepositoriesInterface $coa)
    {
        $this->coa = $coa;
    }

    public function index(Request $request)
    {
        if (!auth()->user()->can('manage data akun')) {
            abort(403, 'Anda tidak memiliki izin akses.');
        }

        $params = $request->only(['search', 'account_type', 'account_class', 'sort_by', 'sort_dir']);
        $data = $this->coa->paginatedBySort($params, 15);

        /* dd($data); */
        return view('akuntansi.index', compact('data'));

    }
    
    public function create()
    {
        $data = ChartOfAccount::orderBy('account_code')->get();
        return view('akuntansi.create', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_code'    => 'required|string|max:20|unique:chart_of_account,account_code',
            'account_name'    => 'required|string|max:100',
            'account_type'    => 'required|in:asset,kewajiban,modal,pendapatan,biaya',
            'account_balance' => 'nullable|numeric',
            'parent_id'       => 'nullable|exists:chart_of_account,id',
        ]);

        // Set saldo default jika tidak diisi
        $validated['account_balance'] = $validated['account_balance'] ?? 0;

        // Hitung level akun berdasarkan parent
        $validated['level'] = 1; // default level 1
        if (!empty($validated['parent_id'])) {
            $parent = ChartOfAccount::find($validated['parent_id']);
            $validated['level'] = $parent->level + 1;
        }

        // Simpan ke database
        ChartOfAccount::create([
            'account_code'    => $validated['account_code'],
            'account_name'    => $validated['account_name'],
            'account_type'    => $validated['account_type'],
            'account_balance' => $validated['account_balance'],
            'parent_id'       => $validated['parent_id'],
            'level'           => $validated['level'],
        ]);

        return redirect()->back()->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $coa = $this->coa->find($id);
        return view('akuntansi.edit', compact('coa'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $this->coa->update($id, $data);
        return redirect()->route('akun.index')->with('success', 'Data akun berhasil update.');
    }

    public function destroy($id)
    {
        $this->coa->softDelete($id);
        return redirect()->route('akun.index')->with('success', 'Data akun berhasil dihapus.');
    }

}
