<x-app-layout>
    @include('components.warnings-panel')
    @include('components.messages-erros')
    @section('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    @endsection
    <x-global-manage-layout>
        @section('title-header-page', 'do professor')
        @section('title-description-page')
            Cod.: <span class="fw-bolder text-dark-seia">{{ $user->username }}</span>
            Nome: <span class="fw-bolder text-dark-seia">{{ $user->name }}</span>
            Email: <span class="fw-bolder text-dark-seia">
                <a href="mailto:{{ $user->email }}">
                    {{ $user->email }}
                </a></span>
            Celular: <span class="fw-bolder text-dark-seia">{{ $user->phone }}</span>
            CH Semanal: <span class="fw-bolder text-dark-seia">{{ $teacherSchool->weekly_workload }}</span>

            <p class="mb-4">
                Qtd. Disciplinas Lecionadas: <span
                    class="fw-bolder text-dark-seia">{{ $teacherSchool->teacherSubjects ? $teacherSchool->teacherSubjects->subjects->count() : 0 }}</span>

            </p>

        @endsection
        @section('btns-header-page')

        @endsection
        @section('alerts')
            @if ($alerts)
                @foreach ($alerts as $alert)
                    <div class="d-flex align-items-center mb-2 text-dark-seia">
                        @if ($alert['type'] == 'warning')
                            <i class="ph ph-warning-circle text-seia-ambar me-2" style="font-size: 1.3rem"></i>
                        @elseif ($alert['type'] == 'danger')
                            <i class="ph ph-warning text-seia-red me-2" style="font-size: 1.3rem"></i>
                        @endif
                        <span class="fw-bolder">{{ $alert['message'] }}</span>
                    </div>
                @endforeach
            @else
                Nenhum aviso para exibir.
            @endif
        @endsection
        @section('actions')
            @schoolPermission('manage-subjects', optional($school_home)->uuid)
                <div class="row row-cols-md-3 row-cols-sm-1 justify-content-center gap-3 gap-y-2">
                    <a data-bs-toggle="modal" data-bs-target="#changeSubjectsModal"
                        class="btn btn-group btn-group-sm align-items-center d-flex justify-content-center btn-seia-green">
                        Disciplinas
                    </a>
                </div>
            @endschoolPermission
        @endsection
        @section('modals')
            @schoolPermission('manage-subjects', optional($school_home)->uuid)
                <x-modal titleModal="Gerenciar disciplinas" idModal="changeSubjectsModal" identifier="changeSubjectsModal"
                    id="changeSubjectsModal">
                    <div class="me-3 ms-3 mt-2">
                        <form action="#" method="POST" id="changeCurriculumForm">
                            <x-grid-datatables identifier="teachersSubjectsTable" :columns="['Cód.', 'Nome', 'Ch Semanal', 'Ações']">

                            </x-grid-datatables>
                    </div>
                </x-modal>
                </form>
            @endschoolPermission
            @schoolPermission('update-any-teacher', optional($school_home)->uuid)
                <x-modal titleModal="" idModal="modifySubjectModal" identifier="modifySubjectModal" id="modifySubjectModal">
                    <div class="me-3 ms-3 mt-2">
                        <form action="{{route('manage.classes.teachers.subjects', $class->code)}}" method="POST" id="modifySubjectForm">
                            @csrf
                            <input type="hidden" name="teacher" value="{{ $user->username }}">
                            <input type="hidden" name="subject" value="">
                    </div>
                </x-modal>
                </form>
            @endschoolPermission
        @endsection
    </x-global-manage-layout>


    @section('scripts')
        @schoolPermission('manage-subjects', optional($school_home)->uuid)
            <script>
                $(document).ready(function() {
                    $('#teachersSubjectsTable').DataTable({
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                        },
                        "ajax": {
                            "url": "{{ route('manage.classes.subjects.get', ['class' => $class->code, 'teacherUsername' => $user->username]) }}",
                            "type": "GET",
                            "dataSrc": ""
                        },
                        "columns": [{
                                "data": "code"
                            },
                            {
                                "data": "name"
                            },
                            {
                                "data": "ch_week"
                            },
                            {
                                "data": "isTeacher",
                                "render": function(data, type, row) {
                                    if (data == true) {
                                        return `<a href="#" class="btn btn-sm btn-seia-red" data-bs-toggle="modal" data-bs-target="#modifySubjectModal" data-bs-code="${row.code}" data-bs-name="${row.name}" onclick="mostrarModalDisciplina('remove', '${row.code}', '${row.name}')">Remover</a>`;
                                    } else {
                                        return `<a href="#" class="btn btn-sm btn-seia-green" 
                                        data-bs-toggle="modal" data-bs-target="#modifySubjectModal"
                                        data-bs-code="${row.code}" data-bs-name="${row.name}" 
                                        onclick="mostrarModalDisciplina('add', '${row.code}', '${row.name}')">Adicionar</a>`;
                                    }
                                }
                            }
                        ],
                    });
                });

                function mostrarModalDisciplina(action, code, name) {
                    
                    $(`#modifySubjectModal .body-modal`).empty();
                    const modalTitle = action === 'add' ? `Vincular disciplina ao professor(a): {{ $user->name }}` :
                        `Remover disciplina do professor(a): {{ $user->name }}`;


                    const modalBody = `<div class="row mb-3">
                    <div class="col-12">
                      O sistema irá ${action === 'add' ? 'vincular' : 'desvincular'} a disciplina <span class="fw-bolder">${name}</span> a(o) professor(a) <span class="fw-bolder">{{ $user->name }}.</span>  <p> Clique em salvar para prosseguir.
                    </div>
                  </div>`;

                    $(`#modifySubjectModal`).modal('show');
                    $(`#modifySubjectModal .modal-title`).text(modalTitle);
                    $(`#modifySubjectForm`).append(modalBody);
                    $(`#modifySubjectForm input[name="subject"]`).val(code);
                    if (action == 'remove') {
                        $(`#modifySubjectForm`).append(`<input type="hidden" name="_method" value="DELETE">`);
                    }



                    action == 'remove' ?? $(`#modifySubjectForm`).append(`
                  <small class="text-danger"> Isso não afetará as notas já lançadas pelo(a) professor(a) para os alunos.</small>
                  `);
                }
            </script>
        @endschoolPermission
    @endsection
</x-app-layout>
