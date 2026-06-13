<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $authUser): bool
    {
        return in_array($authUser->role->role_name, ['verifikator_1', 'verifikator_2', 'admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authUser, User $targetUser): bool
    {
        // Pengecekan dasar: Admin bisa melihat siapa saja
        if ($authUser->role->role_name === 'admin') {
            return true;
        }

        // Verifikator 1 dilarang melihat Admin, Eksekutif, dan Verifikator 2 (Otoritas lebih tinggi)
        if ($authUser->role->role_name === 'verifikator_1') {
            return !in_array($targetUser->role->role_name, ['admin', 'eksekutif', 'verifikator_2']);
        }

        // Verifikator 2 dilarang melihat Admin dan Eksekutif
        if ($authUser->role->role_name === 'verifikator_2') {
            return !in_array($targetUser->role->role_name, ['admin', 'eksekutif']);
        }

        // Akun lain (petugas/eksekutif) hanya bisa melihat profil sendiri
        return $authUser->id === $targetUser->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $authUser): bool
    {
        // Hanya Admin yang berwenang meregistrasi akun baru (Point 2 & 61)
        return $authUser->role->role_name === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, User $targetUser): bool
    {
        // Hanya Admin yang berwenang memperbarui profil, dan target harus ber-role petugas
        return $authUser->role->role_name === 'admin' && $targetUser->role->role_name === 'petugas';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser, User $targetUser): bool
    {
        // Hanya Admin yang berwenang menghapus akun, dan target harus ber-role petugas
        return $authUser->role->role_name === 'admin' && $targetUser->role->role_name === 'petugas';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $authUser, User $targetUser): bool
    {
        // Hanya Admin yang berwenang memulihkan akun, dan target harus ber-role petugas
        return $authUser->role->role_name === 'admin' && $targetUser->role->role_name === 'petugas';
    }
}
