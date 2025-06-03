<?php

namespace App\Repositories\Supplier;

use App\Models\Supplier;
use App\Repositories\Supplier\SupplierRepositoriesInterface;
use Illuminate\Support\Collection;

class SupplierRepositories implements SupplierRepositoriesInterface
{
    public function all(): Collection
    {
        return Supplier::all();
    }

    public function Paginated(int $perPage = 15)
    {
        return Supplier::paginate($perPage);
    }

    public function paginatedBySort(array $params = [], int $perPage = 15)
    {
        $query = Supplier::query();

        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('company_name', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('address', 'like', "%$search%");
            });
        }

        $sortBy = $params['sort_by'] ?? 'name';
        $sortDir = $params['sort_dir'] ?? 'asc';
        $query->orderBy($sortBy, $sortDir);

        return $query->paginate($perPage)->appends($params);
    }

    public function find(int $id): ?Supplier
    {
        return Supplier::findOrFail($id);
    }

    public function create(array $data): Supplier
    {
        return Supplier::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $supplier = Supplier::findOrFail($id);
        return $supplier->update($data);
    }

    public function delete(int $id): bool
    {
        $supplier = Supplier::findOrFail($id);
        return $supplier->delete();
    }
}