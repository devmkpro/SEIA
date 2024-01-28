<x-app-layout>

    @include('components.warnings-panel')
    @include('components.messages-erros')
    <div class="notification">
        <div class="card container-fluid ">
            <div class="d-flex align-items-start ">
                <select class="form-select mb-3" id="nav-select">
                    <option value="v-pills-home"> Todas</option>
                    <option value="v-pills-read">Lidas</option>
                    <option value="v-pills-unread">Não lidas</option>
                    <option value="v-pills-invitationToSchools">Convite escolares</option>
                    <option value="v-pills-system">Sistema</option>
                </select>
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link text-dark-seia active" id="v-pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                        aria-selected="true">
                        <i class="ph ph-tray"></i>Todas
                    </button>
                    <button class="nav-link text-dark-seia" id="v-pills-read-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-read" type="button" role="tab" aria-controls="v-pills-read"
                        aria-selected="false">
                        <i class="ph ph-check"></i>Lidas
                    </button>
                    <button class="nav-link text-dark-seia" id="v-pills-unread-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-unread" type="button" role="tab" aria-controls="v-pills-unread"
                        aria-selected="false">
                        <i class="ph ph-x"></i> Não lidas
                    </button>
                    <div class="nav-link text-dark-seia text-dark-seia menu-title">
                        Filtros
                    </div>
                  
                    <button class="nav-link text-dark-seia" id="v-pills-invitationToSchools-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-invitationToSchools" type="button" role="tab"
                        aria-controls="v-pills-invitationToSchools" aria-selected="false">
                        <i class="ph ph-bank"></i> Convite escolares
                    </button>
                    <button class="nav-link text-dark-seia" id="v-pills-system-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-system" type="button" role="tab" aria-controls="v-pills-system"
                        aria-selected="false">
                        <i class="ph ph-browser"></i> Sistema
                    </button>
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                        aria-labelledby="v-pills-home-tab" tabindex="0">
                        @if ($notifications->count() > 0)
                            @foreach ($notifications as $notification)
                                <x-show-notifications :notification="$notification" />
                            @endforeach
                        @else
                            <div class="d-flex justify-content-center py-5">
                                <span class="text-center text-dark-seia">
                                    Nenhuma notificação
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="v-pills-read" role="tabpanel" aria-labelledby="v-pills-read-tab"
                        tabindex="0">
                        @if ($notifications->where('read', 1)->count() > 0)
                            @foreach ($notifications->where('read', 1) as $notification)
                                <x-show-notifications :notification="$notification" />
                            @endforeach
                        @else
                            <div class="d-flex justify-content-center py-5">
                                <span class="text-center text-dark-seia">
                                    Nenhuma notificação
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="v-pills-unread" role="tabpanel" aria-labelledby="v-pills-unread-tab"
                        tabindex="0">
                        @if ($notifications->where('read', 0)->count() > 0)
                            @foreach ($notifications->where('read', 0) as $notification)
                                <x-show-notifications :notification="$notification" />
                            @endforeach
                        @else
                            <div class="d-flex justify-content-center py-5">
                                <span class="text-center text-dark-seia">
                                    Nenhuma notificação
                                </span>
                            </div>
                        @endif
                    </div>
                 
                    <div class="tab-pane fade" id="v-pills-invitationToSchools" role="tabpanel"
                        aria-labelledby="v-pills-invitationToSchools-tab" tabindex="0">
                        @if ($notifications->where('type', 'request')->count() > 0)
                            @foreach ($notifications->where('type', 'request') as $notification)
                                <x-show-notifications :notification="$notification" />
                            @endforeach
                        @else
                            <div class="d-flex justify-content-center py-5">
                                <span class="text-center text-dark-seia">
                                    Nenhuma notificação
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="v-pills-system" role="tabpanel"
                        aria-labelledby="v-pills-system-tab" tabindex="0">
                        @if ($notifications->where('type', 'warning')->count() > 0)
                            @foreach ($notifications->where('type', 'warning') as $notification)
                                <x-show-notifications :notification="$notification" />
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
