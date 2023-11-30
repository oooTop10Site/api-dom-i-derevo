@extends('layouts.app')

@section('title', request()->routeIs('*.create') ? 'Добавление отзыва' : 'Редактирование отзыва')

@section('content')
    <form class="card card-default" action="{{ request()->routeIs('*.create') ? route('review.store', $_GET) : route('review.update', array_merge(['review' => $review->id], $_GET)) }}" method="POST" enctype="multipart/form-data">
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
                <input name="author" type="text" class="form-control" id="author" placeholder="Введите автора" value="{{ old('author', !empty($review->author) ? $review->author : '') }}">
                @error('author')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="category_id">Категория <strong class="text-danger">*</strong></label>
                <select name="category_id" class="form-control" id="category_id">
                    <option value="">{{ __('main.select.not_select') }}</option>
                    @foreach($categories as $item)
                        <option value="{{ $item->id }}"{{ old('category_id', !empty($review->category_id) ? $review->category_id : '') == $item->id ? ' selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="text">Текст пользователя <strong class="text-danger">*</strong></label>
                <textarea name="text" class="form-control" id="text" placeholder="Введите текст пользователя">{{ old('text', !empty($review->text) ? $review->text : '') }}</textarea>
                @error('text')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="date_available">Дата размещения <strong class="text-danger">*</strong></label>
                <input name="date_available" type="date" class="form-control" id="date_available" placeholder="Выберите дату размещения" value="{{ old('date_available', !empty($review->date_available) ? $review->date_available : date('Y-m-d')) }}">
                @error('date_available')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="sort_order">Порядок сортировки <strong class="text-danger">*</strong></label>
                <input name="sort_order" min="0" step="1" type="number" class="form-control" id="sort_order" placeholder="Введите порядок сортировки" value="{{ old('sort_order', !empty($review->sort_order) ? $review->sort_order : 0) }}">
                @error('sort_order')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="status">Статус</label>
                <select name="status" class="form-control" id="status">
                    <option value="0"{{ !old('status', !empty($review->status) ? $review->status : '') ? ' selected' : '' }}>{{ __('main.select.status.false') }}</option>
                    <option value="1"{{ old('status', !empty($review->status) ? $review->status : '') ? ' selected' : '' }}>{{ __('main.select.status.true') }}</option>
                </select>
                @error('status')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </form>
@endsection

