<x-app-layout>
   
    @include('components.warnings-panel')
    @include('components.messages-erros')
    @php
        $notifications = \App\Models\Notifications::where('user_uuid', auth()->user()->uuid)->get();
    @endphp
    <div class="notification">
        <div class="card container-fluid ">
            <div class="d-flex align-items-start ">
                <select class="form-select mb-3" id="nav-select">
                    <option value="v-pills-home"> Todas</option>
                    <option value="v-pills-read">Lidas</option>
                    <option value="v-pills-unread">Não lidas</option>
                    <option value="v-pills-invitationToClasses">Convites para turmas</option>
                    <option value="v-pills-invitationToSchools">Convite para escolas</option>
                    <option value="v-pills-system">Sistema</option>
                </select>
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <button class="nav-link text-dark-seia active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
                    <i class="ph ph-tray"></i>Todas
                  </button>
                  <button class="nav-link text-dark-seia" id="v-pills-read-tab" data-bs-toggle="pill" data-bs-target="#v-pills-read" type="button" role="tab" aria-controls="v-pills-read" aria-selected="false">
                    <i class="ph ph-check"></i>Lidas
                  </button>
                  <button class="nav-link text-dark-seia" id="v-pills-unread-tab" data-bs-toggle="pill" data-bs-target="#v-pills-unread" type="button" role="tab" aria-controls="v-pills-unread" aria-selected="false">
                    <i class="ph ph-x"></i> Não lidas
                  </button>
                    <div class="nav-link text-dark-seia text-dark-seia menu-title">
                        Filtros
                    </div>
                  <button class="nav-link text-dark-seia" id="v-pills-invitationToClasses-tab" data-bs-toggle="pill" data-bs-target="#v-pills-invitationToClasses" type="button" role="tab" aria-controls="v-pills-invitationToClasses" aria-selected="false">
                    <i class="ph ph-chalkboard-teacher"></i> Convites para turmas
                  </button>
                  <button class="nav-link text-dark-seia" id="v-pills-invitationToSchools-tab" data-bs-toggle="pill" data-bs-target="#v-pills-invitationToSchools" type="button" role="tab" aria-controls="v-pills-invitationToSchools" aria-selected="false">
                    <i class="ph ph-bank"></i> Convite para escolas
                  </button>
                  <button class="nav-link text-dark-seia" id="v-pills-system-tab" data-bs-toggle="pill" data-bs-target="#v-pills-system" type="button" role="tab" aria-controls="v-pills-system" aria-selected="false">
                    <i class="ph ph-browser"></i> Sistema
                  </button>
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                    @if ($notifications->count() > 0)
                        @foreach ($notifications as $notification)
                            @php
                                $modalId = uniqid('modal_');
                            @endphp
                            <div class="accordion accordion-flush"
                                id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button
                                            class="accordion-button collapsed"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#{{ $modalId }}"
                                            aria-expanded="false"
                                            aria-controls="flush-collapseOne">
                                            <div
                                                class="d-flex flex-column align-items-start text-dark-seia">
                                                <div class="d-flex gap-2">
                                                    <i class="{{ $notification->icon }} {{ $notification->type }} p-2 text-white rounded-circle">
                                                    </i> {{ $notification->title }}
                                                </div>
                                                <div class="text-muted "
                                                    style="font-size: 12px; margin-left: 3.3em">
                                                    {{ $notification->created_at->format('d/m/Y - H:i') }}
                                                </div>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="{{ $modalId }}"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingOne"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-dark-seia">
                                            {{ $notification->body }}
                                            
                                            @if ($notification->where('read', false))
                                                @if ($notification->type == 'request')
                                                    <div class="d-flex mt-2">
                                                        <form
                                                            action="{{ route('manage.invite.acceptOrReject') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden"
                                                                name="school_request"
                                                                value="{{ $notification->request_uuid }}">
                                                            <input type="hidden"
                                                                name="notification"
                                                                value="{{ $notification->uuid }}">
                                                            <input type="hidden"
                                                                name="status"
                                                                value="accepted">
                                                            <button type="submit"
                                                                class="btn btn-seia-greenligth btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold me-2">
                                                                <i class="ph-check"></i>
                                                                Aceitar
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ route('manage.invite.acceptOrReject') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden"
                                                                name="notification"
                                                                value="{{ $notification->uuid }}">
                                                            <input type="hidden"
                                                                name="school_request"
                                                                value="{{ $notification->request_uuid }}">
                                                            <input type="hidden"
                                                                name="status"
                                                                value="rejected">
                                                            <button type="submit"
                                                                class="btn btn-seia-red btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                                                <i class="ph-x"></i> Recusar
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="d-flex mt-2">
                                                        <button type="submit"
                                                            class="btn btn-seia-blue btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                                            <i class="ph ph-eye-slash"></i>
                                                            Marcar como não lida
                                                        </button>
                                                    </div>
                                                @endif
                                            @else
                                                @if ($notification->type == 'request')
                                                    @if ($notification->request->status == 'accepted')
                                                        <div class="d-flex mt-2">
                                                            <span
                                                                class="text-seia-green fw-semibold mt-1">
                                                                Você já aceitou este convite
                                                            </span>
                                                        </div>
                                                    @elseif ($notification->request->status == 'rejected')
                                                        <div class="d-flex mt-2">
                                                            <span
                                                                class="text-seia-red fw-semibold mt-1">
                                                                Você recusou este convite
                                                            </span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="d-flex mt-2">
                                                        <button type="submit"
                                                            class="btn btn-seia-blue btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                                            <i class="ph ph-eye-slash"></i>
                                                            Marcar como não lida
                                                        </button>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <hr>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center py-5">
                            <span class="text-center text-dark-seia">
                                Nenhuma notificação
                            </span>
                        </div>
                    @endif
                  </div>
                  <div class="tab-pane fade" id="v-pills-read" role="tabpanel" aria-labelledby="v-pills-read-tab" tabindex="0">
                    @if ($notifications->count() > 1)
                        @foreach ($notifications->where('read', 1) as $notification)
                            @php
                                $modalId = uniqid('modal_');
                            @endphp
                            <div class="accordion accordion-flush"
                                id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button
                                            class="accordion-button collapsed"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#{{ $modalId }}"
                                            aria-expanded="false"
                                            aria-controls="flush-collapseOne">
                                            <div
                                                class="d-flex flex-column align-items-start text-dark-seia">
                                                <div class="d-flex gap-2">
                                                    <i class="{{ $notification->icon }} {{ $notification->type }} p-2 text-white rounded-circle">
                                                    </i> {{ $notification->title }}
                                                </div>
                                                <div class="text-muted "
                                                    style="font-size: 12px; margin-left: 3.3em">
                                                    {{ $notification->created_at->format('d/m/Y - H:i') }}
                                                </div>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="{{ $modalId }}"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingOne"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-dark-seia">
                                            {{ $notification->body }}
                                            @if ($notification->type == 'request')
                                                @if ($notification->request->status == 'accepted')
                                                    <div class="d-flex mt-2">
                                                        <span
                                                            class="text-seia-green fw-semibold mt-1">
                                                            Você já aceitou este convite
                                                        </span>
                                                    </div>
                                                @elseif ($notification->request->status == 'rejected')
                                                    <div class="d-flex mt-2">
                                                        <span
                                                            class="text-seia-red fw-semibold mt-1">
                                                            Você recusou este convite
                                                        </span>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="d-flex mt-2">
                                                    <button type="submit"
                                                        class="btn btn-seia-blue btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                                        <i class="ph ph-eye-slash"></i>
                                                        Marcar como não lida
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <hr>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center py-5">
                            <span class="text-center text-dark-seia">
                                Nenhuma notificação
                            </span>
                        </div>
                    @endif
                  </div>
                  <div class="tab-pane fade" id="v-pills-unread" role="tabpanel" aria-labelledby="v-pills-unread-tab" tabindex="0">
                    @if ($notifications->count() > 0)
                        @foreach ($notifications->where('read', 0) as $notification)
                            @php
                                $modalId = uniqid('modal_');
                            @endphp
                            <div class="accordion accordion-flush"
                                id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button
                                            class="accordion-button collapsed"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#{{ $modalId }}"
                                            aria-expanded="false"
                                            aria-controls="flush-collapseOne">
                                            <div
                                                class="d-flex flex-column align-items-start text-dark-seia">
                                                <div class="d-flex gap-2">
                                                    <i class="{{ $notification->icon }} {{ $notification->type }} p-2 text-white rounded-circle">
                                                    </i> {{ $notification->title }}
                                                </div>
                                                <div class="text-muted "
                                                    style="font-size: 12px; margin-left: 3.3em">
                                                    {{ $notification->created_at->format('d/m/Y - H:i') }}
                                                </div>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="{{ $modalId }}"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingOne"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-dark-seia">
                                            {{ $notification->body }}
                                            
                                            @if ($notification->where('read', 0))
                                                @if ($notification->type == 'request')
                                                    <div class="d-flex mt-2">
                                                        <form
                                                            action="{{ route('manage.invite.acceptOrReject') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden"
                                                                name="school_request"
                                                                value="{{ $notification->request_uuid }}">
                                                            <input type="hidden"
                                                                name="notification"
                                                                value="{{ $notification->uuid }}">
                                                            <input type="hidden"
                                                                name="status"
                                                                value="accepted">
                                                            <button type="submit"
                                                                class="btn btn-seia-greenligth btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold me-2">
                                                                <i class="ph-check"></i>
                                                                Aceitar
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ route('manage.invite.acceptOrReject') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden"
                                                                name="notification"
                                                                value="{{ $notification->uuid }}">
                                                            <input type="hidden"
                                                                name="school_request"
                                                                value="{{ $notification->request_uuid }}">
                                                            <input type="hidden"
                                                                name="status"
                                                                value="rejected">
                                                            <button type="submit"
                                                                class="btn btn-seia-red btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                                                <i class="ph-x"></i> Recusar
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="d-flex mt-2">
                                                        <button type="submit"
                                                            class="btn btn-seia-blue btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                                            <i class="ph ph-eye-slash"></i>
                                                            Marcar como não lida
                                                        </button>
                                                    </div>
                                                @endif
                                            @else
                                                @if ($notification->type == 'request')
                                                    @if ($notification->request->status == 'accepted')
                                                        <div class="d-flex mt-2">
                                                            <span
                                                                class="text-seia-green fw-semibold mt-1">
                                                                Você já aceitou este convite
                                                            </span>
                                                        </div>
                                                    @elseif ($notification->request->status == 'rejected')
                                                        <div class="d-flex mt-2">
                                                            <span
                                                                class="text-seia-red fw-semibold mt-1">
                                                                Você recusou este convite
                                                            </span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="d-flex mt-2">
                                                        <button type="submit"
                                                            class="btn btn-seia-blue btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                                            <i class="ph ph-eye-slash"></i>
                                                            Marcar como não lida
                                                        </button>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <hr>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center py-5">
                            <span class="text-center text-dark-seia">
                                Nenhuma notificação
                            </span>
                        </div>
                    @endif
                  </div>
                  <div class="tab-pane fade" id="v-pills-invitationToClasses" role="tabpanel" aria-labelledby="v-pills-invitationToClasses-tab" tabindex="0">
                    WIP
                  </div>
                  <div class="tab-pane fade" id="v-pills-invitationToSchools" role="tabpanel" aria-labelledby="v-pills-invitationToSchools-tab" tabindex="0">
                    WIP
                  </div>
                  <div class="tab-pane fade" id="v-pills-system" role="tabpanel" aria-labelledby="v-pills-system-tab" tabindex="0">
                    @if ($notifications->count() > 0)
                        @foreach ($notifications->where('type', 'warning') as $notification)
                            @php
                                $modalId = uniqid('modal_');
                            @endphp
                            <div class="accordion accordion-flush"
                                id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button
                                            class="accordion-button collapsed"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#{{ $modalId }}"
                                            aria-expanded="false"
                                            aria-controls="flush-collapseOne">
                                            <div
                                                class="d-flex flex-column align-items-start text-dark-seia">
                                                <div class="d-flex gap-2">
                                                    <i class="{{ $notification->icon }} {{ $notification->type }} p-2 text-white rounded-circle">
                                                    </i> {{ $notification->title }}
                                                </div>
                                                <div class="text-muted "
                                                    style="font-size: 12px; margin-left: 3.3em">
                                                    {{ $notification->created_at->format('d/m/Y - H:i') }}
                                                </div>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="{{ $modalId }}"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingOne"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-dark-seia">
                                            {{ $notification->body }}
                                            
                                            @if ($notification->where('read', false))
                                                @if ($notification->type == 'request')
                                                    <div class="d-flex mt-2">
                                                        <form
                                                            action="{{ route('manage.invite.acceptOrReject') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden"
                                                                name="school_request"
                                                                value="{{ $notification->request_uuid }}">
                                                            <input type="hidden"
                                                                name="notification"
                                                                value="{{ $notification->uuid }}">
                                                            <input type="hidden"
                                                                name="status"
                                                                value="accepted">
                                                            <button type="submit"
                                                                class="btn btn-seia-greenligth btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold me-2">
                                                                <i class="ph-check"></i>
                                                                Aceitar
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ route('manage.invite.acceptOrReject') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden"
                                                                name="notification"
                                                                value="{{ $notification->uuid }}">
                                                            <input type="hidden"
                                                                name="school_request"
                                                                value="{{ $notification->request_uuid }}">
                                                            <input type="hidden"
                                                                name="status"
                                                                value="rejected">
                                                            <button type="submit"
                                                                class="btn btn-seia-red btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                                                <i class="ph-x"></i> Recusar
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="d-flex mt-2">
                                                        <button type="submit"
                                                            class="btn btn-seia-blue btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                                            <i class="ph ph-eye-slash"></i>
                                                            Marcar como não lida
                                                        </button>
                                                    </div>
                                                @endif
                                            @else
                                                @if ($notification->type == 'request')
                                                    @if ($notification->request->status == 'accepted')
                                                        <div class="d-flex mt-2">
                                                            <span
                                                                class="text-seia-green fw-semibold mt-1">
                                                                Você já aceitou este convite
                                                            </span>
                                                        </div>
                                                    @elseif ($notification->request->status == 'rejected')
                                                        <div class="d-flex mt-2">
                                                            <span
                                                                class="text-seia-red fw-semibold mt-1">
                                                                Você recusou este convite
                                                            </span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="d-flex mt-2">
                                                        <button type="submit"
                                                            class="btn btn-seia-blue btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                                            <i class="ph ph-eye-slash"></i>
                                                            Marcar como não lida
                                                        </button>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <hr>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center py-5">
                            <span class="text-center text-dark-seia">
                                Nenhuma notificação
                            </span>
                        </div>
                    @endif
                  </div>
                </div>
              </div>
        </div>
    </div>
</x-app-layout>
