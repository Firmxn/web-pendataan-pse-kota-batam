<?php

namespace App\Policies;

use App\Models\HostingRequest;
use App\Models\User;

class HostingRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, HostingRequest $hosting): bool
    {
        // User hanya dapat melihat hosting request miliki sendiri, verifikator, admin, atau eksekutif (monitoring)
        return $user->id === $hosting->user_id
            || in_array($user->role->role_name, ['verifikator_1', 'verifikator_2', 'admin', 'eksekutif']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->role_name === 'petugas';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, HostingRequest $hosting): bool
    {
        return $user->id === $hosting->user_id
            && in_array($hosting->status, ['draft', 'rejected']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, HostingRequest $hosting): bool
    {
        return $user->id === $hosting->user_id
            && $hosting->status === 'draft';
    }

    public function submit(User $user, HostingRequest $hosting): bool
    {
        return $user->id === $hosting->user_id
            && in_array($hosting->status, ['draft', 'rejected']);
    }

    public function verify(User $user, HostingRequest $hosting): bool
    {
        return $user->role->role_name === 'verifikator_1'
            && $hosting->status === 'pending_1';
    }

    public function verifyFinal(User $user, HostingRequest $hosting): bool
    {
        return $user->role->role_name === 'verifikator_2'
            && $hosting->status === 'pending_2';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, HostingRequest $hosting): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, HostingRequest $hosting): bool
    {
        return false;
    }
}
