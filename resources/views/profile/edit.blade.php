<x-app-layout>
    @include('components.warnings-panel')
    @include('components.messages-erros')

    <div class="row">
        <div class="col-sm-12">
            <div class="card p-3 mt-1">

                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-outline-primary " type="button" aria-expanded="false"
                            aria-controls="dadosPessoais" data-bs-toggle="modal" data-bs-target="#dadosPessoais">
                            Editar Perfil
                        </button>
                    </div>
                </div>

                <div class="dados-pessoais row">
                    <div class="title col-12 mb-3">
                        Dados pessoais
                    </div>
                    <div class="col-md-2 col-sm-12 d-flex justify-content-center align-items-center">
                        <img class="img-profile img-fluid w-100"
                            src="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675701885/assets/seia/img/profiles/default/undraw_profile_zc6h9i.svg"
                            alt="Perfil=img">
                    </div>
                    @include('profile.partials.update-user-data-form')
                </div>

                <div class="filiacao row">
                    <div class="title col-12 my-3">
                        Filiação
                    </div>
                    @include('profile.partials.update-user-filiation-form')
                </div>

                <div class="dados-endereco row">
                    <div class="title col-12 my-3">
                        Dados de endereço
                    </div>
                    @include('profile.partials.update-user-address-form')
                </div>


                <div class="responsaval row">
                    <div class="title col-12 my-3">
                        Responsável
                    </div>
                    @include('profile.partials.update-user-responsible-form')
                </div>

                <div class="observacao row">
                    <label for="observacao" class="title col-12 my-3">
                        Observação:
                    </label>
                    <textarea name="observacao" id="observacao" cols="30" rows="5" disabled>{{ $user->datauser->observation ?? ''}}
                    </textarea>
                </div>

                <x-modal titleModal="Editar dados pessoais" identifier="dadosPessoais" id="dadosPessoais">
                    <div class="dados-pessoais ms-2 me-2 row">

                        <div class="col-md-6">
                            <form action="{{ route('profile.update') }}" method="post">
                                @csrf
                                @method('put')

                                <div class="d-flex justify-content-center align-items-baseline gap-1">
                                    <label for="phone">Celular: </label>
                                    <input type="text" name="phone" id="phone" value="{{ $user->phone }}"
                                        class="w-100">
                                </div>
                        </div>

                        <div class="col-md-6 ">
                            <div class="d-flex justify-content-center align-items-baseline gap-1">
                                <label for="email">Email: </label>
                                <input type="text" name="email" id="email" value="{{ $user->email }}" class="w-100">

                            </div>
                        </div>



                    </div>
                </x-modal>
            </form>

            </div>
        </div>
    </div>

</x-app-layout>
