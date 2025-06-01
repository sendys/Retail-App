<?php

namespace App\Repositories\COA;

use App\Models\ChartOfAccount as COA;
use App\Repositories\COA\COARepositoriesInterface;
use Illuminate\Support\Collection;

class COARepositories implements COARepositoriesInterface
{
    public function all(): Collection
    {
        return COA::all();
    }

    public function Paginated(int $perPage = 15)
    {
        return COA::paginate($perPage);
    }

    public function paginatedBySort(array $params = [], int $perPage = 15)
    {
        $query = COA::query();

        // Search global
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function ($q) use ($search) {
                $q->where('account_code', 'like', "%$search%")
                ->orWhere('account_name', 'like', "%$search%");
            });
        }

        // Filter
        if (!empty($params['account_type'])) {
            $query->where('account_type', $params['account_type']);
        }

        if (!empty($params['account_class'])) {
            $query->where('account_class', $params['account_class']);
        }

        // Sorting
        $sortBy = $params['sort_by'] ?? 'account_code';
        $sortDir = $params['sort_dir'] ?? 'asc';
        $query->orderBy($sortBy, $sortDir);

        // Pagination
        return $query->paginate($perPage)->appends($params);
    }

    public function find(int $id): ?COA
    {
        return COA::findOrFail($id);
    }

    public function create(array $data): COA
    {
        return COA::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $coa = COA::findOrFail($id);
        return $coa ? $coa->update($data): false;
    }

    public function delete(int $id): bool
    {
        $coa = COA::findOrFail($id);
        return $coa ? $coa->delete(): false;
    }
}