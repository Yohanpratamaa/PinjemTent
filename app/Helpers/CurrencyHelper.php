<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Format currency to Indonesian Rupiah (IDR)
     *
     * @param float|int $amount
     * @param bool $includeSymbol
     * @return string
     */
    public static function formatIDR($amount, bool $includeSymbol = true): string
    {
        $formatted = number_format($amount, 0, ',', '.');

        return $includeSymbol ? 'Rp ' . $formatted : $formatted;
    }

    /**
     * Format currency for input field (without symbol)
     *
     * @param float|int $amount
     * @return string
     */
    public static function formatForInput($amount): string
    {
        return self::formatIDR($amount, false);
    }

    /**
     * Parse IDR formatted string to float
     *
     * @param string $formatted
     * @return float
     */
    public static function parseIDR(string $formatted): float
    {
        // Remove Rp, spaces, and dots, then convert to float
        $cleaned = str_replace(['Rp', ' ', '.'], '', $formatted);
        $cleaned = str_replace(',', '.', $cleaned);

        return (float) $cleaned;
    }

    /**
     * Convert float to database format (removing formatting)
     *
     * @param string $formatted
     * @return float
     */
    public static function toDatabase(string $formatted): float
    {
        return self::parseIDR($formatted);
    }
}
