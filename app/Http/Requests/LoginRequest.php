<?php

namespace App\Http\Requests;

use App;
use Illuminate\Foundation\Http\FormRequest;

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
            'g-recaptcha-response' => 'required|captcha',
        ];

        return $rules;
    }

    /**
     * Метод возвращает сообщение при неверно введенных данных
     *
     * @return array
     */
    public function messages()
    {
        $locale = App::getLocale();
        App::setLocale("ru");
        $messages = parent::messages();
        App::setLocale($locale);
        
        return $messages;
    }

}
