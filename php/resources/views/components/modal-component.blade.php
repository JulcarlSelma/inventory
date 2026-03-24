
@if(isset($button))
    <x-button variant="primary" data-modal-open>{{$button}}</x-button>
@endif

<div
    id="modal"
    role="dialog"
    aria-hidden="true"
    aria-modal="true"
    class="hidden inset-0 py-12 px-6 items-center justify-center z-[2000] h-full absolute"
>
    <div class="absolute inset-0 bg-back-drop" aria-description="modal overlay" data-modal-close></div>
    <div class="relative w-full max-w-[465px] mx-auto flex flex-col items-end gap-2">
        <x-button
            variant="close"
            class="rounded-[3px] w-8 h-8 p-0 cursor-pointer"
            data-modal-close
        >
            x
        </x-button>
        <div class="relative w-full h-auto z-[2] flex flex-col gap-2">
            <x-card class="rounded-none border-t-[3px] border-lapis-blue max-h-[80vh] overflow-y-auto no-scrollbar">
                <x-slot:header :class="$header->attributes['class']" :id="$header->attributes['id']">{{$header ?? ''}}</x-slot:header>
                {{$slot ?? ''}}
            </x-card>
        </div>
    </div>
</div>

@push('js')
    <script>
        (function() {
            document.querySelectorAll('[data-modal-open]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const modal = document.getElementById('modal');
                    if (!modal) return;

                    modal.classList.remove('hidden');
                    modal.classList.add('fixed');
                    document.body.classList.add('overflow-hidden');
                });
            });

            document.querySelectorAll('[data-modal-close]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const modal = btn.closest('#modal');
                    if (!modal) return;

                    modal.classList.remove('fixed');
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            });
        })({});
    </script>
@endpush