@extends('layouts.app')

@section('title', 'Главная')

@section('links')
    <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

    <script>
        $(function () {
            $('#about').summernote({"height": 300});
            $('#politic').summernote({"height": 300});
            $('#about_company').summernote({"height": 300});
        })

        $('#phone').inputmask('+7 (999) 999-99-99');
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
                <label for="email">Адрес электронной почты <strong class="text-danger">*</strong></label>
                <input name="data[email]" type="email" class="form-control" id="email" placeholder="Введите адрес электронной почты" value="{{ old('data.email', !empty($data['email']) ? $data['email'] : '') }}">
                @error('data.email')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="phone_1">Номер телефона 1 <strong class="text-danger">*</strong></label>
                <input name="data[phone_1]" type="text" class="form-control" id="phone_1" placeholder="+7 (___) ___-__-__" value="{{ old('data.phone_1', !empty($data['phone_1']) ? $data['phone_1'] : '') }}">
                @error('data.phone_1')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="phone_2">Номер телефона 2 <strong class="text-danger">*</strong></label>
                <input name="data[phone_2]" type="text" class="form-control" id="phone_2" placeholder="+7 (___) ___-__-__" value="{{ old('data.phone_2', !empty($data['phone_2']) ? $data['phone_2'] : '') }}">
                @error('data.phone_2')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="address">Адрес <strong class="text-danger">*</strong></label>
                <input name="data[address]" type="text" class="form-control" id="address" placeholder="Введите адрес" value="{{ old('data.address', !empty($data['address']) ? $data['address'] : '') }}">
                @error('data.address')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="short_address">Сокращенный адрес <strong class="text-danger">*</strong></label>
                <input name="data[short_address]" type="text" class="form-control" id="short_address" placeholder="Введите сокращенный адрес" value="{{ old('data.short_address', !empty($data['short_address']) ? $data['short_address'] : '') }}">
                @error('data.short_address')
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
            <div class="form-group col-12 col-md-6">
                <label for="map_link">Ссылка на карту</label>
                <input name="data[map_link]" type="text" class="form-control" id="map_link" placeholder="Введите ссылку на карту" value="{{ old('data.map_link', !empty($data['map_link']) ? $data['map_link'] : '') }}">
                @error('data.map_link')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <div class="d-flex justify-content-between">
                    <img id="preview_image" src="{{ !empty($data['favicon']) ? Storage::url($data['favicon']) : asset('storage/placeholder.webp') }}" class="rounded mr-3" style="width: 70px; height: 70px;" alt="Превью изображения">
                    <div class="w-100">
                        <label for="favicon">Фавикон</label>
                        <div class="custom-file">
                            <input name="data[favicon]" type="file" class="custom-file-input" accept="{{ __('main.input.file.accept') }}" id="favicon" onchange="changePreviewImage(this)">
                            <label class="custom-file-label" for="favicon">{{ __('main.input.file.chose') }}</label>
                        </div>
                    </div>
                </div>
                @error('data.favicon')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12">
                <label for="politic">Блок "Политика в отношении обработки персональных данных" <strong class="text-danger">*</strong></label>
                <textarea name="data[politic]" class="form-control" id="politic" placeholder="Введите описание для раздела">{{ old('data.politic', !empty($data['politic']) ? $data['politic'] : '') }}</textarea>
                @error('data.politic')
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
    </form>
@endsection
