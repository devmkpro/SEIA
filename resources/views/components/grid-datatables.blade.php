<div class="row gap-1 justify-content-between mb-2">
    @isset($btnRoute)
        <div class="col-md-5">
            <a href="{{ $btnRoute }}"
                class="btn btn-seia-jeans d-flex justify-content-center align-items-center gap-1 w-50">
                <i class="ph ph-arrow-left"></i>
                {{ $btnBack }}
            </a>
        </div>
    @endisset
    {{ $btns ?? '' }}
</div>
<div class="table-responsive text-dark-seia">
    <table class=" table w-100 table-striped table-hover my-2 " id="{{ $identifier }}">
        <thead>
            <tr class="text-dark-seia">
                @foreach ($columns as $column)
                    <th class="text-dark-seia">{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
