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
                @can('create-any-class')
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-seia-oceanblue" data-bs-toggle="modal"
                                data-bs-target="#addClass">
                                Adicionar Turma
                            </button>
                        </div>
                    </div>
                @endcan
                <x-grid-datatables identifier="classesTable" :columns="['Código', 'Nome', 'Email', 'Status', 'Turno', 'Ações']" />
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#classesTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                    },
                    "ajax": {
                        "url": "{{ route('manage.classes.index') }}",
                        "type": "GET",
                        "dataSrc": ""
                    },
                    "columns": [{
                            "data": "code",
                        },
                        {
                            "data": "name",
                        },
                        {
                            "data": "email",
                        },
                        {
                            "data": "status",
                        },
                        {
                            "data": "shift",
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return `
                                <form action="#" method="POST">
                                    @csrf
                                    <input type="hidden" name="school" value="#">
                                    <button type="submit" class="btn btn-seia-oceanblue btn-sm">Gerenciar</button>
                                </form> `;
                            }
                        }
                    ]
                });
            });
        </script>
    @endsection
</x-app-layout>
