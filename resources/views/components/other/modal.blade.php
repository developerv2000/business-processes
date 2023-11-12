@props(['title'])

<div class="modal {{ $attributes->get('class') }}">
    <div class="modal__overlay" data-click-action="hide-active-modals"></div>

    <div class="modal__inner">
        <div class="modal__box styled-box">
            {{-- Header --}}
            <div class="modal__header">
                <p class="modal__title">{{ $title }}</p>

                <button class="modal__dismiss" type="button" data-click-action="hide-active-modals">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            {{-- Body --}}
            <div class="modal__body thin-scrollbar">
                {{ $body }}
            </div>

            {{-- Footer --}}
            <div class="modal__footer">
                {{ $footer }}
            </div>
        </div>
    </div>
</div>
