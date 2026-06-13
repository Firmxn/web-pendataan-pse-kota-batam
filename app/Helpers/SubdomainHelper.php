<?php

namespace App\Helpers;

class SubdomainHelper
{
    /**
     * Normalize subdomain name by REMOVING suffix if present.
     * Use this before saving to database to ensure only prefix is stored.
     *
     * Input: "sistem1.batam.go.id" -> Output: "sistem1"
     * Input: "sistem1" -> Output: "sistem1"
     *
     * @param string|null $value
     * @return string|null
     */
    public static function normalize(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        $value = strtolower(trim($value));
        $suffix = config('app.domain_suffix', 'batam.go.id');

        // Strip suffix if exists
        if (str_ends_with($value, '.' . $suffix)) {
            $value = substr($value, 0, -strlen('.' . $suffix));
        }

        return $value;
    }

    /**
     * Generate full URL by APPENDING suffix to the subdomain prefix.
     * Use this in Accessors or when displaying the URL.
     *
     * Input: "sistem1" -> Output: "https://sistem1.batam.go.id"
     *
     * @param string|null $subdomainPrefix
     * @return string|null
     */
    public static function generateUrl(?string $subdomainPrefix): ?string
    {
        if (empty($subdomainPrefix)) {
            return null;
        }

        $suffix = config('app.domain_suffix', 'batam.go.id');
        return 'https://' . $subdomainPrefix . '.' . $suffix;
    }
}
