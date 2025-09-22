<?php

namespace App\Enums;

enum LanguageEnum: string
{
    case English = 'english';
    case Afrikaans = 'afrikaans';
    case Zulu = 'zulu';
    case Xhosa = 'xhosa';
    case Sotho = 'sotho';
    case Tswana = 'tswana';
    case Venda = 'venda';
    case Swati = 'swati';
    case Ndebele = 'ndebele';

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [$case->value => $case->name])->toArray();
    }
}
