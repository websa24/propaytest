<?php

namespace App\Helpers;

class SouthAfricanIdHelper
{
    /**
     * Validate a South African ID number
     *
     * @param string $idNumber
     * @return bool
     */
    public static function isValid(string $idNumber): bool
    {
        if (!preg_match('/^\d{13}$/', $idNumber)) {
            return false;
        }

        $birthDate = substr($idNumber, 0, 6);
        $genderSequence = substr($idNumber, 6, 4);
        $citizenship = substr($idNumber, 10, 1);
        $additionalDigit = substr($idNumber, 11, 1);
        $checksum = substr($idNumber, 12, 1);

        $year = (int) substr($birthDate, 0, 2);
        $month = (int) substr($birthDate, 2, 2);
        $day = (int) substr($birthDate, 4, 2);

        $year += $year >= 0 && $year <= 21 ? 2000 : 1900;

        if (!checkdate($month, $day, $year)) {
            return false;
        }

        if (!preg_match('/^\d{4}$/', $genderSequence)) {
            return false;
        }

        if (!in_array($citizenship, ['0', '1'])) {
            return false;
        }

        if (!in_array($additionalDigit, ['8', '9'])) {
            return false;
        }

        if (!self::isValidChecksum($idNumber)) {
            return false;
        }

        return true;
    }

    /**
     * Generate a valid South African ID number for a given birth date
     *
     * @param \DateTime $birthDate
     * @param bool|null $isMale If null, randomly assign gender
     * @return string
     */
    public static function generate(\DateTime $birthDate, ?bool $isMale = null): string
    {
        do {
            $yy = $birthDate->format('y');
            $mm = str_pad($birthDate->format('m'), 2, '0', STR_PAD_LEFT);
            $dd = str_pad($birthDate->format('d'), 2, '0', STR_PAD_LEFT);

            if ($isMale === null) {
                $isMale = rand(0, 1) == 1;
            }

            if ($isMale) {
                $ssss = str_pad(rand(5000, 9999), 4, '0', STR_PAD_LEFT);
            } else {
                $ssss = str_pad(rand(0, 4999), 4, '0', STR_PAD_LEFT);
            }

            $c = rand(0, 1);
            $a = rand(8, 9);
            $id12 = $yy . $mm . $dd . $ssss . $c . $a;

            $checksum = self::calculateChecksum($id12);

            $fullId = $id12 . $checksum;
        } while (!self::isValid($fullId));

        return $fullId;
    }

    /**
     * Calculate the checksum for a 12-digit SA ID number
     *
     * @param string $id12
     * @return string
     */
    public static function calculateChecksum(string $id12): string
    {
        $digits = str_split($id12);
        $sum = 0;

        for ($i = 0; $i < 12; $i++) {
            $digit = (int) $digits[$i];
            if ($i % 2 == 1) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
        }

        return (string) ((10 - ($sum % 10)) % 10);
    }

    /**
     * Validate checksum for a complete 13-digit SA ID number
     *
     * @param string $idNumber
     * @return bool
     */
    private static function isValidChecksum(string $idNumber): bool
    {
        $id12 = substr($idNumber, 0, 12);
        $providedChecksum = substr($idNumber, 12, 1);
        $calculatedChecksum = self::calculateChecksum($id12);

        return $calculatedChecksum === $providedChecksum;
    }
}
