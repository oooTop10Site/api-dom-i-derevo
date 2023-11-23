<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends WebController
{
    public function index() {
        $data = User::where(function ($query) {
            if (!empty(request('login'))) {
                $query->where('login', 'LIKE', '%' . request('login') . '%');
            }

            if (!empty(request('name'))) {
                $query->where('name', 'LIKE', '%' . request('name') . '%');
            }

            if (!empty(request('status')) || request('status') === '0') {
                $query->where('status', request('status'));
            }
        })->orderBy(request('sort', 'id'), request('order', 'DESC'))->paginate(env('APP_PAGINATION_COUNT'));
        return view('user.index', compact('data'));
    }

    public function create() {
        return view('user.form');
    }

    public function store(UserRequest $request) {
        User::create($request->validated());
        return redirect(route('user.index', $_GET))->with('success', __('main.alert.store'));
    }

    public function edit(User $user) {
        return view('user.form', compact('user'));
    }

    public function update(UserRequest $request, User $user) {
        $user->update($request->validated());
        return redirect(route('user.index', $_GET))->with('success', __('main.alert.update'));
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect(route('user.index', $_GET))->with('success', __('main.alert.destroy'));
    }
}
