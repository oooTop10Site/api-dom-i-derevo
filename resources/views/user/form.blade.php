@extends('layouts.app')

@section('title', request()->routeIs('*.create') ? 'Добавление пользователя' : 'Редактирование пользователя')

@section('content')
    <form class="card card-default" action="{{ request()->routeIs('*.create') ? route('user.store', $_GET) : route('user.update', array_merge(['user' => $user->id], $_GET)) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(request()->routeIs('*.edit'))
            @method('PUT')
        @endif

        <div class="card-header">
            <div class="d-flex align-items-center row">
                <div class="col-sm-6">
                    <h3 class="card-title">{{ request()->routeIs('*.create') ? __('main.form.create') : __('main.form.update') }}</h3><br>
                    <sub>{!! __('main.form.required') !!}</sub>
                </div>
                <div class="col-sm-6 text-right">
                    <button type="submit" class="btn btn-primary mr-2" title="{{ __('main.button.save') }}"><i class="fas fa-save"></i></button>
                    <a href="javascript:window.history.back();" class="btn btn-secondary" title="{{ __('main.button.cancel') }}"><i class="fas fa-chevron-left"></i></a>
                </div>
            </div>
        </div>

        <div class="card-body row">
            <div class="form-group col-12 col-md-6">
                <label for="login">Логин <strong class="text-danger">*</strong></label>
                <input name="login" type="text" class="form-control" id="login" placeholder="Введите логин" value="{{ old('login', !empty($user->login) ? $user->login : '') }}">
                @error('login')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="name">Имя</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Введите имя" value="{{ old('name', !empty($user->name) ? $user->name : '') }}">
                @error('name')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="password">Пароль <strong class="text-danger">*</strong></label>
                <input name="password" type="password" class="form-control" id="password" placeholder="Введите пароль">
                @error('password')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="password_confirmation">Повторите пароль <strong class="text-danger">*</strong></label>
                <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Повторите пароль">
                @error('password_confirmation')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="status">Статус</label>
                <select name="status" class="form-control" id="status">
                    <option value="0"{{ !old('status', !empty($user->status) ? $user->status : '') ? ' selected' : '' }}>{{ __('main.select.status.false') }}</option>
                    <option value="1"{{ old('status', !empty($user->status) ? $user->status : '') ? ' selected' : '' }}>{{ __('main.select.status.true') }}</option>
                </select>
                @error('status')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </form>
@endsection

