<div class="modal fade " id="{{ $identifier }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="{{ $identifier }}Label" aria-hidden="true" data-id="{{ $id }}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $identifier }}Label">
                    {{ $titleModal }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{ $slot }}

            <div class="row ms-2 me-2">
                <div class="col-12 d-flex justify-content-end mt-3 mb-2">
                    <button type="submit" class="btn btn-outline-primary">Salvar</button>
                    <button type="button" class="btn btn-outline-secondary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">Cancelar</button>
                </div>
            </div>
        </div>

    </div>

</div>
