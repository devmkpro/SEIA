<?php

namespace App\Http\Controllers\User\Data;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\DataUserUpdateRequest;

class DataUserController extends Controller
{

    /**
     * Update the user's data information.
     */
    public function update(DataUserUpdateRequest $request): mixed
    {
        if (!$request->user()->dataUser) {
            $request->user()->dataUser()->create($request->validated());
        } else {
            $request->user()->dataUser->fill($request->validated());
            $request->user()->dataUser->save();
        }

        return $this->response($request, 'profile.edit', 'Dados atualizados com sucesso!');
    }
}
