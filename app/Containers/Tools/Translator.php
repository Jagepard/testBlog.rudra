<?php

namespace App\Containers\Tools;

trait Translator
{
    /**
     * @param string $value
     * @return string
     */
    public function translit(string $value): string
    {
        $converter = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        ];

        $value = mb_strtolower($value);
        $value = strtr($value, $converter);
        $value = \mb_ereg_replace('[^-0-9a-z]', '-', $value);
        $value = \mb_ereg_replace('[-]+', '-', $value);

        return trim($value, '-');
    }

    /**
     * @param $string
     * @return string
     */
    public function slugify($string): string
    {
        $string = \transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();",
            $string);
        $string = preg_replace('/[-\s]+/', '-', $string);

        return trim($string, '-');
    }
}
