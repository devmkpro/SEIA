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
                <x-grid-datatables identifier="schoolsTable" :columns="['Nome', 'Email', 'Bairro', 'Cidade', 'Estado', 'Opções']"/>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#schoolsTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                    },
                    "ajax": {
                        "url": "{{ route('manage.schools.index') }}",
                        "type": "GET",
                        "dataSrc": ""
                    },
                    "columns": [{
                            "data": "name",
                        },
                        {
                            "data": "email",
                        },
                        {
                            "data": "district",
                        },
                        {
                            "data": "city",
                        },
                        {
                            "data": "state",
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return `
                                <form action="{{ route('set-school-home') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="school" value="${row.uuid}">
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
