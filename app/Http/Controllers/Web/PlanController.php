<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Plans\Image;
use App\Models\Plans\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Storage;

class PlanController extends Controller
{
    public function index() {
        $data = Plan::where(function ($query) {
            if (!empty(request(key: 'floor_title'))) {
                $query->where('floor_title', 'LIKE', '%' . request('floor_title') . '%');
            }
        })->orderBy(request('sort', 'id'), request('order', 'DESC'))
        ->paginate(env('APP_PAGINATION_COUNT'));
        return view('plan.index', compact('data'));
    }

    public function create() {
        return view('plan.form');
    }

    public function store(PlanRequest $request) {
        $plan = Plan::create($request->validated());
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                // Сохраняем файл и добавляем запись в базу данных
                $path = $imageFile->store('images', 'public');
                $image = Image::create(['url' => $path]);
                $plan->images()->attach($image->id);
            }
        }
        return redirect(route('plan.index', $_GET))->with('success', __('main.alert.store'));
    }

    public function edit(Plan $plan) {
        return view('plan.form', compact('plan'));
    }

    public function update(PlanRequest $request, Plan $plan) {
        $plan->update($request->validated());
        // // Удаление отмеченных для удаления изображений
        // if ($request->has('delete_images')) {               // Проверка, что есть изображения для удаления
        //     $imagesToDelete = Image::whereIn('id', $request->delete_images)->get(); // Получаем изображения по id
        //     $plan->images()->whereIn('id', $request->input('delete_images'))->detach();
        //     foreach ($imagesToDelete as $image) {
        //         Storage::disk('public')->delete($image->url); // Удаляем файл из файловой системы
        //         $image->delete();                               // Удаляем запись из базы данных
        //     }
        // }
        if ($request->has('delete_images') && is_array($request->input('delete_images'))) {
            foreach ($request->input('delete_images') as $imageId) {
                // Используем find для безопасного поиска изображения
                $image = $plan->images()->find($imageId);
        
                if ($image) {
                    // Логируем информацию о изображении перед удалением
                    \Log::info('Удаляем изображение:', ['image_id' => $imageId, 'image_url' => $image->url]);
        
                    // Удаляем связь между изображением и планом
                    $plan->images()->detach($image->id);
        
                    // Удаляем файл изображения с диска
                    if (Storage::disk('public')->exists($image->url)) {
                        Storage::disk('public')->delete($image->url);
                    }
        
                    // Удаляем запись изображения из базы данных
                    // $image->delete();
                } else {
                    // Логируем ошибку, если изображение не найдено
                    \Log::warning('Изображение не найдено или не связано с планом для удаления:', ['image_id' => $imageId]);
                }
            }
        }

        // Добавление новых изображений
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $url = $imageFile->store('images', 'public'); // Сохраняем файл в публичное хранилище
                $image = Image::create(['url' => $url]);      // Создаем запись в таблице images
                $plan->images()->attach($image->id);            // Привязываем изображение к плану через промежуточную таблицу
            }
        }

        // Обновляем сортировку и отображение изображений
        if ($request->has('sort_order') && is_array($request->input('sort_order'))) {
            foreach ($request->input('sort_order') as $imageId => $sortOrder) {
                $image = Image::findOrFail($imageId);
                $image->sort_order = $sortOrder;
                $image->save();
            }
        }

        // Обновляем флаг "показывать на главной"
        if ($request->has('show_in_index') && is_array($request->input('show_in_index'))) {
            // Получаем все изображения и проверяем их флаги
            foreach ($plan->images as $image) {
                // Если изображение в массиве show_in_index, то устанавливаем true, иначе false
                $image->show_in_index = in_array($image->id, $request->input('show_in_index')) ? true : false;
                $image->save();
            }
        } else {
            // Если поле show_in_index не передано, сбрасываем все флаги в false
            foreach ($plan->images as $image) {
                $image->show_in_index = false;
                $image->save();
            }
        }


        return redirect(route('plan.index', $_GET))->with('success', __('main.alert.update'));
    }

    public function destroy(Plan $plan) {
        if($plan->images){
            foreach ($plan->images as $image) {
                Storage::disk('public')->delete($image->url);
                $image->delete();
            }
        }
        $plan->delete();
        return redirect(route('plan.index', $_GET))->with('success', __('main.alert.destroy'));
    }
}
