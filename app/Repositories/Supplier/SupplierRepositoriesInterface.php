<?php
namespace App\Repositories\Supplier;

use Illuminate\Support\Collection;
use App\Models\Supplier;

interface SupplierRepositoriesInterface
{
    public function all(): Collection;

    public function Paginated(int $perPage = 15);

    public function paginatedBySort(array $params = [], int $perPage = 15);

    public function find(int $id): ?Supplier;

    public function create(array $data): Supplier;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}