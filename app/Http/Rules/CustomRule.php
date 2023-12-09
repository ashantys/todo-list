<?php

namespace App\Http\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomRule implements Rule
{
    public function passes($attribute, $value)
    {
        return strpos($value, 'a') === false;
    }

    public function message()
    {
        return 'El campo :attribute no debe contener la letra "a".';
    }

    /* public function passes($attribute, $value){
        $hasA = strpos($value, 'a') !== false;
        $hasE = strpos($value, 'e')!== false;

        return !$hasA && !$hasE;
    }

    public function message(){
        return[
            'no_a' =>'El campo :attribute no debe contener la letra "a".',
            'no_e' => 'El campo :attribute no debe contener la letra "e".',
        ];
    } */
}