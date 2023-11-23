@extends('layouts.app')

@section('title', 'Главная')

@section('scripts')
    <script src="{{ asset('/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

    <script>
        $('#phone').inputmask('+7 (999) 999-99-99')
    </script>
@endsection

@section('content')
    <form class="card card-default" action="{{ route('main.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-header">
            <div class="d-flex align-items-center row">
                <div class="col-sm-6">
                    <h3 class="card-title">{{ __('main.form.update') }}</h3><br>
                    <sub>{!! __('main.form.required') !!}</sub>
                </div>
                <div class="col-sm-6 text-right">
                    <button type="submit" class="btn btn-primary" title="{{ __('main.button.save') }}"><i class="fas fa-save"></i></button>
                </div>
            </div>
        </div>

        <div class="card-body row">
            <div class="form-group col-12 col-md-6">
                <label for="email">Адрес электронной почты</label>
                <input name="data[email]" type="email" class="form-control" id="email" placeholder="Введите адрес электронной почты" value="{{ old('data.email', !empty($data['email']) ? $data['email'] : '') }}">
                @error('data.email')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="phone">Номер телефона</label>
                <input name="data[phone]" type="text" class="form-control" id="phone" placeholder="+7 (___) ___-__-__" value="{{ old('data.phone', !empty($data['phone']) ? $data['phone'] : '') }}">
                @error('data.phone')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="address">Адрес</label>
                <input name="data[address]" type="text" class="form-control" id="address" placeholder="Введите адрес" value="{{ old('data.address', !empty($data['address']) ? $data['address'] : '') }}">
                @error('data.address')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="map">Карта</label>
                <textarea name="data[map]" class="form-control" id="map" placeholder="Вставьте код карты">{{ old('data.map', !empty($data['map']) ? $data['map'] : '') }}</textarea>
                @error('data.map')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="card-header">
            <div>
                <h3 class="card-title">SEO данные</h3>
            </div>
        </div>
        <div class="card-body row">
            <div class="form-group col-12 col-md-6">
                <label for="meta_title">Meta title <strong class="text-danger">*</strong></label>
                <input name="data[meta_title]" type="text" class="form-control" id="meta_title" placeholder="Введите meta title" value="{{ old('data.meta_title', !empty($data['meta_title']) ? $data['meta_title'] : '') }}">
                @error('data.meta_title')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="meta_description">Meta description <strong class="text-danger">*</strong></label>
                <textarea name="data[meta_description]" class="form-control" id="meta_description" placeholder="Введите meta description">{{ old('data.meta_description', !empty($data['meta_description']) ? $data['meta_description'] : '') }}</textarea>
                @error('data.meta_description')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="meta_keywords">Meta keywords</label>
                <textarea name="data[meta_keywords]" class="form-control" id="meta_keywords" placeholder="Введите meta keywords">{{ old('data.meta_keywords', !empty($data['meta_keywords']) ? $data['meta_keywords'] : '') }}</textarea>
                @error('data.meta_keywords')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="card-header">
            <div>
                <h3 class="card-title">Раздел обо мне</h3>
            </div>
        </div>
        <div class="card-body row">
            <div class="form-group col-12 col-md-6">
                <label for="about">Обо мне <strong class="text-danger">*</strong></label>
                <textarea name="data[about]" class="form-control" id="about" placeholder="Введите описание для раздела обо мне">{{ old('data.about', !empty($data['about']) ? $data['about'] : '') }}</textarea>
                @error('data.about')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </form>
@endsection
