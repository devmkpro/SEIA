<?php

namespace App\Http\Controllers;
use App\Http\Requests\DataUserUpdateRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;

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
