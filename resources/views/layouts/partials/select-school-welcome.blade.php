@include('components.messages-erros')
@php
    $schools = Auth::user()->schools;
@endphp
<div class="col-sm-12 text-dark-seia select-school">
    <div class="card">
        <div class="title text-center fs-5 py-4 text-seia-darkblue">
            Para começar, selecione a escola que você está vinculado(a).
        </div>
        <div class="card-body  justify-content-center align-items-center">
            <form action="{{route('set-school-home')}}" method="POST">
                @csrf
                @method('POST')

                <div class="d-flex">
                    <select name="school" id="school" class="form-select">
                        <option value="">Selecione a escola</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->code }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
    
                    <button type="submit" class="btn btn-seia-oceanblue">Selecionar</button>
                </div>
            </form>

        </div>

        <div class="card-footer text-center">
            <small class="fw-bold">Não encontrou a escola? <a href="#">Clique aqui</a></small>
        </div>
    </div>
</div>