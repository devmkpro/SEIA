<div class="grid-container">
    <div class="card seia-border-darkback">
        <table class="table" id="{{ $identifier }}">
            <thead>
                <tr>
                    @foreach ($columns as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
