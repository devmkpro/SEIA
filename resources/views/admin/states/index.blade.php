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
                    "data": [
                            @foreach ($states as $state)
                                [
                                    `{{$state['name']}}`,
                                    `{{$state['ibge_code']}}`,
                                    `{{$state['schools_count']}}`,

                                ],
                            @endforeach
                        ],
                });
            });

        </script>
    @endsection
</x-app-layout>
