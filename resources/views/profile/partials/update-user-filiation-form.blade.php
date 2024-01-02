<div class="col-12 row">
    <div class="col-sm-12 col-md-6 d-flex justify-content-center align-items-baseline gap-1">
        <label for="pai">Nome do pai: </label>
        <input type="text" name="pai" id="pai" value="{{$user->datauser->father_name ?? 'Não informado'}}" class="w-100" disabled>
    </div>
    <div class="col-sm-12 col-md-6 d-flex justify-content-center align-items-baseline gap-1">
        <label for="mae">Nome da mãe: </label>
        <input type="text" name="mae" id="mae" value="{{$user->datauser->mother_name ?? 'Não informado'}}" class="w-100" disabled>
    </div>
</div>

