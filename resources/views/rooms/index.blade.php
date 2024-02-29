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
                @schoolPermission('create-any-room', optional($school_home)->uuid)
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-seia-oceanblue" data-bs-toggle="modal"
                                data-bs-target="#addRoom">
                                Adicionar Sala
                            </button>
                        </div>
                    </div>
                @endschoolPermission
                <x-grid-datatables identifier="addRoomTable" :columns="['Cód', 'Nome', 'Descrição', 'Ações']" />
            </div>
        </div>
    </div>




    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#addRoomTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                    },

                    "data": [
                        @foreach ($rooms as $room)
                            [
                                '{{ $room['code'] }}',
                                '{{ $room['name'] }}',
                                '{{ $room['description'] }}',
                                `
                                <div class="d-flex justify-content-center gap-2">
                                    @schoolPermission('update-any-room', optional($school_home)->uuid)
                                       
                                        <a href="#" class="btn btn-seia-oceanblue btn-sm" >
                                        Gerenciar
                                </a> 
                                    @endschoolPermission
                                </div>
                                `,
                            ],
                        @endforeach
                    ],
                });
            });
        </script>
    @endsection
</x-app-layout>
