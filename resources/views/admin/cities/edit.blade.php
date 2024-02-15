<x-app-layout>
    @include('components.warnings-panel')
    @include('components.messages-erros')

    @section('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <x-grid-datatables identifier="statesTable" :columns="['Estado', 'IBGE-CODE', 'Escolas']">

                </x-grid-datatables>


            </div>
        </div>
    </div>

    <x-modal titleModal="Editar Estado" identifier="editCity" id="editCity">
        <form action="" method="POST" id="editCityForm">
            @csrf
            @method('PUT')

            <div class="row ms-2 me-2">
                <div class="col-12 mt-3 mb-2">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Nome do estado" value="" required>
                </div>
            </div>
    </x-modal>
    </form>

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#statesTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                    },
                    "data": [
                        @foreach ($cities as $city)
                            [
                                `{{ $city['name'] }}`,
                                `{{ $city['ibge_code'] }}`,
                                `{{ $city['schools_count'] }}`,

                            ],
                        @endforeach
                    ]
                });
            });
        </script>
    @endsection
</x-app-layout>
