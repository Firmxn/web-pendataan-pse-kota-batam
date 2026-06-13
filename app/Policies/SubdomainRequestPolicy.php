<?php

namespace App\Policies;

use App\Models\SubdomainRequest;
use App\Models\User;

class SubdomainRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SubdomainRequest $subdomainRequest): bool
    {
        // User hanya dapat melihat subdomain request milik mereka sendiri, verifikator, admin, atau eksekutif
        return $user->id === $subdomainRequest->user_id ||
               in_array($user->role->role_name, ['verifikator_1', 'verifikator_2', 'admin', 'eksekutif']);
    }

    public function create(User $user): bool
    {
        // hanya role petugas yang bisa membuat pengajuan
        return $user->role->role_name === 'petugas';
    }

    public function update(User $user, SubdomainRequest $subdomainRequest): bool
    {
        // user hanya bisa mengubah subdomain request miliki mereka sendiri dan ketika statusnya draft atau rejected
        return $user->id === $subdomainRequest->user_id && in_array($subdomainRequest->status, ['draft', 'rejected']);
    }

    public function delete(User $user, SubdomainRequest $subdomainRequest): bool
    {
        // hanya owner yang bisa menghapus subdomain request milik mereka sendiri dan ketika statusya draft
        return $user->id === $subdomainRequest->user_id && $subdomainRequest->status === 'draft';
    }

    public function submit(User $user, SubdomainRequest $subdomainRequest): bool
    {
        // hanya owner yang bisa submit subdomain request milik mereka sendiri dan ketika statusya draft
        return $user->id === $subdomainRequest->user_id && in_array($subdomainRequest->status, ['draft', 'rejected']);
    }

    public function restore(User $user, SubdomainRequest $subdomainRequest): bool
    {
        return false;
    }

    public function forceDelete(User $user, SubdomainRequest $subdomainRequest): bool
    {
        return false;
    }

    public function verify(User $user, SubdomainRequest $subdomainRequest): bool
    {
        // Hanya verifikator_1 yang bisa verify level 1
        // Dan status harus pending_1
        return $user->role->role_name === 'verifikator_1'
            && $subdomainRequest->status === 'pending_1';
    }

    public function verifyFinal(User $user, SubdomainRequest $subdomainRequest): bool
    {
        // Hanya verifikator_2 yang bisa verify level 2
        // Dan status harus pending_2
        return $user->role->role_name === 'verifikator_2'
            && $subdomainRequest->status === 'pending_2';
    }
}
