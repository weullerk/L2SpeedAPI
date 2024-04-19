<?php

namespace App\Traits;

trait PasswordEncryper
{
    public function passwordEncryper($password) : string
    {
        return str_replace('$2y$', '$2a$', base64_encode(hash("sha1", $password, true)));
    }
}
