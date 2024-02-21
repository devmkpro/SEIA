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
                <x-grid-datatables identifier="schoolsTable" :columns="['Cód', 'Nome', 'Email', 'Bairro', 'Cidade', 'Estado', 'Opções']"/>
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
                    "data": [
                        @foreach ($schools as $school)
                            [
                                '{{ $school["code"] }}',
                                '{{ $school["name"] }}',
                                '{{ $school["email"] }}',
                                '{{ $school["district"] }}',
                                '{{ $school["city"] }}',
                                '{{ $school["state"] }}',
                                `
                                <form action="{{ route('manage.set-school-home') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="school" value="{{ $school['code'] }}">
                                    <button type="submit" class="btn btn-seia-oceanblue btn-sm">Gerenciar</button>
                                </form> `,	
                            ],
                        @endforeach
                    ],
                });
            });

        </script>
    @endsection
</x-app-layout>
