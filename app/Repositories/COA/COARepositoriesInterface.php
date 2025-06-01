<?php
namespace App\Repositories\COA;

use Illuminate\Support\Collection;
use App\Models\ChartOfAccount as COA;

interface COARepositoriesInterface
{
    public function all(): Collection;

    public function Paginated(int $perPage = 15);

    public function paginatedBySort(array $params = [], int $perPage = 15);

    public function find(int $id): ?COA;

    public function create(array $data): COA;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
