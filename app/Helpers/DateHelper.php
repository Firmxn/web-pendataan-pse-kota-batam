<?php

if (!function_exists('format_date')) {
    /**
     * Format date to Indonesian standard (Date + Time)
     * e.g. 10 Desember 2025, 14:30
     *
     * @param \Carbon\Carbon|string|null $date
     * @return string
     */
    function format_date($date): string
    {
        if (!$date) {
            return '-';
        }

        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }

        return $date->translatedFormat('d F Y, H:i');
    }
}

if (!function_exists('format_date_short')) {
    /**
     * Format date to short format
     * e.g. 10/12/2025
     *
     * @param \Carbon\Carbon|string|null $date
     * @return string
     */
    function format_date_short($date): string
    {
        if (!$date) {
            return '-';
        }

        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }

        return $date->format('d/m/Y');
    }
}

if (!function_exists('format_date_indo')) {
    /**
     * Format date to Indonesian standard date ONLY (No Time)
     * e.g. 10 Desember 2025
     *
     * @param \Carbon\Carbon|string|null $date
     * @return string
     */
    function format_date_indo($date): string
    {
        if (!$date) {
            return '-';
        }

        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }

        return $date->translatedFormat('d F Y');
    }
}

if (!function_exists('format_time')) {
    /**
     * Format time only
     * e.g. 14:30
     *
     * @param \Carbon\Carbon|string|null $date
     * @return string
     */
    function format_time($date): string
    {
        if (!$date) {
            return '-';
        }

        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }

        return $date->format('H:i');
    }
}

if (!function_exists('format_filename_timestamp')) {
    /**
     * Format timestamp untuk filename
     * e.g. 10022026_142300
     *
     * @param \Carbon\Carbon|string|null $date
     * @return string
     */
    function format_filename_timestamp($date = null): string
    {
        if (!$date) {
            $date = \Carbon\Carbon::now('Asia/Jakarta');
        }

        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }

        return $date->format('dmY_His');
    }
}