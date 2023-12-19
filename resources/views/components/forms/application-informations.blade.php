<div class="container mt-5">
    <div class="row g-3">
        <div class="col-md-4 form-group">
            <label for="q1">Başvuru Dönemi <br><span class="pt-0 small">Term:</span><span
                    class="text-danger">*</span></label>
            <select name="application_semester" class="form-control" name="q1" required>
                <option value="">Başvuru dönemi seçiniz</option>
                <option value="güz" {{ old('application_semester') == 'güz' ? 'selected' : '' }}>Güz</option>
                <option value="bahar"{{ old('application_semester') == 'bahar' ? 'selected' : '' }}>Bahar</option>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label for="q1">Akademik Yıl<br><span class="pt-0 small">Term:</span><span
                    class="text-danger">*</span></label>
            <input name="academic_year" type="text" class="form-control" value="{{ old('academic_year') }}">
        </div>
        <div class="col-md-4 form-group">
            <label for="q2">Temel Alan Bilgisi<br><span class="pt-0 small">Basic Domain
                    Knowledge:</span><span class="text-danger">*</span></label>
            <select class="form-control" name="temel_alan_bilgisi" required>
                <option value="Temel Alanızı seçiniz">Temel Alanızı seçiniz</option>
                <option value="Sosyal Bilimler" {{ old('temel_alan_bilgisi') == 'Sosyal Bilimler' ? 'selected' : '' }}>Sosyal Bilimler</option>
                <option value="Fen/Mühendislik Bilimleri" {{ old('temel_alan_bilgisi') == 'Fen/Mühendislik Bilimleri' ? 'selected' : '' }}>Fen/Mühendislik Bilimleri</option>
                <option value="Sağlık Bilimleri" {{ old('temel_alan_bilgisi') == 'Sağlık Bilimleri' ? 'selected' : '        <' }}>Sağlık Bilimleri</option>
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label for="q3">Başvuru Türü<br><span class="pt-0 small">Program Type:</span><span
                    class="text-danger">*</span></label>
            <select class="form-control" name="application_type" onchange="toggleOtherInput(this, 'otherInput');"
                required>
                <option value="Başvuru Türü" {{ old('application_type') == 'Başvuru Türü' ? 'selected' : '' }}>Başvuru Türü </option>
                <option value="Yeni Başvuru" {{ old('application_type') == 'Yeni Başvuru' ? 'selected' : '' }}>Yeni Başvuru</option>
                <option value="Düzeltme" {{ old('application_type') == 'Düzeltme' ? 'selected' : '' }}>Düzeltme</option>
                <option value="Amaç/Yöntem Değişikliği" {{ old('application_type') == 'Amaç/Yöntem Değişikliği' ? 'selected' : '' }}>Amaç/Yöntem Değişikliği</option>
                <option value="Devam Eden Proje" {{ old('application_type') == 'Devam Eden Proje' ? 'selected' : '' }}>Devam Eden Proje</option>
                <option value="Diğer" {{ old('application_type') == 'Diğer' ? 'selected' : '' }}> >Diğer</option>
            </select>

        </div>
        <div class="col-md-4 form-group">
            <label for="q4">Çalışmanın Niteliği <br><span class="pt-0 small">The Nature of the
                    Work:</span><span class="text-danger">*</span></label>
            <select class="form-control" name="work_qualification" onchange="toggleOtherInput(this, 'otherInput');"
                required>
                <option value="">Çalışmanın Niteliğinızı seçiniz</option>
                <option value="Yüksek Lisans Tezi" {{ old('work_qualification') == 'Yüksek Lisans Tezi' ? 'selected' : '' }}>Yüksek Lisans Tezi</option>
                <option value="Doktora/Sanatta Yeterlik Tezi" {{ old('work_qualification') == 'Doktora/Sanatta Yeterlik Tezi' ? 'selected' : '' }}>Doktora/Sanatta Yeterlik Tezi</option>
                <option value="BAP destekli proje"{{ old('work_qualification') == 'BAP destekli proje' ? 'selected' : '' }}>BAP destekli proje</option>
                <option value="TÜBİTAK Projesi"{{ old('work_qualification') == 'TÜBİTAK Projesi' ? 'selected' : '' }}>TÜBİTAK Projesi </option>
                <option value="Diğer" {{ old('work_qualification') == 'Diğer' ? 'selected' : '' }}>Diğer </option>
            </select>
            <div class="col-md-4 form-group"  style="display: none;">
                <input type="text" class="form-control"  name="other"
                    placeholder="Lütfen belirtiniz">
            </div>
        </div>
        <div class="col-md-4 form-group">
            <label for="q5">Araştırma Türü<br><span class="pt-0 small">Type of Research:</span><span
                    class="text-danger">*</span></label>
            <select class="form-control" name="research_type" onchange="toggleOtherInput(this, 'otherInput');" required>
                <option value="">Araştırma Türü seçiniz</option>
                <option value="Tarama Çalışması" {{ old('research_type') == 'Tarama Çalışması' ? 'selected' : '' }}>Tarama Çalışması</option>
                <option value="Deneysel Çalışma"{{ old('research_type') == 'Deneysel Çalışma' ? 'selected' : '' }}>Deneysel Çalışma</option>
                <option value="itel Çalışma"{{ old('research_type') == 'itel Çalışma' ? 'selected' : '' }}>Nitel Çalışma</option>
                <option value="Karma Yöntem"{{ old('research_type') == 'Karma Yöntem' ? 'selected' : '' }}>Karma Yöntem</option>
                <option value="Diğer" {{ old('research_type') == 'Diğer' ? 'selected' : '' }}>Diğer </option>
            </select>
            <div class="col-md-4 form-group"  style="display: none;">
                <input type="text" class="form-control"  name="other"
                    placeholder="Lütfen belirtiniz">
            </div>
        </div>
        <div class="col-md-4 form-group">
    <label for="institution_permission">Kurum İzni<br><span class="pt-0 small">Institutional Permit:</span><span
            class="text-danger">*</span></label>
    <select class="form-control" name="institution_permission" required>
        <option value="Kurum İzni seçiniz" {{ old('institution_permission') == 'Kurum İzni seçiniz' ? 'selected' : '' }}>Kurum İzni seçiniz</option>
        <option value="Kurum İzni Alınmıştır" {{ old('institution_permission') == 'Kurum İzni Alınmıştır' ? 'selected' : '' }}>Kurum İzni Alınmıştır</option>
        <option value="Kurum İzni İçin Başvuru Yapılmıştır" {{ old('institution_permission') == 'Kurum İzni İçin Başvuru Yapılmıştır' ? 'selected' : '' }}>Kurum İzni İçin Başvuru Yapılmıştır</option>
        <option value="Kurum, etik kurul sonrası izin vereceğini belirtmektedir" {{ old('institution_permission') == 'Kurum, etik kurul sonrası izin vereceğini belirtmektedir' ? 'selected' : '' }}>Kurum, etik kurul sonrası izin vereceğini belirtmektedir</option>
        <option value="Kurum iznine gerek yoktur" {{ old('institution_permission') == 'Kurum iznine gerek yoktur' ? 'selected' : '' }}>Kurum iznine gerek yoktur</option>
    </select>
    </div>

    <div class="col-md-4 form-group">
        <label for="research_start_date">Araştırma Başlama ve bitiş tarihi<br><span class="pt-0 small">Start date
                of the research:</span><span class="text-danger">*</span> </label>
        <input type="date" name="research_start_date" class="form-control" placeholder="dd/mm/yyyy"
            pattern="\d{2}/\d{2}/\d{4}" value="{{ old('research_start_date') }}">
    </div>
    
    <div class="col-md-4 form-group">
        <label for="research_end_date">Araştırma Bitiş Tarihi<br><span class="pt-0 small">End
                date of the research:</span><span class="text-danger">*</span> </label>
        <input type="date" name="research_end_date" class="form-control" placeholder="dd/mm/yyyy"
            pattern="\d{2}/\d{2}/\d{4}" value="{{ old('research_end_date') }}">
        </div>

</div>



</div>