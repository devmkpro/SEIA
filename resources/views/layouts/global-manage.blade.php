<div class="row">
    <div class="col-sm-12">
        <div class="mb-4 ">
            <section aria-labelledby="class-info-heading" class="seia-bg p-4 rounded seia-shadow my-3">
                <h2 id="class-info-heading" class="fs-6 fw-bold text-dark-seia mb-4">
                    Informações @yield('title-header-page')
                </h2>
                <p class="mb-2 space-y-1">
                    @yield('title-description-page')
                </p>

                @yield('btns-header-page')
            </section>
            <section aria-labelledby="alerts-heading" class="seia-bg  p-4 rounded seia-shadow my-3">
                <h2 id="alerts-heading" class="fs-6 fw-bold text-dark-seia mb-4">
                    Avisos
                </h2>
                @yield('alerts')
            </section>
            <section aria-labelledby="actions-heading" class="seia-bg  p-4 rounded seia-shadow my-3">
                <h2 id="actions-heading" class="fs-6 fw-bold text-dark-seia mb-4">
                    Ações
                </h2>
                @yield('actions')
            </section>
        </div>
    </div>
</div>
</form>
@yield('modals')

