@extends('layouts.app')

@section('title', 'Отзывы')

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
                            <a href="{{ route('review.create', $_GET) }}" class="btn btn-primary" title="{{ __('main.button.create') }}"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th><a href="{{ route('review.index', array_merge($_GET, ['sort' => 'id', 'order' => (request('order', 'DESC') === 'DESC' ? 'ASC' : 'DESC')])) }}">ID{!! request('sort') === 'id' ? (request('order', 'DESC') === 'DESC' ? __('main.sort.numbers.desc') : __('main.sort.numbers.asc')) : '' !!}</a></th>
                            <th><a href="{{ route('review.index', array_merge($_GET, ['sort' => 'author', 'order' => (request('order', 'DESC') === 'DESC' ? 'ASC' : 'DESC')])) }}">Автор{!! request('sort') === 'author' ? (request('order', 'DESC') === 'DESC' ? __('main.sort.chars.desc') : __('main.sort.chars.asc')) : '' !!}</a></th>
                            <th><a href="{{ route('review.index', array_merge($_GET, ['sort' => 'rating', 'order' => (request('order', 'DESC') === 'DESC' ? 'ASC' : 'DESC')])) }}">Рейтинг{!! request('sort') === 'rating' ? (request('order', 'DESC') === 'DESC' ? __('main.sort.numbers.desc') : __('main.sort.numbers.asc')) : '' !!}</a></th>
                            <th><a href="{{ route('review.index', array_merge($_GET, ['sort' => 'date_available', 'order' => (request('order', 'DESC') === 'DESC' ? 'ASC' : 'DESC')])) }}">Дата размещения{!! request('sort') === 'date_available' ? (request('order', 'DESC') === 'DESC' ? __('main.sort.numbers.desc') : __('main.sort.numbers.asc')) : '' !!}</a></th>
                            <th><a href="{{ route('review.index', array_merge($_GET, ['sort' => 'sort_order', 'order' => (request('order', 'DESC') === 'DESC' ? 'ASC' : 'DESC')])) }}">Порядок сортировки{!! request('sort') === 'sort_order' ? (request('order', 'DESC') === 'DESC' ? __('main.sort.numbers.desc') : __('main.sort.numbers.asc')) : '' !!}</a></th>
                            <th><a href="{{ route('review.index', array_merge($_GET, ['sort' => 'status', 'order' => (request('order', 'DESC') === 'DESC' ? 'ASC' : 'DESC')])) }}">Статус{!! request('sort') === 'status' ? (request('order', 'DESC') === 'DESC' ? __('main.sort.chars.asc') : __('main.sort.chars.desc')) : '' !!}</a></th>
                            <th class="text-right">{{ __('main.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($data->count() > 0)
                            @foreach($data as $key => $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->author }}</td>
                                    <td>{{ $item->rating }}</td>
                                    <td>{{ date('d.m.Y', strtotime($item->date_available)) }}</td>
                                    <td>{{ $item->sort_order }}</td>
                                    <td>{{ $item->status ? __('main.select.status.true') : __('main.select.status.false') }}</td>
                                    <td class="d-flex justify-content-end">
                                        <a href="{{ route('review.edit', array_merge(['review' => $item->id], $_GET)) }}" class="btn btn-primary mr-2" title="{{ __('main.button.edit') }}"><i class="fas fa-pen"></i></a>
                                        <form action="{{ route('review.destroy', array_merge(['review' => $item->id], $_GET)) }}" method="POST">
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
            <form class="card" id="filter-form" onsubmit="filterForm('{{ route('review.index') }}');return false;">
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
                        <label for="author">Автор</label>
                        <input name="author" type="text" class="form-control" id="author" placeholder="Введите автора" value="{{ request('author') }}">
                    </div>
                    <div class="form-group col-12">
                        <label for="rating">Рейтинг</label>
                        <input name="rating" type="number" min="1" max="5" step="1" class="form-control" id="rating" placeholder="Введите рейтинг" value="{{ request('rating') }}">
                    </div>
                    <div class="form-group col-12">
                        <label for="date_available">Дата размещения</label>
                        <input name="date_available" type="date" class="form-control" id="date_available" placeholder="Выберите дату размещения" value="{{ request('date_available') }}">
                    </div>
                    <div class="form-group col-12">
                        <label for="status">Статус</label>
                        <select name="status" class="form-control" id="status">
                            <option value="">{{ __('main.select.not_select') }}</option>
                            <option value="0"{{ request('status') === '0' ? ' selected' : '' }}>{{ __('main.select.status.false') }}</option>
                            <option value="1"{{ request('status') === '1' ? ' selected' : '' }}>{{ __('main.select.status.true') }}</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
