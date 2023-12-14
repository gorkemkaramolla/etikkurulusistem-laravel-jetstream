@props(['formid'])

<body class="bg-gray-200 flex items-center justify-center h-screen">

    <button
        class="modal-open bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full">Karar</button>

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
                    <p class="text-2xl font-bold">Simple Modal!</p>
                    <div class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                            height="18" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                    </div>
                </div>
                <form action="{{ route('approve.etikkurul', ['formid' => $formid]) }}" method="POST">

                    @csrf
                    <label for="onay-radio" class="block text-gray-700 text-sm font-bold mb-2">
                        Onayla:
                        <input checked type="radio" name="decide" value="onaylandi" id="onay-radio" required>
                    </label>

                    <label for="duzeltme-radio" class="block text-gray-700 text-sm font-bold mb-2">
                        Düzeltme:
                        <input type="radio" name="decide" value="duzeltme" id="duzeltme-radio" required>
                    </label>

                    <label for="reddedildi-radio" class="block text-gray-700 text-sm font-bold mb-2">
                        Reddedildi:
                        <input type="radio" name="decide" value="reddedildi" id="reddedildi-radio" required>
                    </label>

                    <!-- Input for other cases -->
                    <input type="text" name="decide_reason" id="decide-reason-input"
                        class="w-full px-3 py-2 border  rounded" placeholder="Karar sebebi..." required>





                    <!--Footer-->
                    <div class="flex justify-end pt-2">
                        <input type="submit"
                            class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">
                </form>


            </div>

        </div>
    </div>
    </div>
    <script>
        // Function to toggle input visibility and disabled attribute based on the selected radio button
        function toggleInputVisibility() {
            const radioButtons = document.getElementsByName('decide');
            const inputElement = document.getElementById('decide-reason-input');

            // Loop through radio buttons to find the selected one
            for (const radioButton of radioButtons) {
                if (radioButton.checked) {
                    // Show the input only if a non-"Onay" radio button is selected
                    const isOnay = radioButton.value === 'onaylandi';
                    inputElement.style.display = isOnay ? 'none' : 'block';

                    // Set the 'disabled' attribute based on whether the input should be included in the form submission
                    inputElement.disabled = isOnay;
                    return;
                }
            }

            inputElement.style.display = 'none';
            inputElement.disabled = true;
        }

        // Attach the function to the change event of radio buttons
        const radioButtons = document.getElementsByName('decide');
        for (const radioButton of radioButtons) {
            radioButton.addEventListener('change', toggleInputVisibility);
        }

        // Call the function initially to set the state on page load
        toggleInputVisibility();
    </script>


    <script>
        var openmodal = document.querySelectorAll('.modal-open')
        for (var i = 0; i < openmodal.length; i++) {
            openmodal[i].addEventListener('click', function(event) {
                event.preventDefault()
                toggleModal()
            })
        }

        const overlay = document.querySelector('.modal-overlay')
        overlay.addEventListener('click', toggleModal)

        var closemodal = document.querySelectorAll('.modal-close')
        for (var i = 0; i < closemodal.length; i++) {
            closemodal[i].addEventListener('click', toggleModal)
        }

        document.onkeydown = function(evt) {
            evt = evt || window.event
            var isEscape = false
            if ("key" in evt) {
                isEscape = (evt.key === "Escape" || evt.key === "Esc")
            } else {
                isEscape = (evt.keyCode === 27)
            }
            if (isEscape && document.body.classList.contains('modal-active')) {
                toggleModal()
            }
        };


        function toggleModal() {
            const body = document.querySelector('body')
            const modal = document.querySelector('.modal')
            modal.classList.toggle('opacity-0')
            modal.classList.toggle('pointer-events-none')
            body.classList.toggle('modal-active')
        }
    </script>
</body>
