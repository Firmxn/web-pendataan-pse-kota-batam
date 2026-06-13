@props(['disabled' => false, 'errorBag' => null, 'errorContext' => null])

@php
    // Auto-detect error berdasarkan name attribute
    $fieldName = $attributes->get('name');
    $hasError = false;

    if ($fieldName) {
        // Jika errorBag spesifik diberikan, cek hanya di bag tersebut
        if ($errorBag) {
            $bagHasError = $errors->{$errorBag}->has($fieldName);

            // Jika ada errorContext (untuk multiple instances), cek apakah error untuk instance ini
            if ($errorContext && $bagHasError) {
                // errorContext format: ['session_key' => 'editing_pse_uuid', 'instance_id' => $issuance->uuid]
                $sessionKey = $errorContext['session_key'] ?? null;
                $instanceId = $errorContext['instance_id'] ?? null;

                if ($sessionKey && $instanceId) {
                    // Hanya tampilkan error jika session key cocok dengan instance ID
                    $hasError = session($sessionKey) === $instanceId;
                } else {
                    // Jika tidak ada context, tampilkan error (backward compatibility)
                    $hasError = $bagHasError;
                }
            } else {
                $hasError = $bagHasError;
            }
        } else {
            // Fallback: cek di semua error bags (backward compatibility)
            $hasError =
                $errors->has($fieldName) ||
                $errors->updatePassword->has($fieldName) ||
                $errors->userDeletion->has($fieldName);
        }
    }
@endphp

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'type' => 'text',
    'class' =>
        'input w-full bg-base-100 rounded-xl transition-all duration-200 ' .
        ($disabled
            ? ' border border-base-200 opacity-60'
            : ($hasError
                ? ' border border-error focus:outline-none focus:ring-1 focus:ring-error/20'
                : ' border border-base-200 hover:border-base-300 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/20')),
]) !!}>
