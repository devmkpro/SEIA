@php
    $modalId = uniqid('modal_');
@endphp
@props(['notification'])
<div class="accordion accordion-flush" id="accordionFlushExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse"
                data-bs-target="#{{ $modalId }}" aria-expanded="false" aria-controls="flush-collapseOne">
                <div class="d-flex flex-column align-items-start text-dark-seia">
                    <div class="d-flex justify-content-center align-items-center gap-1 notification">
                        <i class="{{ $notification->icon }} {{ $notification->type }} p-2 text-white rounded-circle">
                        </i> {{ $notification->title }}
                    </div>
                    <div class="text-muted " style="font-size: 12px; margin-left: 3em">
                        {{ $notification->created_at->format('d/m/Y - H:i') }}
                    </div>
                </div>
            </button>
        </h2>
        <div id="{{ $modalId }}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body text-dark-seia">
                {{ $notification->body }}
                
                @if ($notification->type == 'request')
                    @if ($notification->request->status == 'accepted')
                        <div class="d-flex mt-2">
                            <span class="text-seia-green fw-semibold mt-1">
                                Você já aceitou este convite
                            </span>
                        </div>
                    @elseif ($notification->request->status == 'rejected')
                        <div class="d-flex mt-2">
                            <span class="text-seia-red fw-semibold mt-1">
                                Você recusou este convite
                            </span>
                        </div>
                    @elseif ($notification->request->status == 'pending')
                        <div class="d-flex mt-2">
                            <form action="{{ route('manage.invite.acceptOrReject') }}" method="POST">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="school_request" value="{{ $notification->request_uuid }}">
                                <input type="hidden" name="notification" value="{{ $notification->code }}">
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit"
                                    class="btn btn-seia-greenligth btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold me-2">
                                    <i class="ph-check"></i>
                                    Aceitar
                                </button>
                            </form>
                            <form action="{{ route('manage.invite.acceptOrReject') }}" method="POST">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="notification" value="{{ $notification->code }}">
                                <input type="hidden" name="school_request" value="{{ $notification->request_uuid }}">
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit"
                                    class="btn btn-seia-red btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                    <i class="ph-x"></i> Recusar
                                </button>
                            </form>
                            @if (!$notification->read)
                                <form action="{{ route('notification.read') }}" method="POST"
                                    class="align-self-end ms-auto">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="notification" value="{{ $notification->code }}">
                                    <button type="submit"
                                        class="btn btn-seia-oceanblue btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                        <i class="ph-check"></i>Lida
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<div class="accordion-item"></div>
