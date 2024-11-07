<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Http\Resources\PlanResource;
use App\Models\Plans\Image;
use App\Models\Plans\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlanController extends Controller
{
    //
    public function index(Request $request){
        $perPage = $request->get('per_page', 10);
        $plans = Plan::paginate($perPage);
        return PlanResource::collection($plans);
    }
    public function show($id)
    {
        $plan = Plan::findOrFail($id);
        return new PlanResource($plan);
    }
 
     // Создание новой записи
    public function store(PlanRequest $request)
    {
        $plan = Plan::create($request->validated());
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                // Сохраняем файл и добавляем запись в базу данных
                $url = $imageFile->store('images', 'public');
                $image = Image::create(['url' => $url]);
                $plan->images()->attach($image->id);
            }
        }
        return new PlanResource($plan);
    }
 
    // Обновление существующей записи
    public function update(PlanRequest $request, $id)
    {

        $plan = Plan::findOrFail($id);
        // dd($plan);
        $plan->update($request->validated());
        if ($request->has('delete_images')) {
            $imagesToDelete = Image::whereIn('id', $request->delete_images)->get(); // Получаем изображения по id
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->url); // Удаляем файл из хранилища
                $image->delete(); // Удаляем запись из базы данных
            }
        }

        // Добавление новых изображений
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $url = $imageFile->store('images', 'public'); // Сохраняем файл в публичное хранилище
                $image = Image::create(['url' => $url]);      // Создаем запись в таблице images
                $plan->images()->attach($image->id);            // Привязываем изображение к плану
            }
        }
        return new PlanResource($plan);
    }

    // Удаление записи
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        if ($plan->images) {
            foreach ($plan->images as $image) {
                Storage::disk('public')->delete($image->url); // Удаляем файл из хранилища
                $image->delete(); // Удаляем запись из базы данных
            }
        }
        $plan->delete();
        return response()->json(true, status: 200);
    }
}
