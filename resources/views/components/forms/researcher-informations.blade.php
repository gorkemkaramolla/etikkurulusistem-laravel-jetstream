<div class="container pt-1">
    <div class="row g-3">
        <div class="col-md-4">
            <label for="researcherName" class="form-label">Araştırmacı Adı<br><span class="pt-0 small">Name</span></label>
            <input readonly type="text" name="name" id="name" class="form-control" id="researcherName"
                value="{{ old('name', auth()->user()->name) }}">
        </div>
        <div class="col-md-4">
            <label for="lastname" class="form-label">Araştırmacı Soyadı <br><span
                    class="pt-0 small">Lastname</span></label>
            <input readonly id="lastname" type="text" name="lastname" class="form-control"
                value="{{ old('lastname', auth()->user()->lastname) }}">
        </div>

        <div class="col-md-4">
            <label for="studentID" class="form-label">Öğrenci No / TC No<br>
                <span class="pt-0 small">Student ID Number</span></label>
            <input readonly type="text" name="student_no" class="form-control" id="studentID"
                value="{{ old('student_no', auth()->user()->student_no) }}">
        </div>
        <div class="col-md-4">
            <label for="email" class="form-label">Mail Adressi<br><span class="pt-0 small">Email
                    Address</span></label>
            <input type="email" readonly name="email" class="form-control" id="email"
                value="{{ old('email', auth()->user()->email) }}">
        </div>
        <div class="col-md-4">
            <label for="phone" class="form-label">Telefon<br><span class="pt-0 small">Phone Number</span></label>
            <input placeholder="(539) 273 046"type="phone" name="gsm" class="form-control" id="phone"
                value="{{ old('gsm') }}">
        </div>
        <div class="col-md-4">
            <label for="advisor" class="form-label">Danışman / Yürütücü<br><span
                    class="pt-0 small">Advisor/Executive</span></label>
            <input type="text" name="advisor" class="form-control" id="advisor" value="{{ old('advisor') }}">
        </div>
        <div class="col-md-4">
            <label for="department" class="form-label">Anabilim Dalı<br><span
                    class="pt-0 small">Department</span></label>
            <input type="text" name="department" class="form-control" id="department" placeholder=""
                value="{{ old('department') }}">
        </div>
        <div class="col-md-4">
            <label for="program" class="form-label">Program<br><span class="pt-0 small">Department</span></label>
            <input type="text" name="major" class="form-control" id="program" value="{{ old('major') }}">
        </div>
    </div>
</div>
