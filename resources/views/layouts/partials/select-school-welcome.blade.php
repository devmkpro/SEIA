@php
    $schools = Auth::user()->schools;
@endphp
<div class="col-sm-12">
    <div class="card">
        <div class="title">
            Bem vindo(a)! Para começar, selecione a escola que você está vinculado(a).
        </div>
        <div class="card-body  justify-content-center align-items-center">
            <form action="{{route('set-school-home')}}" method="POST">
                @csrf
                @method('POST')
                <div class="row justify-content-md-center">
                    <div class="col-md-6 mb-3">
                        <select name="school" id="school" class="form-select">
                            <option value="">Selecione a escola</option>
                            @foreach ($schools as $school)
                                <option value="{{ encrypt($school->uuid) }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-outline-primary">Selecionar</button>
                    </div>
                </div>
            </form>

        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                   <small>Não encontrou a escola? <a href="#">Clique aqui</a></small>
                </div>
            </div>
        </div>
    </div>
</div>