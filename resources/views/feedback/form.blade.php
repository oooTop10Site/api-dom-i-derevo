@extends('layouts.app')

@section('title', request()->routeIs('*.create') ? 'Добавление заявки на обратную связь' : 'Редактирование заявки на обратную связь')

@section('content')
    <form class="card card-default" action="{{ request()->routeIs('*.create') ? route('feedback.store', $_GET) : route('feedback.update', array_merge(['feedback' => $feedback->id], $_GET)) }}" method="POST" enctype="multipart/form-data">
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
                <label for="author">Автор <strong class="text-danger">*</strong></label>
                <input name="author" type="text" class="form-control" id="author" placeholder="Введите автора" value="{{ old('author', !empty($feedback->author) ? $feedback->author : '') }}">
                @error('author')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="email">Email</label>
                <input name="email" type="text" class="form-control" id="email" placeholder="Введите адрес электронной почты" value="{{ old('email', !empty($feedback->email) ? $feedback->email : '') }}">
                @error('email')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="phone">Номер телефона <strong class="text-danger">*</strong></label>
                <input name="phone" type="text" class="form-control" id="phone" placeholder="Введите номер телефона" value="{{ old('phone', !empty($feedback->phone) ? $feedback->phone : '') }}">
                @error('phone')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="text">Текст пользователя</label>
                <textarea name="text" class="form-control" id="text" placeholder="Введите текст пользователя">{{ old('text', !empty($feedback->text) ? $feedback->text : '') }}</textarea>
                @error('text')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="url">URL страницы, с которой написано сообщение <strong class="text-danger">*</strong></label>
                <input name="url" type="text" class="form-control" id="url" placeholder="Введите URL" value="{{ old('url', !empty($feedback->url) ? $feedback->url : '') }}">
                @error('url')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="status">Статус</label>
                <select name="status" class="form-control" id="status">
                    <option value="0"{{ !old('status', !empty($feedback->status) ? $feedback->status : '') ? ' selected' : '' }}>{{ __('main.select.status.false') }}</option>
                    <option value="1"{{ old('status', !empty($feedback->status) ? $feedback->status : '') ? ' selected' : '' }}>{{ __('main.select.status.true') }}</option>
                </select>
                @error('status')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </form>
@endsection

