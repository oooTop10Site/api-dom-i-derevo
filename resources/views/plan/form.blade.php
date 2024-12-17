@extends('layouts.app')

@section('title', request()->routeIs('*.create') ? 'Добавление комплектации' : 'Редактирование комплектации')

@section('content')
    <form class="card card-default" action="{{ request()->routeIs('*.create') ? route('plan.store', $_GET) : route('plan.update', array_merge(['plan' => $plan->id], $_GET)) }}" method="POST" enctype="multipart/form-data">
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
                <label for="floor_title">Заголовок <strong class="text-danger">*</strong></label>
                <input name="floor_title" type="text" class="form-control" id="floor_title" placeholder="Введите эквипмент" value="{{ old('floor_title', !empty($plan->floor_title) ? $plan->floor_title : '') }}">
                @error('floor_title')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>
        
            
            <div class="form-group col-12 col-md-6">
                <label for="square">Площадь <strong class="text-danger">*</strong></label>
                <input name="square" min="1" step="1" type="number" class="form-control" id="square" placeholder="Введите кол-во этажей" value="{{ old('square', !empty($plan->square) ? $plan->square : 1) }}">
                @error('square')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-12 col-md-6">
                <label for="images">Изображения <strong class="text-danger">*</strong></label>
                <input name="images[]" type="file" class="form-control" id="images" multiple>
                @error('images')
                <small class="text-danger mt-2">{{ $message }}</small>
                @enderror
            </div>

            @if(isset($plan) && $plan->images->isNotEmpty())
                <div class="form-group col-12">
                    <label>Изображения на данный момент</label>
                    
                    @foreach($plan->images as $image)
                        <div class="d-flex justify-content-around flex-wrap mt-2">
            
                            <div>
                                <img src="{{ asset('storage/' . $image->url) }}" alt="image" style="width: 100px; height: auto;">
                            </div>
                
                            <div>
                                <input 
                                    name="sort_order[{{ $image->id }}]" 
                                    type="number" 
                                    class="form-control" 
                                    id="sort_order" 
                                    placeholder="12" 
                                    value="{{ $image->sort_order }}">    
                            </div>
                            
                            <div>
                                <input 
                                    type="checkbox" 
                                    name="show_in_index[]" 
                                    value="{{ $image->id }}" 
                                    {{ $image->show_in_index ? 'checked' : '' }}> Показывать на главной
                            </div>
                
                            <div>
                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"> Удалить
                            </div>
                           
                        </div>
                        <hr>
                    @endforeach
                    
                </div>
            @endif
        </div>
    </form>
@endsection

