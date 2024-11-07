@extends('layouts.app')

@section('title', 'Комплектации')

@section('content')
    <div class="row m-0">
        <div class="col-md-8 pl-0">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center row">
                        <div class="col-sm-6 text-right">
                            <h3 class="card-title">{{ __('main.table') }}</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('option.create', $_GET) }}" class="btn btn-primary" title="{{ __('main.button.create') }}"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th><a href="{{ route('option.index', array_merge($_GET, ['sort' => 'id', 'order' => (request('order', 'DESC') === 'DESC' ? 'ASC' : 'DESC')])) }}">ID{!! request('sort') === 'id' ? (request('order', 'DESC') === 'DESC' ? __('main.sort.numbers.desc') : __('main.sort.numbers.asc')) : '' !!}</a></th>
                            <th><a href="{{ route('option.index', array_merge($_GET, ['sort' => 'equipment', 'order' => (request('order', 'DESC') === 'DESC' ? 'ASC' : 'DESC')])) }}">Эквипмент{!! request('sort') === 'equipment' ? (request('order', 'DESC') === 'DESC' ? __('main.sort.chars.desc') : __('main.sort.chars.asc')) : '' !!}</a></th>
                            <th><a href="{{ route('option.index', array_merge($_GET, ['sort' => 'created_at', 'order' => (request('order', 'DESC') === 'DESC' ? 'ASC' : 'DESC')])) }}">Дата создания{!! request('sort') === 'created_at' ? (request('order', 'DESC') === 'DESC' ? __('main.sort.numbers.desc') : __('main.sort.numbers.asc')) : '' !!}</a></th>
                            <th><a href="{{ route('option.index', array_merge($_GET, ['sort' => 'floor_quantity', 'order' => (request('order', 'DESC') === 'DESC' ? 'ASC' : 'DESC')])) }}">Кол-во этажей{!! request('sort') === 'floor_quantity' ? (request('order', 'DESC') === 'DESC' ? __('main.sort.numbers.desc') : __('main.sort.numbers.asc')) : '' !!}</a></th>
                            <th>Привязка к услугам</th>
                            <th class="text-right">{{ __('main.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($data->count() > 0)
                            @foreach($data as $key => $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->equipment }}</td>
                                    <td>{{ date('d.m.Y', strtotime($item->created_at)) }}</td>
                                    <td>{{ $item->floor_quantity }}</td>
                                    <td>
                                        @if (count($item->services)>0)
                                            @foreach ($item->services as $serv)
                                                {{$serv->name}} <hr>
                                            @endforeach
                                            
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="{{ route('option.edit', array_merge(['option' => $item->id], $_GET)) }}" class="btn btn-primary mr-2" title="{{ __('main.button.edit') }}"><i class="fas fa-pen"></i></a>
                                        <form action="{{ route('option.destroy', array_merge(['option' => $item->id], $_GET)) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('{{ __('main.modal.info') }}');" class="btn btn-danger" title="{{ __('main.button.destroy') }}"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">{{ __('main.table.not_found') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    {!! $data->links('layouts.pagination') !!}
                </div>
            </div>
        </div>

        <div class="col-md-4 pr-0">
            <form class="card" id="filter-form" onsubmit="filterForm('{{ route('option.index') }}');return false;">
                @foreach($_GET as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <div class="card-header">
                    <div class="d-flex align-items-center row">
                        <div class="col-sm-6 text-right">
                            <h3 class="card-title">{{ __('main.filter') }}</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" class="btn btn-primary" title="{{ __('main.button.filter') }}"><i class="fas fa-filter"></i></button>
                        </div>
                    </div>
                </div>

                <div class="card-body row">
                    <div class="form-group col-12">
                        <label for="equipment">Эквипмент</label>
                        <input name="equipment" type="text" class="form-control" id="equipment" placeholder="Введите Эквипмент" value="{{ request('equipment') }}">
                    </div>  
                </div>
            </form>
        </div>
    </div>
@endsection
