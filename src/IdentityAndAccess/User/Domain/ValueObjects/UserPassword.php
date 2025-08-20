<?php

namespace Src\IdentityAndAccess\User\Domain\ValueObjects;

use InvalidArgumentException;

class UserPassword
{
    private string $value;
    private bool $isHash; 

    public function __construct(string $value, bool $isHash)
    {
        if ($isHash) {
            // Bcrypt (Hashing deafult de laravel) entrega cadenas de 60 caracteres
            if (strlen($value) < 60) {
                throw new InvalidArgumentException("El hash no cumple con la longitud");
            }

        } else { // El texto plano de la contraseña debe contener una seríe de requisitos
            if (strlen($value) < 12) {
                throw new InvalidArgumentException("La contraseña debe tener al menos una longitud de 12 caracteres.");
            }

            if (preg_match("/[A-Z]/", $value) <= 0) { //Find any capitalize letters
                throw new InvalidArgumentException("La contraseña debe tener al menos una letra mayuscula");
            }

            if (preg_match("/[\d]/", $value) <= 0) { //Find any digits
                throw new InvalidArgumentException("La contraseña debe tener al menos un caracter numerico");
            }

            if (preg_match("/[\W]/", $value) <= 0) { // Find any non-alphabetical and non-digit character ! " # $ % & ' ( ) * + , - . / : ; < = > ? @ [ \ ] ^ _` { | } ~
                throw new InvalidArgumentException("La contraseña debe tener al menos un caracter especial ! # $ % & ' ( ) * + , - . / : ; < = > ? @ [ \ ] ^ { | } ~");
            }

            // 
        }
        
        $this->isHash = $isHash;
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function isHash(): bool
    {
        return $this->isHash;
    }
}

