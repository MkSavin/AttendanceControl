<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Lang;

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
    public static function generatePrimaryCode()
    {
        return Str::random(self::CODE_LEN);
    }

    /**
     * Метод конвертации первичного кода в код для qr
     *
     * @return string
     */
    public static function convertToQRCode($primary)
    {
        $code = base64_encode($primary);

        $code = implode('-', str_split($code, self::CODE_QR_QUANT_LEN));

        return $code;
    }

    /**
     * Метод конвертации первичного кода в код для qr
     *
     * @return string
     */
    public static function convertFromQRCode($code)
    {
        $code = str_replace('-', '', $code);

        return base64_decode($code);
    }

    /**
     * Метод использования кода - создание посещения
     *
     * @param string $code
     * @return array
     */
    public static function useCode($code)
    {
        $user = Auth::user();
        if (!$user) {
            return [
                "error" => true,
                "code" => 10,
                "msg" => Lang::get('auth.not-loggined'),
            ];
        }
        if (!$code) {
            return [
                "error" => true,
                "code" => 1000,
                "msg" => Lang::get('sessionCode.use.error.codeEmpty'),
            ];
        }
        if (!Auth::user()->hasRight('session.use')) {
            return [
                "error" => true,
                "code" => 100,
                "msg" => Lang::get('right.error.noRight'),
            ];
        }

        $code = explode('code=', $code);
        $code = $code[count($code) - 1];

        $code = self::convertFromQRCode($code);

        $session = Session::where('code', $code)->with('user', 'session_group', 'session_group.group')->first();
        if ($session) {
            $groupExists = false;

            $session->session_group->map(function ($item) use ($user, &$groupExists) {
                if ($item->group->id == $user->group_id) {
                    $groupExists = true;
                }
            });

            if ($session->session_group->count() == 0) {
                $groupExists = true;
            }

            if (!Auth::user()->hasRight('session.use.own') && Auth::user()->id == $session->user_id) {
                return [
                    "error" => true,
                    "code" => 100,
                    "msg" => Lang::get('right.error.noRight'),
                ];
            }

            if ($session->user_type_id == $user->user_type_id && $groupExists) {

                if ($session->status != "active") {
                    return [
                        "error" => true,
                        "code" => 1003,
                        "msg" => Lang::get('sessionCode.use.error.sessionIsNotActive'),
                    ];
                }

                if (!Attendance::where([
                    ['session_id', $session->id],
                    ['user_id', $user->id],
                ])->first()) {
                    $id = Attendance::create([
                        'user_id' => $user->id,
                        'session_id' => $session->id,
                    ]);

                    if ($id) {
                        return [
                            "error" => false,
                            "success" => true,
                            "msg" => Lang::get('sessionCode.use.success'),
                            "attendance_id" => $id,
                            "session" => $session,
                        ];
                    } else {
                        return [
                            "error" => true,
                            "code" => 1005,
                            "msg" => Lang::get('sessionCode.use.error.unknown'),
                        ];
                    }
                } else {
                    return [
                        "error" => true,
                        "code" => 1004,
                        "msg" => Lang::get('sessionCode.use.error.alreadyExists'),
                    ];
                }

            } else {
                return [
                    "error" => true,
                    "code" => 1002,
                    "msg" => Lang::get('sessionCode.use.error.userNotFit'),
                ];
            }
        } else {
            return [
                "error" => true,
                "code" => 1001,
                "msg" => Lang::get('sessionCode.use.error.sessionNotFind'),
            ];
        }

    }

}
