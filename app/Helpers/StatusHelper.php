<?php

if (!function_exists('status_border_color')) {
    /**
     * Get border color class based on status
     *
     * @param string $status
     * @return string
     */
    function status_border_color(string $status): string
    {
        return match ($status) {
            'draft' => 'border-secondary',
            'pending_1', 'pending_2' => 'border-warning',
            'rejected' => 'border-error',
            'approved' => 'border-success',
            default => 'border-gray-200',
        };
    }
}

if (!function_exists('status_bg_color')) {
    /**
     * Get background color class based on status
     *
     * @param string $status
     * @return string
     */
    function status_bg_color(string $status): string
    {
        return match ($status) {
            'draft' => 'bg-secondary',
            'pending_1', 'pending_2' => 'bg-warning',
            'rejected' => 'bg-error',
            'approved' => 'bg-success',
            default => 'bg-gray-200',
        };
    }
}

if (!function_exists('status_text_color')) {
    /**
     * Get text color class based on status
     *
     * @param string $status
     * @return string
     */
    function status_text_color(string $status): string
    {
        return match ($status) {
            'draft' => 'text-secondary',
            'pending_1', 'pending_2' => 'text-warning',
            'rejected' => 'text-error',
            'approved' => 'text-success',
            default => 'text-base-content',
        };
    }
}

if (!function_exists('status_badge_variant')) {
    /**
     * Get badge variant based on status
     *
     * @param string $status
     * @return string
     */
    function status_badge_variant(string $status): string
    {
        return match ($status) {
            'draft' => 'secondary',
            'pending_1', 'pending_2' => 'warning',
            'rejected' => 'error',
            'approved' => 'success',
            default => 'neutral',
        };
    }
}
