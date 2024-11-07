<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OptionRequest;
use App\Http\Resources\OptionResource;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
     // Получение всех записей с пагинацией
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $options = Option::paginate($perPage);
        return OptionResource::collection($options);
    }
 
     // Получение одной записи
    public function show($id)
    {
        $option = Option::findOrFail($id);
        return new OptionResource($option);
    }
 
     // Создание новой записи
    public function store(OptionRequest $request)
    {
        $option = Option::create($request->validated());
        return new OptionResource($option);
    }
 
    // Обновление существующей записи
    public function update(OptionRequest $request, $id)
    {
        $option = Option::findOrFail($id);
        $option->update($request->validated());
        return new OptionResource($option);
    }

    // Удаление записи
    public function destroy($id)
    {
        $option = Option::findOrFail($id);
        $option->delete();
        return response()->json(null, 204);
    }
}
