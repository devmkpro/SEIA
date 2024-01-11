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
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('manage.classes.edit', ['code' => $class->code]) }}"
                            class="btn btn-seia-jeans">
                            Voltar para turma</a>
                    </div>

                    @schoolPermission('create-any-teacher', optional($school_home)->uuid)
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-seia-oceanblue" data-bs-toggle="modal"
                                    data-bs-target="#addTeacherModal">
                                    Novo Professor
                                </button>
                            </div>
                        </div>
                    @endschoolPermission
                </div>


                <x-grid-datatables identifier="teachersTable" :columns="['Cód.', 'Nome', 'Disciplinas', 'E-mail', 'Telefone', 'Ações']" />
            </div>
        </div>
    </div>

    @schoolPermission('create-any-teacher', optional($school_home)->uuid)
        <x-modal titleModal="Adicionar novo Professor" identifier="addTeacherModal" id="addTeacherTable">
            <div class="me-3 ms-3 mt-2">

                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>
                        <strong>Atenção!</strong>
                        Se o professor que deseja adicionar já estiver cadastrado no sistema, basta pesquisar pelo seu
                        e-mail
                        ou código.
                    </span>
                </div>

                <div class="mb-3">
                    <label for="teacherEmail" class="form-label">Pesquisar por e-mail do professor:</label>
                    <input type="text" class="form-control" id="teacherEmail" name="teacherEmail"
                        placeholder="Digite o e-mail do professor">
                </div>

                <div class="col-md-12">
                    <button type="button" class="btn btn-seia-oceanblue" onclick="searchTeacher()">Pesquisar</button>
                </div>


                <div id="teacherCardsContainer" class="row mt-3"></div>

                <hr>
                <h4 class="mt-3 text-center">Ou cadastre o professor</h4>

                <div class="row mt-3 d-flex justify-content-center align-items-center">
                    <div class="col-md-2">
                        <a href="#" class="btn btn-seia-oceanblue">
                            <i class="ph ph-user-plus-bold fs-5"></i>
                            Cadastrar</a>
                    </div>
                </div>


            </div>
        </x-modal>

        <script>
            function createTeacherCard(teacher) {
                var cardHtml = `
            <div class="container">
        <div class="card mb-3 me-3 ">
            <div class="card-body">
                <h5 class="card-title">
                    ${teacher.name}</h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    Código:
                    ${teacher.username}</h6>
                <p class="card-text">
                    <strong>E-mail:</strong> ${teacher.email}<br>
                    <strong>Telefone:</strong> ${teacher.phone}
                </p>
                <div class="row mt-3">
                    <form action="{{route('manage.classes.teachers.invite', $class->code  )}}" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="username" value="${teacher.username}">
                        <input type="hidden" name="role" value="teacher">
                    <button type="submit" class="btn btn-seia-yellow">Solicitar vinculo</button>
                    </div>
            </div>
        </div>
    </div>
</form>

    `;

                return cardHtml;
            }


            function searchTeacher() {
                var query = $('#teacherEmail').val();
                $.ajax({
                    url: "{{ route('manage.classes.teachers.get', ['code' => $class->code]) }}",
                    type: "GET",
                    data: {
                        'search': query
                    },
                    success: function(data) {
                        if (data.length > 0) {
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
                        "url": "{{ route('manage.classes.teachers.get', ['code' => $class->code]) }}",
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
                                   
                                `;
                            }
                        }
                    ]
                });
            });


            // Restante do seu script DataTables
        </script>
    @endsection
</x-app-layout>
