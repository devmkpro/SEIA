<x-app-layout>
    @include('components.warnings-panel')
    @include('components.messages-erros')

    @section('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    @endsection



    <div class="row">
        <div class="card">
            @can('create-any-school-year')
                <div class="col-md-12">
                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#addSchoolYear">
                            Novo Período Letivo
                        </button>
                    </div>
                </div>
            @endcan
            <x-grid-datatables identifier="schoolYearTable" :columns="['Nome', 'Início', 'Final', 'Status', 'Ações']" />
        </div>
    </div>
    </div>

    @can('create-any-school-year')
        <x-modal titleModal="Novo Periodo Letivo" identifier="addSchoolYear" id="addSchoolYear">
            <form action="{{ route('manage.school-years.store') }}" method="POST" id="addSchoolYearForm">
                @csrf
                @method('POST')

                <div class="row ms-2 me-2">
                    <div class="col-12 mt-3 mb-2">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ex. 2024"
                            value="{{ old('name') }}" required>
                    </div>

                    <div class="col-12 mt-3 mb-2">
                        <label for="start_date" class="form-label">Data de Início</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            placeholder="Data de Início" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="col-12 mt-3 mb-2">
                        <label for="end_date" class="form-label">Data de Término</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            placeholder="Data de Término" value="{{ old('end_date') }}" required>
                    </div>
                    <div class="col-12 mt-3 mb-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" aria-label="Default select example" id="status" name="status"
                            value="{{ old('status') }}">
                            @if (!$schoolsyears->where('active', 1)->count() > 0)
                                <option value="1">Ativo</option>
                                <option value="0" selected>Inativo</option>
                            @else
                                <option value="0">Inativo</option>
                            @endif
                        </select>
                        <small class="form-text text-muted">Caso já exista um período letivo ativo, o novo período letivo
                            será criado como inativo.</small>
                    </div>
                </div>

        </x-modal>
        </form>
    @endcan

    @can('update-any-school-year')
        <x-modal titleModal="Editar Periodo Letivo" identifier="editSchoolYear" id="editSchoolYear">
            <form action="" method="POST" id="editSchoolYearForm">
                @csrf
                @method('PUT')

                <div class="row ms-2 me-2">
                    <div class="col-12 mt-3 mb-2">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ex. 2024"
                            value="" required>
                    </div>

                    <div class="col-12 mt-3 mb-2">
                        <label for="start_date" class="form-label">Data de Início</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            placeholder="Data de Início" value="" min="" required>
                    </div>

                    <div class="col-12 mt-3 mb-2">
                        <label for="end_date" class="form-label">Data de Término</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            placeholder="Data de Término" value="" required>
                    </div>
                    <div class="col-12 mt-3 mb-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" aria-label="Default select example" id="status" name="status"
                            value="">
                                <option value="1">Ativo</option>
                                <option value="0" selected>Inativo</option>
                        </select>
                        <small class="form-text text-muted">Caso já exista um período letivo ativo, o novo período letivo
                            será criado como inativo.</small>
                    </div>
                </div>

        </x-modal>
        </form>
    @endcan

    @section('scripts')
        <script>
            function showSchoolYear(uuid) {
                $.ajax({
                    url: "{{ route('manage.school-years.show', '') }}" + "/" + uuid,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#editSchoolYearForm').attr('action', "{{ route('manage.school-years.update') }}");
                        $('#editSchoolYearForm #name').val(data.name);
                        $('#editSchoolYearForm #start_date').val(data.start_date);
                        $('#editSchoolYearForm #end_date').val(data.end_date);
                        $('#editSchoolYearForm #status').val(data.status);
                        $('#editSchoolYearForm input[name=schoolYear]').remove();
                        $('#editSchoolYearForm').append('<input type="hidden" name="schoolYear" value="' + data.uuid +
                            '">');
                    } , error: function(data) {
                        location.reload();
                    }


                });
            }
            $(document).ready(function() {
                $('#schoolYearTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                    },
                    "ajax": {
                        "url": "{{ route('manage.school-years.index') }}",
                        "type": "GET",
                        "dataSrc": ""
                    },
                    "columns": [{
                            "data": "name",
                        },
                        {
                            "data": "start_date",
                        },
                        {
                            "data": "end_date",
                        },
                        {
                            "data": "status",
                        },
                        {
                            "data": "uuid",
                            "render": function(data, type, row, meta) {
                                return `<div class="">
                                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editSchoolYear" onclick="showSchoolYear('${data}')">
                                                <i class="ph-pencil-fill"></i>
                                            </button>
                                        </div>`;

                            }
                        }

                    ]
                });



            });
        </script>
    @endsection
</x-app-layout>
