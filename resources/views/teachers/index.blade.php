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
                <x-grid-datatables identifier="teachersTable" :columns="['Cód.', 'Nome', 'Disciplinas', 'E-mail', 'Telefone', 'Ações']" 
                :btnRoute="route('manage.classes.edit', ['class' => $class->code])" btnBack="Voltar para turma">
                    <x-slot:btns>
                        @schoolPermission('create-any-teacher', optional($school_home)->uuid)
                            <div class="col-md-6">
                                <div class="d-flex justify-content-end mb-3 gap-1">
                                    <a href="{{ route('manage.classes.teachers.create', $class->code) }}"
                                        class="btn btn-seia-oceanblue d-flex justify-content-center align-items-center gap-1">
                                        <i class="ph ph-user-plus-bold fs-5"></i>
                                        Cadastrar novo professor
                                    </a>
                                    <button type="button"
                                        class="btn btn-seia-green d-flex justify-content-center align-items-center gap-1"
                                        data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                                        <i class="ph ph-plus fs-5"></i>
                                        Adicionar professor existente
                                    </button>
                                </div>
                            </div>
                        @endschoolPermission
                    </x-slot:btns>
                </x-grid-datatables>
            </div>

        </div>
    </div>
    </div>
    @schoolPermission('create-any-teacher', optional($school_home)->uuid)
        <x-modal titleModal="Adicionar novo Professor" identifier="addTeacherModal" id="addTeacherTable">
            <div class="me-3 ms-3 mt-2">
                <div class="alert alert-warning text-center" role="alert">
                    <i class="ph ph-warning"></i>
                    <span>
                        <span class="fw-semibold">Atenção!</span>
                        Se o professor que deseja adicionar já estiver cadastrado no sistema, basta pesquisar pelo seu
                        e-mail
                        ou código.
                    </span>
                </div>

                <label for="teacherEmail" class="form-label">Pesquise por e-mail/código ou
                    <a href="{{ route('manage.classes.teachers.create', $class->code) }}"
                        class="text-seia-oceanblue">cadastre
                        um novo professor</a>
                </label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Digite o e-mail ou código do professor"
                        id="teacherEmail" name="teacherEmail" aria-label="Recipient's username"
                        aria-describedby="button-addon2" autocomplete="true" autofocus>
                    <button class="btn btn-seia-oceanblue" type="button" id="button-addon2"
                        onclick="searchTeacher()">Pesquisar</button>
                </div>


                <div id="teacherCardsContainer" class="row mt-3" style="min-height: 150px">

                </div>

                <hr>
            </div>
        </x-modal>

        <script>
            function createTeacherCard(teacher) {
                var cardHtml = `
                <div class="container">
                    <div class="row">
                        <div class="card mb-3 me-3 text-black  seia-shadow col-md-6 col-sm-12">
                            <div class="card-body d-flex  flex-column justify-content-center align-items-center">
                                <div class="d-flex">

                                        <div alt="Foto de perfil ausente" class="rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                                            <i class="ph ph-user-circle fs-1 text-black"></i>
                                        </div>
                                        

                                    <div class="d-block">
                                        <h5 class="card-title">
                                            ${teacher.name}</h5>
                                        <h6 class="card-subtitle  text-muted">
                                            Código:
                                            ${teacher.username}</h6>
                                    </div>
                                </div>
                                <p class="card-text d-flex flex-column">
                                    <div>
                                        <span class="fw-semibold">E-mail:</span> ${teacher.email}
                                    </div>
                                    <div>
                                        <span class="fw-semibold">Telefone:</span> ${teacher.phone}
                                    </div>
                                </p>
                                <div class="mt-1 d-flex justify-content-center align-items-center">
                                    <form action="{{ route('manage.classes.teachers.invite', $class->code) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="username" value="${teacher.username}">
                                        <input type="hidden" name="role" value="teacher">
                                        <button type="submit" class="btn btn-seia-green">Solicitar vinculo</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

                return cardHtml;
            }


            function searchTeacher() {
                var query = $('#teacherEmail').val();
                $.ajax({
                    url: "{{ route('manage.classes.teachers.get', ['class' => $class->code]) }}",
                    type: "GET",
                    data: {
                        'search': query
                    },
                    success: function(data) {
                        if (data.length == 0) {
                            $('#teacherCardsContainer').empty();
                            $('#teacherCardsContainer').append(`
                                <div class="container">
                                    <div class="alert alert-info" role="alert">
                                        <i class="ph ph-warning"></i>
                                        <span>
                                            Nenhum professor encontrado com o e-mail ou codigo informado se acredita que este professor não está cadastrado no sistema, <a href="{{ route('manage.classes.teachers.create', $class->code) }}" class="text-seia-oceanblue">clique aqui</a> para cadastrar um novo professor.
                                        </span>
                                    </div>
                                </div>
                            `);
                        } else {
                            $('#teacherCardsContainer').empty();

                            data.forEach(function(teacher) {
                                var teacherCard = createTeacherCard(teacher);
                                $('#teacherCardsContainer').append(teacherCard);
                            });
                        }
                    },

                })
            }
        </script>
    @endschoolPermission


    @section('scripts')
        <script>
            $(document).ready(function() {

                $('#teacherEmail').on('input', function() {
                    $('#teacherCardsContainer').empty();
                });

                $('#teachersTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                    },
                    "ajax": {
                        "url": "{{ route('manage.classes.teachers.get', ['class' => $class->code]) }}",
                        "type": "GET",
                        "dataSrc": ""
                    },
                    "columns": [{
                            "data": "username"
                        },
                        {
                            "data": "name"
                        },
                        {
                            "data": "subjects"
                        },
                        {
                            "data": "email"
                        },
                        {
                            "data": "phone"
                        },
                        {
                            "render": function(data, type, row) {
                                return `
                                <a href="/gerenciar/turmas/{{$class->code}}/professores/${row.username}/editar"
                                    class="btn btn-seia-oceanblue btn-sm">
                                    Gerenciar
                                </a>`
                            }
                        }
                    ]
                });
            });


            // Restante do seu script DataTables
        </script>
    @endsection
</x-app-layout>
