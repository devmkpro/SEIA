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
                <x-grid-datatables identifier="statesTable" :columns="['Estado', 'IBGE-CODE', 'Escolas']" />
            </div>
        </div>
    </div>

    </form>

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#statesTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                    },
                    "ajax": {
                        "url": "{{ route('manage.states.index') }}",
                        "type": "GET",
                        "dataSrc": ""
                    },
                    "columns": [{
                            "data": "name",
                        },
                        {
                            "data": "ibge_code",
                        },
                        {
                            "data": "schools_count",
                        },

                    ]
                });
            });

        </script>
    @endsection
</x-app-layout>
