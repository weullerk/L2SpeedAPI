<?php

namespace App\Services;

use App\Models\Account;
use App\Models\RecoverPassword;
use App\Mail\RecoverPassword as RecoverPasswordMail;
use App\Traits\PasswordEncryper;
use Illuminate\Support\Facades\Mail;

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
        $account->lastactive = 0;
        $account->access_level = 0;
        $account->lastServer = 0;

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

    public function recoverPassword($email) {
        $account = Account::firstWhere('email', $email);

        if (!$account) {
            throw new \Exception("Não foi encontrado nenhuma conta com o email informado.");
        }

        $recoverPassword = new RecoverPassword();
        $recoverPassword->hash = sha1(mt_rand(1, 90000) . date('Y-m-d H:i:s') . 'SALT');;
        $recoverPassword->login = $account->login;
        $recoverPassword->done = false;

        if (!$recoverPassword->save()) {
            throw new \Exception("Ocorreu uma falha ao recuperar sua senha, entre em contato conosco para prosseguirmos.");
        }

        try {
            Mail::to($email)->send(new RecoverPasswordMail($account->login, $recoverPassword->hash));
        } catch (\Exception $e) {
            throw new \Exception("Falha ao enviar email com o link de recuperação de senha, entre em contato conosco.");
        }
    }

    public function resetPassword($token, $password) {
        $recoveryPassword = RecoverPassword::firstWhere([
            'hash' => $token,
            'done' => false
        ]);

        if (!$recoveryPassword) {
            throw new \Exception("Token não encontrado, ou está inválido! Faça uma nova requisição de recuperação de senha.");
        }

        $account = Account::firstWhere('login', $recoveryPassword->login);

        if (!$account) {
            throw new \Exception("Não foi encontrado uma conta associada ao token, entre em contato conosco");
        }

        $account->password = $this->passwordEncryper($password);

        return $account->save();
    }

}
