<?php

namespace App\Traits;

trait PasswordEncryper
{
    public function passwordEncryper($password) : string
    {
        return str_replace('$2y$', '$2a$', password_hash($password, PASSWORD_BCRYPT));
    }
}
