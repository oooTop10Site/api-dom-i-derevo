@extends('layouts.app')

@section('title', request()->routeIs('*.create') ? 'Добавление услуги' : 'Редактирование услуги')

@section('links')
    <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script>
        $(function () {
            $('#description').summernote({"height": 300});
        })
    </script>
@endsection

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
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card-body row">
            <div class="form-group col-12 col-md-6">
                <label for="name">Название <strong class="text-danger">*</strong></label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Введите название" value="{{ old('name', !empty($service->name) ? $service->name : '') }}">
                @error('name')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="price[full]">Цена <strong class="text-danger">*</strong></label>
                <input name="price[full]" type="number" min="0.00" step="0.01" class="form-control" id="price[full]" placeholder="Введите цену" value="{{ old('price[full]', !empty($service->price->full) ? number_format($service->price->full, 2, '.', '') : '0.00') }}">
                @error('price[full]')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="price[meter]">Цена за метр<sup>2</sup></label>
                <input name="price[meter]" type="number" min="0.00" step="0.01" class="form-control" id="price[meter]" placeholder="Введите цену за квадратный метр" value="{{ old('price[meter]', !empty($service->price->meter) ? number_format($service->price->meter, 2, '.', '') : '0.00') }}">
                @error('price[meter]')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="price[mortgage]">Цена в месяц в ипотеку</label>
                <input name="price[mortgage]" type="number" min="0.00" step="0.01" class="form-control" id="price[mortgage]" placeholder="Введите цену в месяц в ипотеку" value="{{ old('price[mortgage]', !empty($service->price->mortgage) ? number_format($service->price->mortgage, 2, '.', '') : '0.00') }}">
                @error('price[mortgage]')
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
                <label for="preview">Превью описания</label>
                <textarea name="preview" class="form-control" id="preview" placeholder="Введите превью описания">{{ old('preview', !empty($service->preview) ? $service->preview : '') }}</textarea>
                @error('preview')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12">
                <label for="description">Описание</label>
                <textarea name="description" class="form-control" id="description" placeholder="Введите описание">{{ old('description', !empty($service->description) ? $service->description : '') }}</textarea>
                @error('description')
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
                <h3 class="card-title">Дополнительные изображения</h3>
            </div>
        </div>

        <div class="card-body row" id="additional_images">
            @if(!empty(old('images', !empty($images) ? true : false)))
                @php
                $images = old('images', !empty($images) ? $images : []);
                @endphp
                @foreach($images as $key => $image)
                    <div class="form-group col-12 col-md-5" id="images-{{ $key }}">
                        <div class="d-flex justify-content-between">
                            <img id="preview_image"
                                 src="{{ !empty($image->image) ? Storage::url($image->image) : asset('storage/placeholder.webp') }}"
                                 class="rounded mr-3" style="width: 70px; height: 70px;" alt="Превью изображения">
                            <div class="w-100">
                                <label for="images[{{ $key }}][image]">Изображение <strong class="text-danger">*</strong></label>
                                <div class="custom-file">
                                    <input name="images[{{ $key }}][image]" type="file" class="custom-file-input" accept="{{ ('main.input.file.accept') }}"
                                           id="images[{{ $key }}][image]" onchange="changePreviewImage(this)">
                                    <label class="custom-file-label" for="images[{{ $key }}][image]">{{ __('main.input.file.chose') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 col-md-5" id="images-{{ $key }}">
                        <label for="images[{{ $key }}][sort_order]">Порядок сортировки <strong class="text-danger">*</strong></label>
                        <input name="images[{{ $key }}][sort_order]" min="0" step="1" type="number" class="form-control" id="images[{{ $key }}][sort_order]" placeholder="Введите порядок сортировки" value="{{ old('images.' . $key . '.sort_order', !empty($image->sort_order) ? $image->sort_order : 0) }}">
                    </div>
                    <div class="form-group col-12 col-md-2 d-flex align-items-end" id="images-{{ $key }}">
                        <button type="button" class="btn btn-danger" onclick="deleteImageInput('images-{{ $key }}')"><i class="fas fa-trash"></i></button>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="card-body row pt-0">
            <div class="form-group col-12">
                <button type="button" class="btn btn-primary" onclick="addImageInput()"><i class="fas fa-plus mr-2"></i> Добавить изображение</button>
            </div>
            <div class="form-group col-12">
                @error('images')
                <small class="text-danger mt-2">{{ $message }}</small><br>
                @enderror
                @error('images.*.image')
                <small class="text-danger mt-2">{{ $message }}</small><br>
                @enderror
                @error('images.*.sort_order')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <script>
            let imageFormCount = {{ count(old('images', !empty($images) ? $images : [])) }};
            let block = document.getElementById('additional_images');

            function addImageInput() {
                let idx = imageFormCount++;
                generateImageInput(idx);
            }

            function deleteImageInput(id) {
                document.querySelectorAll(`#${id}`).forEach((el) => el.remove());
            }

            function generateImageInput(idx) {
                let div = document.createElement('div');
                div.setAttribute('class', 'form-group col-12 col-md-5');
                div.setAttribute('id', `images-${idx}`);
                div.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <img id="preview_image"
                             src="{{ asset('storage/placeholder.webp') }}"
                             class="rounded mr-3" style="width: 70px; height: 70px;" alt="Превью изображения">
                        <div class="w-100">
                            <label for="images[${idx}][image]">Изображение <strong class="text-danger">*</strong></label>
                            <div class="custom-file">
                                <input name="images[${idx}][image]" type="file" class="custom-file-input" accept=""
                                       id="images[${idx}][image]" onchange="changePreviewImage(this)">
                                <label class="custom-file-label" for="images[${idx}][image]">{{ __('main.input.file.chose') }}</label>
                            </div>
                        </div>
                    </div>
                `;

                block.appendChild(div);

                div = document.createElement('div');
                div.setAttribute('class', 'form-group col-12 col-md-5');
                div.setAttribute('id', `images-${idx}`);
                div.innerHTML = `
                    <label for="images[${idx}][sort_order]">Порядок сортировки <strong class="text-danger">*</strong></label>
                    <input name="images[${idx}][sort_order]" min="0" step="1" type="number" class="form-control" id="images[${idx}][sort_order]" placeholder="Введите порядок сортировки" value="0">
                `;

                block.appendChild(div);

                div = document.createElement('div');
                div.setAttribute('class', 'form-group col-12 col-md-2 d-flex align-items-end');
                div.setAttribute('id', `images-${idx}`);
                div.innerHTML = `<button type="button" class="btn btn-danger" onclick="deleteImageInput('images-${idx}')"><i class="fas fa-trash"></i></button>`;

                block.appendChild(div);
            }
        </script>

        <div class="card-header">
            <div>
                <h3 class="card-title">О доме</h3>
            </div>
        </div>

        <div class="card-body row">
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[house][square]">Площадь дома</label>
                <input name="additional_info[house][square]" type="text" class="form-control" id="additional_info[house][square]" placeholder="Введите площадь дома" value="{{ old('additional_info.house.square', !empty($service->additional_info->house->square) ? $service->additional_info->house->square : '') }}">
                @error('additional_info.house.square')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[house][equipment]">Комплектация</label>
                <input name="additional_info[house][equipment]" type="text" class="form-control" id="additional_info[house][equipment]" placeholder="Введите значение комплектации" value="{{ old('additional_info.house.equipment', !empty($service->additional_info->house->equipment) ? $service->additional_info->house->equipment : '') }}">
                @error('additional_info.house.equipment')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[house][finishing]">Отделка</label>
                <input name="additional_info[house][finishing]" type="text" class="form-control" id="additional_info[house][finishing]" placeholder="Введите значение отделки" value="{{ old('additional_info.house.finishing', !empty($service->additional_info->house->finishing) ? $service->additional_info->house->finishing : '') }}">
                @error('additional_info.house.finishing')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[house][repair]">Ремонт</label>
                <input name="additional_info[house][repair]" type="text" class="form-control" id="additional_info[house][repair]" placeholder="Введите значение ремонта" value="{{ old('additional_info.house.repair', !empty($service->additional_info->house->repair) ? $service->additional_info->house->repair : '') }}">
                @error('additional_info.house.repair')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[house][rooms]">Количество комнат</label>
                <input name="additional_info[house][rooms]" type="text" class="form-control" id="additional_info[house][rooms]" placeholder="Введите количество комнат" value="{{ old('additional_info.house.rooms', !empty($service->additional_info->house->rooms) ? $service->additional_info->house->rooms : '') }}">
                @error('additional_info.house.rooms')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[house][floors]">Этажей в доме</label>
                <input name="additional_info[house][floors]" type="text" class="form-control" id="additional_info[house][floors]" placeholder="Введите количество этажей в доме" value="{{ old('additional_info.house.floors', !empty($service->additional_info->house->floors) ? $service->additional_info->house->floors : '') }}">
                @error('additional_info.house.floors')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[house][material]">Материал стен</label>
                <input name="additional_info[house][material]" type="text" class="form-control" id="additional_info[house][material]" placeholder="Введите материал стен" value="{{ old('additional_info.house.material', !empty($service->additional_info->house->material) ? $service->additional_info->house->material : '') }}">
                @error('additional_info.house.material')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[house][bathroom]">Санузел</label>
                <input name="additional_info[house][bathroom]" type="text" class="form-control" id="additional_info[house][bathroom]" placeholder="Введите значение санузла" value="{{ old('additional_info.house.bathroom', !empty($service->additional_info->house->bathroom) ? $service->additional_info->house->bathroom : '') }}">
                @error('additional_info.house.bathroom')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[house][year]">Год постройки</label>
                <input name="additional_info[house][year]" type="text" class="form-control" id="additional_info[house][year]" placeholder="Введите год постройки" value="{{ old('additional_info.house.year', !empty($service->additional_info->house->year) ? $service->additional_info->house->year : '') }}">
                @error('additional_info.house.year')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="card-header">
            <div>
                <h3 class="card-title">Об участке</h3>
            </div>
        </div>

        <div class="card-body row">
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[site][square]">Площадь участка</label>
                <input name="additional_info[site][square]" type="text" class="form-control" id="additional_info[site][square]" placeholder="Введите площадь участка" value="{{ old('additional_info.site.square', !empty($service->additional_info->site->square) ? $service->additional_info->site->square : '') }}">
                @error('additional_info.site.square')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[site][category]">Категория земель</label>
                <input name="additional_info[site][category]" type="text" class="form-control" id="additional_info[site][category]" placeholder="Введите категорию земли" value="{{ old('additional_info.site.category', !empty($service->additional_info->site->category) ? $service->additional_info->site->category : '') }}">
                @error('additional_info.site.category')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="card-header">
            <div>
                <h3 class="card-title">Коммуникации и удобства</h3>
            </div>
        </div>

        <div class="card-body row">
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[communication][electricity]">Электричество</label>
                <select name="additional_info[communication][electricity]" class="form-control" id="additional_info[communication][electricity]">
                    <option value="0"{{ !old('additional_info.communication.electricity', !empty($service->additional_info->communication->electricity) ? $service->additional_info->communication->electricity : '') ? ' selected' : '' }}>{{ __('main.select.status.false') }}</option>
                    <option value="1"{{ old('additional_info.communication.electricity', !empty($service->additional_info->communication->electricity) ? $service->additional_info->communication->electricity : '') ? ' selected' : '' }}>{{ __('main.select.status.true') }}</option>
                </select>
                @error('additional_info.communication.electricity')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[communication][heating]">Отопление</label>
                <select name="additional_info[communication][heating]" class="form-control" id="additional_info[communication][heating]">
                    <option value="0"{{ !old('additional_info.communication.heating', !empty($service->additional_info->communication->heating) ? $service->additional_info->communication->heating : '') ? ' selected' : '' }}>{{ __('main.select.status.false') }}</option>
                    <option value="1"{{ old('additional_info.communication.heating', !empty($service->additional_info->communication->heating) ? $service->additional_info->communication->heating : '') ? ' selected' : '' }}>{{ __('main.select.status.true') }}</option>
                </select>
                @error('additional_info.communication.heating')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[communication][sewerage]">Канализация</label>
                <select name="additional_info[communication][sewerage]" class="form-control" id="additional_info[communication][sewerage]">
                    <option value="0"{{ !old('additional_info.communication.sewerage', !empty($service->additional_info->communication->sewerage) ? $service->additional_info->communication->sewerage : '') ? ' selected' : '' }}>{{ __('main.select.status.false') }}</option>
                    <option value="1"{{ old('additional_info.communication.sewerage', !empty($service->additional_info->communication->sewerage) ? $service->additional_info->communication->sewerage : '') ? ' selected' : '' }}>{{ __('main.select.status.true') }}</option>
                </select>
                @error('additional_info.communication.sewerage')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[communication][water]">Водоснабжение</label>
                <select name="additional_info[communication][water]" class="form-control" id="additional_info[communication][water]">
                    <option value="0"{{ !old('additional_info.communication.water', !empty($service->additional_info->communication->water) ? $service->additional_info->communication->water : '') ? ' selected' : '' }}>{{ __('main.select.status.false') }}</option>
                    <option value="1"{{ old('additional_info.communication.water', !empty($service->additional_info->communication->water) ? $service->additional_info->communication->water : '') ? ' selected' : '' }}>{{ __('main.select.status.true') }}</option>
                </select>
                @error('additional_info.communication.water')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[communication][gas]">Газ</label>
                <select name="additional_info[communication][gas]" class="form-control" id="additional_info[communication][gas]">
                    <option value="0"{{ !old('additional_info.communication.gas', !empty($service->additional_info->communication->gas) ? $service->additional_info->communication->gas : '') ? ' selected' : '' }}>{{ __('main.select.status.false') }}</option>
                    <option value="1"{{ old('additional_info.communication.gas', !empty($service->additional_info->communication->gas) ? $service->additional_info->communication->gas : '') ? ' selected' : '' }}>{{ __('main.select.status.true') }}</option>
                </select>
                @error('additional_info.communication.gas')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[communication][terrace]">Терраса</label>
                <select name="additional_info[communication][terrace]" class="form-control" id="additional_info[communication][terrace]">
                    <option value="0"{{ !old('additional_info.communication.terrace', !empty($service->additional_info->communication->terrace) ? $service->additional_info->communication->terrace : '') ? ' selected' : '' }}>{{ __('main.select.status.false') }}</option>
                    <option value="1"{{ old('additional_info.communication.terrace', !empty($service->additional_info->communication->terrace) ? $service->additional_info->communication->terrace : '') ? ' selected' : '' }}>{{ __('main.select.status.true') }}</option>
                </select>
                @error('additional_info.communication.terrace')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="card-header">
            <div>
                <h3 class="card-title">Расположение</h3>
            </div>
        </div>

        <div class="card-body row">
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[location][address]">Адрес участка</label>
                <input name="additional_info[location][address]" type="text" class="form-control" id="additional_info[location][address]" placeholder="Введите адрес участка" value="{{ old('additional_info.location.address', !empty($service->additional_info->location->address) ? $service->additional_info->location->address : '') }}">
                @error('additional_info.location.address')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[location][map]">Код карты</label>
                <textarea name="additional_info[location][map]" class="form-control" id="additional_info[location][map]" placeholder="Введите код карты участка">{{ old('additional_info.location.map', !empty($service->additional_info->location->map) ? $service->additional_info->location->map : '') }}</textarea>
                @error('additional_info.location.map')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[location][near_1]">Ближайший крупный населенный пункт/метро/ЖД станция и т.п. 1</label>
                <input name="additional_info[location][near_1]" type="text" class="form-control" id="additional_info[location][near_1]" placeholder="Введите название и расстояние" value="{{ old('additional_info.location.near_1', !empty($service->additional_info->location->near_1) ? $service->additional_info->location->near_1 : '') }}">
                @error('additional_info.location.near_1')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[location][near_2]">Ближайший крупный населенный пункт/метро/ЖД станция и т.п. 2</label>
                <input name="additional_info[location][near_2]" type="text" class="form-control" id="additional_info[location][near_2]" placeholder="Введите название и расстояние" value="{{ old('additional_info.location.near_2', !empty($service->additional_info->location->near_2) ? $service->additional_info->location->near_2 : '') }}">
                @error('additional_info.location.near_2')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="additional_info[location][near_3]">Ближайший крупный населенный пункт/метро/ЖД станция и т.п. 3</label>
                <input name="additional_info[location][near_3]" type="text" class="form-control" id="additional_info[location][near_3]" placeholder="Введите название и расстояние" value="{{ old('additional_info.location.near_3', !empty($service->additional_info->location->near_3) ? $service->additional_info->location->near_3 : '') }}">
                @error('additional_info.location.near_3')
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

        <div class="form-group col-12 col-md-6">
            <label for="videos">Видеозаписи <strong class="text-danger"></strong></label>
            <input name="videos[]" type="file" class="form-control" id="videos" multiple>
            @error('videos')
            <small class="text-danger mt-2">{{ $message }}</small>
            @enderror
        </div>

        @if(isset($service) && $service->videos->isNotEmpty())
            <div class="form-group">
                <label>Видеозаписи на данный момент</label>
                <div class="d-flex flex-wrap">
                    @foreach($service->videos as $video)
                        <div class="m-2 position-relative">
                            <video controls width="320" height="240">
                                <source src="{{ asset('storage/' . $video->path) }}" type="video/mp4">
                                Ваш браузер не поддерживает тег video.
                            </video>
                            <input type="checkbox" name="delete_videos[]" value="{{ $video->id }}"> Удалить
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </form>
@endsection

