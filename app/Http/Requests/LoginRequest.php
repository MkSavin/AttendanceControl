<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class LoginRequest extends FormRequest {
    
    /**
     * Метод проверяет можно ли пользователю отправлять эту форму или нет
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Метод возвращает правила валидации формы
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:4',
            'g-recaptcha-response' => config('services.captcha.enabled') ? 'required|captcha' : 'nullable',
        ];

        return $rules;
    }

}
