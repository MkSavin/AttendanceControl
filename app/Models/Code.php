<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{

    const CODE_CHARS = '0123456789abcdeghjkmnpqrstuwxyz';
    const CODE_LEN = 12;

    const CODE_QR_QUANT_LEN = 4;

    /**
     * Метод генерации первичного кода
     *
     * @return string
     */
    public static function GeneratePrimaryCode()
    {

        $code = "";

        for ($i = 0; $i < self::CODE_LEN; $i++) {
            $code .= self::CODE_CHARS[rand(0, strlen(self::CODE_CHARS) - 1)];
        }

        return $code;

    }

    /**
     * Метод конвертации первичного кода в код для qr
     *
     * @return string
     */
    public static function ConvertToQRCode($primary)
    {

        $code = base64_encode($primary);

        $code = implode('-', str_split($code, self::CODE_QR_QUANT_LEN));

        return $code;

    }

}
