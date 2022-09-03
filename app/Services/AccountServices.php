<?php

namespace App\Services;

use App\Models\Account;
use App\Traits\PasswordEncryper;

class AccountServices {

    use PasswordEncryper;

    public function create($login, $email, $password): bool {
        $isLoginInUse = Account::firstWhere('login', $login);

        if ($isLoginInUse) {
            throw new \Exception("O login já está sendo utilizado.");
        }

        $isEmailUse = Account::firstWhere('email', $email);
        if ($isEmailUse) {
            throw new \Exception("O email já está sendo utilizado.");
        }

        $account = new Account();

        $account->login = $login;
        $account->email = $email;
        $account->password = $this->passwordEncryper($password);
        $account->last_active = 0;
        $account->access_level = 0;
        $account->last_server = 0;

        return $account->save();
    }

    public function isLoginUsed($login): bool {
        $account = Account::firstWhere('login', $login);

        return $account != null;
    }

    public function isEmailUsed($email): bool {
        $account = Account::firstWhere('email', $email);

        return $account != null;
    }

    public function changePassword($login, $password, $newPassword): bool {
        $account = Account::firstWhere([
            'login' => $login
        ]);

        if ($account == null) {
            throw new \Exception("Não foi encontrado nenhuma conta com o login informado.");
        }

        if (!password_verify($password, $account->password)) {
            throw new \Exception("A senha atual informada não é válida.");
        }

        $account->password = $this->passwordEncryper($newPassword);

        return $account->save();
    }

}
