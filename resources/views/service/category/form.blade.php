@extends('layouts.app')

@section('title', request()->routeIs('*.create') ? 'Добавление категории услуг' : 'Редактирование категории услуг')

@section('content')
    <form class="card card-default" action="{{ request()->routeIs('*.create') ? route('service.category.store', $_GET) : route('service.category.update', array_merge(['category' => $category->id], $_GET)) }}" method="POST" enctype="multipart/form-data">
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
                <label for="category_id">Родительская категория</label>
                <select name="category_id" class="form-control" id="category_id">
                    <option value="">{{ __('main.select.not_select') }}</option>
                    @foreach($categories as $item)
                        <option value="{{ $item->id }}"{{ old('category_id', !empty($category->category_id) ? $category->category_id : '') == $item->id ? ' selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="name">Название <strong class="text-danger">*</strong></label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Введите название" value="{{ old('name', !empty($category->name) ? $category->name : '') }}">
                @error('name')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <div class="d-flex justify-content-between">
                    <img id="preview_image" src="{{ !empty($category->image) ? Storage::url($category->image) : asset('storage/placeholder.webp') }}" class="rounded mr-3" style="width: 70px; height: 70px;" alt="Превью изображения">
                    <div class="w-100">
                        <label for="image">Изображение</label>
                        <div class="custom-file">
                            <input name="image" type="file" class="custom-file-input" accept="{{ __('main.input.file.accept') }}" id="image" onchange="changePreviewImage(this)">
                            <label class="custom-file-label" for="image">{{ __('main.input.file.chose') }}</label>
                        </div>
                    </div>
                </div>
                @error('image')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="description">Описание</label>
                <textarea name="description" class="form-control" id="description" placeholder="Введите описание">{{ old('description', !empty($category->description) ? $category->description : '') }}</textarea>
                @error('description')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="preview">Превью описания</label>
                <textarea name="preview" class="form-control" id="preview" placeholder="Введите превью описания">{{ old('preview', !empty($category->preview) ? $category->preview : '') }}</textarea>
                @error('preview')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="sort_order">Порядок сортировки <strong class="text-danger">*</strong></label>
                <input name="sort_order" min="0" step="1" type="number" class="form-control" id="sort_order" placeholder="Введите порядок сортировки" value="{{ old('sort_order', !empty($category->sort_order) ? $category->sort_order : 0) }}">
                @error('sort_order')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="status">Статус</label>
                <select name="status" class="form-control" id="status">
                    <option value="0"{{ !old('status', !empty($category->status) ? $category->status : '') ? ' selected' : '' }}>{{ __('main.select.status.false') }}</option>
                    <option value="1"{{ old('status', !empty($category->status) ? $category->status : '') ? ' selected' : '' }}>{{ __('main.select.status.true') }}</option>
                </select>
                @error('status')
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
                <label for="meta_title">Meta title</label>
                <input name="meta_title" type="text" class="form-control" id="meta_title" placeholder="Введите meta title" value="{{ old('meta_title', !empty($category->meta_title) ? $category->meta_title : '') }}">
                @error('meta_title')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="meta_h1">Meta h1</label>
                <input name="meta_h1" type="text" class="form-control" id="meta_h1" placeholder="Введите meta h1" value="{{ old('meta_h1', !empty($category->meta_h1) ? $category->meta_h1 : '') }}">
                @error('meta_h1')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="meta_description">Meta description</label>
                <textarea name="meta_description" class="form-control" id="meta_description" placeholder="Введите meta description">{{ old('meta_description', !empty($category->meta_description) ? $category->meta_description : '') }}</textarea>
                @error('meta_description')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="meta_keywords">Meta keywords</label>
                <textarea name="meta_keywords" class="form-control" id="meta_keywords" placeholder="Введите meta keywords">{{ old('meta_keywords', !empty($category->meta_keywords) ? $category->meta_keywords : '') }}</textarea>
                @error('meta_keywords')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="seo_keyword">ЧПУ</label>
                <input name="seo_keyword" type="text" class="form-control" id="seo_keyword" placeholder="Введите ЧПУ" value="{{ old('seo_keyword', !empty($category->seo_keyword) ? $category->seo_keyword : '') }}">
                @error('seo_keyword')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </form>
@endsection

