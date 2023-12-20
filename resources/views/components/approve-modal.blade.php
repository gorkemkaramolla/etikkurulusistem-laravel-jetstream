@props(['formid'])

<div class="">

    <button
        class="modal-open bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full">Karar/Verdict</button>

    <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

            <div
                class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                    viewBox="0 0 18 18">
                    <path
                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                    </path>
                </svg>
                <span class="text-sm">(Esc)</span>
            </div>

            <div class="modal-content py-4 text-left px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold">
                        {{ Auth::user()->hasRole('sekreterlik') ? 'Sekreterlik Kararı/ Secretary Verdict' : 'Etik Kurulu Kararı/Ethics Comittee Verdict' }}
                    </p>
                    <div class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                            height="18" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                    </div>
                </div>
                <form
                    action="{{ !Auth::user()->hasRole('sekreterlik') ? route('approve.etikkurul', ['formid' => $formid]) : route('approve.sekreterlik', ['formid' => $formid]) }}"
                    method="POST">

                    @csrf
                    <label for="onay-radio" class="block text-gray-700 text-sm font-bold mb-2">
                        Onayla/Approve:
                        <input checked type="radio" name="decide" value="onaylandi" id="onay-radio" required>
                    </label>

                    <label for="duzeltme-radio" class="block text-gray-700 text-sm font-bold mb-2">
                        Düzeltme/Correction:
                        <input type="radio" name="decide" value="duzeltme" id="duzeltme-radio" required>
                    </label>
                    @if (!Auth::user()->hasRole('sekreterlik'))
                        <label for="reddedildi-radio" class="block text-gray-700 text-sm font-bold mb-2">
                            Reddet/Decline:
                            <input type="radio" name="decide" value="reddedildi" id="reddedildi-radio" required>
                        </label>
                    @endif
                    <!-- Input for other cases -->

                    <textarea placeholder="Lütfen karar nedeninizi giriniz / Please enter your reason for decision"
                        class="w-full px-3 py-2 border rounded" name="decide_reason" id="decide-reason-input" cols="30" rows="5"
                        required></textarea>

                    <!--Footer-->
                    <div class="flex justify-end pt-2">
                        <input type="submit" value="Kararı Onayla/Approve Decision"
                            class="px-4 cursor-pointer bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">
                </form>



            </div>

        </div>
    </div>
</div>

</div>
