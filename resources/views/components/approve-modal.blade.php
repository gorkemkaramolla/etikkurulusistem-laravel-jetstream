<style>
    @media print {
        .non-printable {
            display: none;
        }

        #printable {
            display: block;
        }
    }
</style>
@props(['formid'])

<div class="non-printable modal-body{{ $formid }}">

    <x-button onclick="toggleModal('{{ $formid }}')">Karar/Verdict</x-button>

    <div
        class="modal{{ $formid }} opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full bg-black z-50 opacity-70"></div>
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

            {{-- <div
                class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                    viewBox="0 0 18 18">
                    <path
                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                    </path>
                </svg>
                <span class="text-sm">(Esc)</span>

            </div> --}}

            <div class="modal-content py-4 text-left px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold">
                        {{ Auth::user()->hasRole('sekreterlik') ? 'Sekreterlik Kararı/ Secretary Verdict' : 'Etik Kurulu Kararı/Ethics Comittee Verdict' }}
                    </p>
                    <div onclick="toggleModal('{{ $formid }}')" class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                            height="18" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                    </div>
                </div>

                <form
                    action="{{ !Auth::user()->hasRole('sekreterlik') ? route('api.approve.etikkurul', ['formid' => $formid]) : route('api.approve.sekreterlik', ['formid' => $formid]) }}"
                    method="POST">

                    @csrf
                    <label for="onay-radio" class="block text-gray-700 text-sm font-bold mb-2">
                        Onayla/Approve:
                        <input onchange="toggleInputVisibility(event,'{{ $formid }}')" checked type="radio"
                            name="decide" value="onaylandi" id="onay-radio" required>
                    </label>

                    <label for="duzeltme-radio" class="block text-gray-700 text-sm font-bold mb-2">
                        Düzeltme/Correction:
                        <input type="radio" onchange="toggleInputVisibility(event,'{{ $formid }}')"
                            name="decide" value="duzeltme" id="duzeltme-radio" required>
                    </label>
                    @if (!Auth::user()->hasRole('sekreterlik'))
                        <label for="reddedildi-radio" class="block text-gray-700 text-sm font-bold mb-2">
                            Reddet/Decline:
                            <input onchange="toggleInputVisibility(event,'{{ $formid }}')" type="radio"
                                name="decide" value="reddedildi" id="reddedildi-radio" required>
                        </label>
                    @endif
                    <!-- Input for other cases -->

                    <textarea disabled style="display: none"
                        placeholder="Lütfen karar nedeninizi giriniz / Please enter your reason for decision"
                        class="w-full px-3 py-2 border rounded" name="decide_reason" id="decide-reason-input{{ $formid }}"
                        cols="30" rows="5" required></textarea>

                    <!--Footer-->
                    <div class="flex justify-end pt-2">
                        <input type="submit" value="Kararı Onayla/Approve Decision"
                            class="px-4 cursor-pointer bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">
                </form>



            </div>

        </div>
    </div>
</div>
<script>
    // var closemodal = document.querySelector(`.modal-body${formid} .modal-close`);
    // closemodal.addEventListener('click', function() {
    //     const formid = "{{ $formid }}"
    //     alert(formid)
    //     toggleModal(formid);
    // });

    function toggleModal(formid) {

        const body = document.querySelector(`.modal-body${formid}`);

        const modal = document.querySelector(`.modal${formid}`);
        modal.classList.toggle('opacity-0');
        modal.classList.toggle('pointer-events-none');
        body.classList.toggle('modal-active');
    }

    function toggleInputVisibility(event, formid) {
        const inputElement = document.getElementById(`decide-reason-input${formid}`);
        console.log(event.target.value);
        if (event.target.value === "onaylandi") {
            inputElement.disabled = true;
            inputElement.style.display = "none";
        } else {
            inputElement.disabled = false;
            inputElement.style.display = "block";
        }
    }
    if (typeof onayButtons === 'undefined') {
        const onayButtons = document.getElementsByName('decide');
        onayButtons.forEach((onay) => {
            onay.addEventListener('change', (event) => {
                // Your event listener code here
            });
        });
    }
</script>

</div>
<style>

</style>
