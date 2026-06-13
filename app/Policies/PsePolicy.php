<?php

namespace App\Policies;

use App\Models\Pse;
use App\Models\User;

class PsePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Pse $pse): bool
    {
        // User hanya bisa lihat PSE miliknya sendiri, verifikator, admin, atau eksekutif (monitoring)
        return $user->id === $pse->user_id ||
               in_array($user->role->role_name, ['verifikator_1', 'verifikator_2', 'admin', 'eksekutif']);
    }

    public function create(User $user): bool
    {
        // Hanya petugas yang bisa create PSE
        return $user->role->role_name === 'petugas';
    }

    public function update(User $user, Pse $pse): bool
    {
        // User hanya bisa update PSE miliknya sendiri dan status masih draft atau rejected
        return $user->id === $pse->user_id &&
               in_array($pse->status, ['draft', 'rejected']);
    }

    public function delete(User $user, Pse $pse): bool
    {
        // User hanya bisa delete PSE miliknya sendiri dan status masih draft
        return $user->id === $pse->user_id && $pse->status === 'draft';
    }

    public function restore(User $user, Pse $pse): bool
    {
        return false;
    }

    public function forceDelete(User $user, Pse $pse): bool
    {
        return false;
    }

    public function submit(User $user, Pse $pse): bool
    {
        return $user->id === $pse->user_id
            && in_array($pse->status, ['draft', 'rejected']);
    }

    public function verify(User $user, Pse $pse): bool
    {
        // Hanya verifikator_1 yang bisa verify level 1
        // Dan status harus pending_1
        return $user->role->role_name === 'verifikator_1'
            && $pse->status === 'pending_1';
    }

    public function verifyFinal(User $user, Pse $pse): bool
    {
        // Hanya verifikator_2 yang bisa verify level 2
        // Dan status harus pending_2
        return $user->role->role_name === 'verifikator_2'
            && $pse->status === 'pending_2';
    }

    public function updateRegistrationNumber(User $user, Pse $pse): bool
    {
        return $user->role->role_name === 'verifikator_2'
            && $pse->status === 'approved';
    }
}
