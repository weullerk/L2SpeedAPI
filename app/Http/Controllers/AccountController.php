<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AccountServices;

class AccountController extends Controller {

    public function createAccount(Request $request, AccountServices $accountServices) {
        try {
            $data = $request->all();

            if (trim($data['password']) != trim($data['repeat-password'])) {
                return response("A confirmação da senha falhou, as senhas não são iguais.");
            }

            $accountCreated = $accountServices->create($data['login'], $data['email'], trim($data['password']));

            if ($accountCreated) {
                return response("Conta criada com sucesso!", 201);

            } else {
                return response('Ocorreu uma falha ao criar sua conta, entre em contato conosco para prosseguirmos!', 500);
            }

        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
    }

    public function updatePassword(Request $request, AccountServices $accountServices) {
        try {
            $data = $request->all();

            if (trim($data['new-password']) != trim($data['repeat-password'])) {
                return response("A confirmação da senha falhou, as senhas não são iguais.");
            }

            $accountCreated = $accountServices->changePassword($data['login'], trim($data['password']), trim($data['new-password']));

            if ($accountCreated) {
                return response("Senha atualizada com sucesso!", 201);

            } else {
                return response('Ocorreu uma falha ao atualizar sua senha, entre em contato conosco para prosseguirmos!', 500);
            }

        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
    }

    public function recoverPassword(Request $request, AccountServices $accountServices) {
        try {
            $accountServices->recoverPassword($request->post('email'));

            return response("Um email com o link para definir uma nova senha foi enviada ao seu email, caso não receba confira na sua caixa de spam.");
        } catch (\Exception $e) {
            return response($e->getMessage());
        }
    }

    public function resetPassword(Request $request, AccountServices $accountServices) {
        if (trim($request->post('password')) != trim($request->post('repeat-password'))) {
            return response("A confirmação da senha falhou, as senhas não são iguais.");
        }

        try {
            $passwordReseted = $accountServices->resetPassword($request->post('token'), trim($request->post('password')));

            if ($passwordReseted) {
                return response("Senha atualizada com sucesso!", 201);

            } else {
                return response('Ocorreu uma falha ao resetar sua senha, entre em contato conosco para prosseguirmos!', 500);
            }

        } catch (\Exception $e) {
            return response($e->getMessage());
        }
    }
}
