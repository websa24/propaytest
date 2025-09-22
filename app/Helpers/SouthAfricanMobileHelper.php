<?php

namespace App\Helpers;

class SouthAfricanMobileHelper
{
    /**
     * Validate a South African mobile number
     *
     * @param string $mobileNumber
     * @return bool
     */
    public static function isValid(string $mobileNumber): bool
    {
        // Check for South African mobile number formats (digits only)
        if (preg_match('/^0[6-8][0-9]{8}$/', $mobileNumber)) {
            // Valid format: 0XXXXXXXXX (10 digits starting with 06-08)
            return true;
        }

        if (preg_match('/^27[6-8][0-9]{8}$/', $mobileNumber)) {
            // Valid format: 27XXXXXXXXX (11 digits starting with 276-8)
            return true;
        }

        return false;
    }

    /**
     * Generate a valid South African mobile number
     *
     * @return string
     */
    public static function generate(): string
    {
        $prefixes = [
            '060',
            '061',
            '062',
            '063',
            '064',
            '065',
            '066',
            '067',
            '068',
            '069',
            '071',
            '072',
            '073',
            '074',
            '075',
            '076',
            '077',
            '078',
            '079',
            '081',
            '082',
            '083',
            '084',
            '085',
            '086',
            '087',
            '088',
            '089'
        ];

        $prefix = $prefixes[array_rand($prefixes)];
        $suffix = str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT);

        return $prefix . $suffix;
    }
}
