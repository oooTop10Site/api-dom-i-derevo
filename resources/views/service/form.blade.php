@extends('layouts.app')

@section('title', request()->routeIs('*.create') ? 'Добавление услуги' : 'Редактирование услуги')

@section('content')
    <form class="card card-default" action="{{ request()->routeIs('*.create') ? route('service.store', $_GET) : route('service.update', array_merge(['service' => $service->id], $_GET)) }}" method="POST" enctype="multipart/form-data">
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
                <label for="name">Название <strong class="text-danger">*</strong></label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Введите название" value="{{ old('name', !empty($service->name) ? $service->name : '') }}">
                @error('name')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="price">Цена <strong class="text-danger">*</strong></label>
                <input name="price" type="number" min="0.00" step="0.01" class="form-control" id="price" placeholder="Введите цену" value="{{ old('price', !empty($service->price) ? number_format($service->price, 2) : '0.00') }}">
                @error('price')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <div class="d-flex justify-content-between">
                    <img id="preview_image" src="{{ !empty($service->image) ? Storage::url($service->image) : asset('storage/placeholder.webp') }}" class="rounded mr-3" style="width: 70px; height: 70px;" alt="Превью изображения">
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
                <textarea name="description" class="form-control" id="description" placeholder="Введите описание">{{ old('description', !empty($service->description) ? $service->description : '') }}</textarea>
                @error('description')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="preview">Превью описания</label>
                <textarea name="preview" class="form-control" id="preview" placeholder="Введите превью описания">{{ old('preview', !empty($service->preview) ? $service->preview : '') }}</textarea>
                @error('preview')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="sort_order">Порядок сортировки <strong class="text-danger">*</strong></label>
                <input name="sort_order" min="0" step="1" type="number" class="form-control" id="sort_order" placeholder="Введите порядок сортировки" value="{{ old('sort_order', !empty($service->sort_order) ? $service->sort_order : 0) }}">
                @error('sort_order')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="status">Статус</label>
                <select name="status" class="form-control" id="status">
                    <option value="0"{{ !old('status', !empty($service->status) ? $service->status : '') ? ' selected' : '' }}>{{ __('main.select.status.false') }}</option>
                    <option value="1"{{ old('status', !empty($service->status) ? $service->status : '') ? ' selected' : '' }}>{{ __('main.select.status.true') }}</option>
                </select>
                @error('status')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="card-header">
            <div>
                <h3 class="card-title">Связи</h3>
            </div>
        </div>

        <div class="card-body row">
            <div class="form-group col-12 col-md-6">
                <label for="categories">Категории</label>
                <div class="form-control pre-scrollable" style="height: 200px;">
                    @php
                        $service_to_categories = !empty($service) ? $service->relationship_category()->select('category_id')->get()->toArray() : [];
                    @endphp
                    @foreach($categories as $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[][category_id]" id="categories" value="{{ $item->id }}"{{ in_array(['category_id' => $item->id], old('categories', $service_to_categories)) ? ' checked' : '' }}>
                            <label class="form-check-label" for="categories">{{ $item->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('categories')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="examples">Примеры работ</label>
                <div class="form-control pre-scrollable" style="height: 200px;">
                    @php
                        $service_to_examples = !empty($service) ? $service->relationship_example()->select('example_id')->get()->toArray() : [];
                    @endphp
                    @foreach($examples as $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="examples[][example_id]" id="examples" value="{{ $item->id }}"{{ in_array(['example_id' => $item->id], old('examples', $service_to_examples)) ? ' checked' : '' }}>
                            <label class="form-check-label" for="examples">{{ $item->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('examples')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="services">Другие услуги</label>
                <div class="form-control pre-scrollable" style="height: 200px;">
                    @php
                        $service_to_services = !empty($service) ? $service->relationship_service()->select('additional_service_id')->get()->toArray() : [];
                    @endphp
                    @foreach($services as $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services[][additional_service_id]" id="services" value="{{ $item->id }}"{{ in_array(['additional_service_id' => $item->id], old('services', $service_to_services)) ? ' checked' : '' }}>
                            <label class="form-check-label" for="services">{{ $item->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('services')
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
                <input name="meta_title" type="text" class="form-control" id="meta_title" placeholder="Введите meta title" value="{{ old('meta_title', !empty($service->meta_title) ? $service->meta_title : '') }}">
                @error('meta_title')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="meta_h1">Meta h1</label>
                <input name="meta_h1" type="text" class="form-control" id="meta_h1" placeholder="Введите meta h1" value="{{ old('meta_h1', !empty($service->meta_h1) ? $service->meta_h1 : '') }}">
                @error('meta_h1')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="meta_description">Meta description</label>
                <textarea name="meta_description" class="form-control" id="meta_description" placeholder="Введите meta description">{{ old('meta_description', !empty($service->meta_description) ? $service->meta_description : '') }}</textarea>
                @error('meta_description')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="meta_keywords">Meta keywords</label>
                <textarea name="meta_keywords" class="form-control" id="meta_keywords" placeholder="Введите meta keywords">{{ old('meta_keywords', !empty($service->meta_keywords) ? $service->meta_keywords : '') }}</textarea>
                @error('meta_keywords')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="seo_keyword">ЧПУ</label>
                <input name="seo_keyword" type="text" class="form-control" id="seo_keyword" placeholder="Введите ЧПУ" value="{{ old('seo_keyword', !empty($service->seo_keyword) ? $service->seo_keyword : '') }}">
                @error('seo_keyword')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </form>
@endsection

