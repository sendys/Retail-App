<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface RoleRepositoryInterface
{
    /**
     * Mengambil semua data role dengan pagination.
     *
     * @param int $limit Jumlah item per halaman (perPage)
     * @param int $offset halaman saat ini (page).
     * @param array $columns Kolom yang akan dipilih.
     * @param array $relations relasi yang akan diambil di eager load
     * @return LengthAwarePaginator Paginator dengan data role.
     */
    
     public function getAllRolesWithPagination(int $limit =15, int $page =1, array $columns = ['*'], array $relations = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * Mengambil semua data role.
     *
     * @return Collection Kolleksi data role.
     */
    public function getAllRoles(): \Illuminate\Database\Eloquent\Collection;

    /**
     * Mengambil data role berdasarkan ID.
     *
     * @param int $id ID role.
     * @return Model|null Data role atau null jika tidak ditemukan.
     */
    public function getRoleById(int $id): ?Model;

    /**
     * Membuat data role baru.
     *
     * @param array $data Data role yang akan dibuat.
     * @return Model Data role yang telah dibuat.
     */
    public function createRole(array $data): Model;

    /**
     * Memperbarui data role berdasarkan ID.
     *
     * @param int $id ID role.
     * @param array $data Data role yang akan diperbarui.
     * @return Model|null Data role yang telah diperbarui atau null jika tidak ditemukan.
     */
    public function updateRole(int $id, array $data): ?Model;

    /**
     * Menghapus data role berdasarkan ID.
     *
     * @param int $id ID role.
     * @return bool true jika berhasil dihapus, false jika gagal.
     */
    public function deleteRole(int $id): bool;

    /**
     * Mengambil semua data role yang terhubung dengan pengguna.
     *
     * @return Collection Kolleksi data role yang terhubung dengan pengguna.
     */
    public function getRolesWithUsers(): \Illuminate\Database\Eloquent\Collection;
    /**
     * Mengambil data role berdasarkan ID dan relasi pengguna.
     *
     * @param int $id ID role.
     * @return Model|null Data role dengan relasi pengguna atau null jika tidak ditemukan.
     */
    public function getRoleWithUsersById(int $id):?Model;


    
}