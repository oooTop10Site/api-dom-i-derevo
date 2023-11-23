<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthController extends WebController
{
    public function index() {
        return view('auth');
    }

    public function login(AuthRequest $request) {
        $validated = $request->validated();
        $user = User::where('login', $validated['login'])->first();

        if (!empty($user)) {
            if ($user->status) {
                if (Auth::guard('web')->attempt(['login' => $validated['login'], 'password' => $validated['password']], isset($validated['remember_me']))) {
                    return redirect(route('main.edit'))->with('success', 'Вы успешно авторизовались');
                }
            } else {
                throw ValidationException::withMessages(['password' => 'Пользователь заблокирован']);
            }
        }

        throw ValidationException::withMessages(['password' => 'Неверный логин или пароль']);
    }

    public function logout() {
        Session::flush();
        Auth::guard('web')->logout();

        return redirect(route('auth.index'))->with('success', 'Вы успешно вышли из аккаунта');
    }
}
