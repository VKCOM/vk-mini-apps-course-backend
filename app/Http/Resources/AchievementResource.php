<?php

namespace App\Http\Resources;

use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AchievementResource extends JsonResource
{
    public function __construct(
        private readonly Achievement $item,
        private readonly bool $userActivated,
    ) {
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->item->id,
            'title' => $this->item->title,
            'code' => $this->item->code,
            'img' => Storage::disk('public')->url($this->item->img, ),
            'story_img' => Storage::disk('public')->url($this->item->story_img, ),
            'activated' => $this->userActivated
        ];
    }
}
