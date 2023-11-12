@if ($errors->any())
    <div class="errors">
        <p class="errors__title">Ошибка! Пожалуйста, исправьте ошибки и попробуйте заново.</p>

        <ul class="errors__list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
