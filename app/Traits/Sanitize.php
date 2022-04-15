<?php

namespace App\Traits;

trait Sanitize
{

    /**
     * Remove caracteres
     * */
    public function removeCharacters($data) {
        foreach ($data as &$value) {
            $value = str_replace(['-','/','+','*','@','%','&','=','[',']','(',')'],'', $value);
        }
        return $data;
    }

}