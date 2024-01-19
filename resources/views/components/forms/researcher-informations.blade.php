@props(['formData' => null])

<div class="container pt-1">
    <div class="row g-3">
        <div class="col-md-4">
            <label for="name" class="form-label">Araştırmacı Adı<br><span class="pt-0 small">Name</span></label>
            <input required readonly type="text" name="name" id="name" class="form-control bg-light"
                value="{{ $formData ? $formData->name : old('name', auth()->user()->name) }}">
        </div>
        <div class="col-md-4">
            <label for="lastname" class="form-label">Araştırmacı Soyadı <br><span
                    class="pt-0 small">Lastname</span></label>
            <input required id="lastname" type="text" name="lastname" class="form-control bg-light" readonly
                value="{{ old('lastname', auth()->user()->lastname) }}">
        </div>

        <div class="col-md-4">
            <label for="studentID" class="form-label">Öğrenci No / TC No<br>
                <span class="pt-0 small">Student ID Number</span></label>
            <input required type="text" name="student_no" class="form-control " id="studentID"
                value="{{ old('student_no', auth()->user()->username) }}">
        </div>
        <div class="col-md-4">
            <label for="email" class="form-label">Mail Adressi<br><span class="pt-0 small">Email
                    Address</span></label>
            <input required readonly type="email" name="email" class="form-control bg-light" id="email"
                value="{{ old('email', auth()->user()->email) }}">
        </div>
        <div class="col-md-4">
            <label for="phone" class="form-label">Telefon<br><span class="pt-0 small">Phone Number</span></label>
            <input required placeholder="(539) 273 046"type="phone" name="gsm" class="form-control" id="phone"
                value="{{ $formData ? $formData->gsm : old('gsm') }}">
        </div>
        <div class="col-md-4">
            <label for="advisor" class="form-label">Danışman / Yürütücü<br><span
                    class="pt-0 small">Advisor/Executive</span></label>
            <input required type="text" name="advisor" class="form-control" id="advisor"
                value="{{ $formData ? $formData->advisor : old('advisor') }}">
        </div>
        <div class="col-md-4">
            <label for="ana_bilim_dali" class="form-label">Anabilim Dalı<br><span
                    class="pt-0 small">Department</span></label>
            <select class="form-control" name="ana_bilim_dali" id="ana_bilim_dali" onchange="updateProgramOptions()"
                required>
                <option value="" disabled selected>Ana Bilim Dalı Seçiniz</option>
                @foreach (config('enums') as $anabilimDali)
                    <option value="{{ $anabilimDali }}">{{ $anabilimDali }}</option>
                @endforeach
            </select>
        </div>


        <div class="col-md-4">
            <label for="program" class="form-label">Program Adı<br><span class="pt-0 small">Program</span></label>
            <select disabled class="form-control" name="program" id="program" required>
                <!-- Options will be dynamically updated using JavaScript -->
            </select>
        </div>

    </div>
    <script>
        function updateProgramOptions() {
            var anabilimDaliSelect = document.getElementById('ana_bilim_dali');
            var programSelect = document.getElementById('program');
            var selectedAnabilimDali = anabilimDaliSelect.value;

            programSelect.innerHTML = '';

            // Disable the program select if no Anabilim Dalı is selected
            programSelect.disabled = !selectedAnabilimDali;

            if (selectedAnabilimDali) {
                // Retrieve program options from the program_enums config file
                var programs = {!! json_encode(config('program_enums')) !!}[selectedAnabilimDali] || [];

                // Add new program options based on the selected Anabilim Dalı
                programs.forEach(function(program) {
                    addProgramOption(programSelect, program);
                });
            }
        }

        function addProgramOption(select, value) {
            var option = document.createElement('option');
            option.value = value;
            option.text = value;
            select.add(option);
        }
    </script>





</div>
