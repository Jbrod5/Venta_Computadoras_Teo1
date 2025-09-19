<?php

namespace App\Helpers;

class Encriptador {


    public static function encriptar(string $correo, string $pass): string
    {
        $combinado = $correo . "salttt" . $pass; 
        return base64_encode($combinado);
    }

    public static function verificar($correo, $password, $hashGuardado) {
        $nuevoHash = $this->generarHash($correo, $password);
        return hash_equals($nuevoHash, $hashGuardado);
    }
}
