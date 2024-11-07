@extends('layouts.app')

@section('title', request()->routeIs('*.create') ? 'Добавление комплектации' : 'Редактирование комплектации')

@section('content')
    <form class="card card-default" action="{{ request()->routeIs('*.create') ? route('option.store', $_GET) : route('option.update', array_merge(['option' => $option->id], $_GET)) }}" method="POST" enctype="multipart/form-data">
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
                <label for="equipment">Эквипмент <strong class="text-danger">*</strong></label>
                <input name="equipment" type="text" class="form-control" id="equipment" placeholder="Введите эквипмент" value="{{ old('equipment', !empty($option->equipment) ? $option->equipment : '') }}">
                @error('equipment')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="floor_text">Заголовок <strong class="text-danger">*</strong></label>
                <input name="floor_text" type="text" class="form-control" id="floor_text" placeholder="Введите загловок" value="{{ old('floor_text', !empty($option->floor_text) ? $option->floor_text : '') }}">
                @error('floor_text')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="description">Описание<strong class="text-danger">*</strong></label>
                <textarea name="description" class="form-control" id="description" placeholder="Введите описание">{{ old('description', !empty($option->description) ? $option->description : '') }}</textarea>
                @error('description')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="floor_quantity">Кол-во этажей <strong class="text-danger">*</strong></label>
                <input name="floor_quantity" min="1" step="1" type="number" class="form-control" id="floor_quantity" placeholder="Введите кол-во этажей" value="{{ old('floor_quantity', !empty($option->floor_quantity) ? $option->floor_quantity : 1) }}">
                @error('floor_quantity')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-12 col-md-6">
                <label for="services">Связь с таблицей услуги></label>
                <br>
                
                @foreach($services as $service)
                    <input type="checkbox" name="services[]" value="{{ $service->id }}" 
                        {{ isset($option) && $option->services->contains($service->id) ? 'checked' : '' }}> 
                    {{ $service->name }} 
                    <br>
                @endforeach

                @error('services')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>

           
        </div>
    </form>
@endsection

