<div class="modal fade text-dark-seia" id="{{ $identifier }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="{{ $identifier }}Label" aria-hidden="true" data-id="{{ $id }}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $identifier }}Label">
                    {{ $titleModal }}
                </h5>
                <button type="button" class="btn btn-seia-oceanblue d-flex justify-content-center align-items-center p-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="p ph-x fw-bold" ></i>    
                </button>
            </div>

           <div class="card-body my-4">
                {{ $slot }}
           </div>

            <div class="row ms-2 me-2 card-footer">
                <div class="col-12 d-flex justify-content-end mt-3 mb-2">
                    <button type="submit" class="btn btn btn-seia-oceanblue">Salvar</button>
                    <button type="button" class="btn btn-seia-red ms-2" data-bs-dismiss="modal"
                        aria-label="Close">Cancelar</button>
                </div>
            </div>
        </div>

    </div>

</div>
