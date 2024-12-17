<?php

namespace App\Http\Resources;

use App\Models\Plans\Image;
use App\Models\Plans\PlanImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{

    protected function get_index_images($plan_id){
        $images = Image::whereHas('plans', function ($query) use ($plan_id) {
            $query->where('plan_id', $plan_id);
        })
        ->where('show_in_index', true)
        ->orderBy('sort_order')
        ->get();
        return $images;
    }

    protected function get_not_index_images($plan_id){
        $images = Image::whereHas('plans', function ($query) use ($plan_id) {
            $query->where('plan_id', $plan_id);
        })
        ->where('show_in_index', '!=', true)
        ->orderBy('sort_order')
        ->get();
        return $images;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            "floor_title" => $this->floor_title,
            "square" => $this->square,
            "all_images" => $this->images,
            "index_images" => $this->get_index_images($this->id),
            "not_index_images" => $this->get_not_index_images($this->id),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,

        ];
    }
}
