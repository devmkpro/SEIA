<div class="table-responsive text-dark-seia">
    <table class=" table w-100 table-striped table-hover my-2" id="{{ $identifier }}">
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

