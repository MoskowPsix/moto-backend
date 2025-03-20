<?php

namespace App\Actions\Controllers\Cup;

use App\Contracts\Actions\Controllers\Cup\CreateCupActionContract;
use App\Http\Requests\Cup\CreateCupRequest;
use App\Http\Resources\Cup\Create\SuccessCreateCupResource;
use App\Models\Cup;

class CreateCupAction implements CreateCupActionContract
{

    public function __invoke(CreateCupRequest $request): SuccessCreateCupResource
    {
        $user = auth()->user();
        $cup = Cup::create([
            'name'          => $request->name,
            'year'          => $request->year,
            'stages'        => $request->stages,
            'color'         => $request->color,
            'location_id'   => $request->locationId,
            'user_id'       => $user->id,
        ]);
        $this->saveImage($request->image, $cup);
        return SuccessCreateCupResource::make($cup);
    }
    private function saveImage($image, Cup $cup): void
    {
        $path = $image->store('cup/' . $cup->id, 'public');
        $cup->update(['image' => $path]);
    }
}
