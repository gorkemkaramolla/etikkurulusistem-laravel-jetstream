@props(['formData' => null])

<div class="container mt-5">
    <div class="row g-3">
        <div class="col-md-4 form-group">
            <label for="q1">Başvuru Dönemi <br><span class="pt-0 small">Term:</span><span
                    class="text-danger">*</span></label>
            <select name="application_semester" class="form-control" required>
                <option value="" disabled
                    {{ ($formData ? $formData->application_semester : old('application_semester')) ? '' : 'selected' }}>
                    Başvuru dönemi seçiniz
                </option>
                <option value="güz"
                    {{ ($formData ? $formData->application_semester : old('application_semester')) == 'güz' ? 'selected' : '' }}>
                    Güz
                </option>
                <option value="bahar"
                    {{ ($formData ? $formData->application_semester : old('application_semester')) == 'bahar' ? 'selected' : '' }}>
                    Bahar
                </option>
            </select>

        </div>
        <div class="col-md-4 form-group">
            <label for="q1">Akademik Yıl<br><span class="pt-0 small">Term:</span><span
                    class="text-danger">*</span></label>
            <input name="academic_year" type="text" class="form-control"
                value="{{ $formData ? $formData->academic_year : old('academic_year') }}">
        </div>
        <div class="col-md-4 form-group">
            <label for="temel_alan_bilgisi">Temel Alan Bilgisi<br><span class="pt-0 small">Basic Domain
                    Knowledge:</span><span class="text-danger">*</span></label>
            <select id="temel_alan_bilgisi" class="form-control" name="temel_alan_bilgisi" required>
                <option value="" disabled
                    {{ ($formData ? $formData->temel_alan_bilgisi : old('temel_alan_bilgisi')) ? '' : 'selected' }}>
                    Temel Alanızı seçiniz
                </option>
                <option value="Sosyal Bilimler"
                    {{ ($formData ? $formData->temel_alan_bilgisi : old('temel_alan_bilgisi')) == 'Sosyal Bilimler' ? 'selected' : '' }}>
                    Sosyal Bilimler
                </option>
                <option value="Fen/Mühendislik Bilimleri"
                    {{ ($formData ? $formData->temel_alan_bilgisi : old('temel_alan_bilgisi')) == 'Fen/Mühendislik Bilimleri' ? 'selected' : '' }}>
                    Fen/Mühendislik Bilimleri
                </option>
                <option value="Sağlık Bilimleri"
                    {{ ($formData ? $formData->temel_alan_bilgisi : old('temel_alan_bilgisi')) == 'Sağlık Bilimleri' ? 'selected' : '' }}>
                    Sağlık Bilimleri
                </option>
            </select>
        </div>


        <div class="col-md-4 form-group">
            <label for="q3">Başvuru Türü<br><span class="pt-0 small">Program Type:</span><span
                    class="text-danger">*</span></label>
            <select class="form-control" name="application_type" onchange="toggleOtherInput(this, 'otherInput');"
                required>
                <option value="" disabled
                    {{ ($formData ? $formData->application_type : old('application_type')) ? '' : 'selected' }}>
                    Başvuru Türü
                </option>
                <option value="Yeni Başvuru"
                    {{ ($formData ? $formData->application_type : old('application_type')) == 'Yeni Başvuru' ? 'selected' : '' }}>
                    Yeni Başvuru
                </option>
                <option value="Düzeltme"
                    {{ ($formData ? $formData->application_type : old('application_type')) == 'Düzeltme' ? 'selected' : '' }}>
                    Düzeltme
                </option>
                <option value="Amaç/Yöntem Değişikliği"
                    {{ ($formData ? $formData->application_type : old('application_type')) == 'Amaç/Yöntem Değişikliği' ? 'selected' : '' }}>
                    Amaç/Yöntem Değişikliği
                </option>
                <option value="Devam Eden Proje"
                    {{ ($formData ? $formData->application_type : old('application_type')) == 'Devam Eden Proje' ? 'selected' : '' }}>
                    Devam Eden Proje
                </option>
                <option value="Diğer"
                    {{ ($formData ? $formData->application_type : old('application_type')) == 'Diğer' ? 'selected' : '' }}>
                    Diğer
                </option>
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label for="q4">Çalışmanın Niteliği <br><span class="pt-0 small">The Nature of the Work:</span><span
                    class="text-danger">*</span></label>
            <select class="form-control" name="work_qualification" onchange="toggleOtherInput(this, 'otherInput');"
                required>
                <option value="" disabled
                    {{ ($formData ? $formData->work_qualification : old('work_qualification')) ? '' : 'selected' }}>
                    Çalışmanın Niteliğinizi seçiniz
                </option>
                <option value="Yüksek Lisans Tezi"
                    {{ ($formData ? $formData->work_qualification : old('work_qualification')) == 'Yüksek Lisans Tezi' ? 'selected' : '' }}>
                    Yüksek Lisans Tezi
                </option>
                <option value="Doktora/Sanatta Yeterlik Tezi"
                    {{ ($formData ? $formData->work_qualification : old('work_qualification')) == 'Doktora/Sanatta Yeterlik Tezi' ? 'selected' : '' }}>
                    Doktora/Sanatta Yeterlik Tezi
                </option>
                <option value="BAP destekli proje"
                    {{ ($formData ? $formData->work_qualification : old('work_qualification')) == 'BAP destekli proje' ? 'selected' : '' }}>
                    BAP destekli proje
                </option>
                <option value="TÜBİTAK Projesi"
                    {{ ($formData ? $formData->work_qualification : old('work_qualification')) == 'TÜBİTAK Projesi' ? 'selected' : '' }}>
                    TÜBİTAK Projesi
                </option>
                <option value="Diğer"
                    {{ ($formData ? $formData->work_qualification : old('work_qualification')) == 'Diğer' ? 'selected' : '' }}>
                    Diğer
                </option>
            </select>
            <div class="col-md-4 form-group"
                style="display: {{ ($formData ? $formData->work_qualification : old('work_qualification')) == 'Diğer' ? 'block' : 'none' }};">
                <input type="text" class="form-control" name="other" placeholder="Lütfen belirtiniz">
            </div>
        </div>

        <div class="col-md-4 form-group">
            <label for="q5">Araştırma Türü<br><span class="pt-0 small">Type of Research:</span><span
                    class="text-danger">*</span></label>
            <select class="form-control" name="research_type" onchange="toggleOtherInput(this, 'otherInput');" required>
                <option value="" disabled
                    {{ ($formData ? $formData->research_type : old('research_type')) ? '' : 'selected' }}>
                    Araştırma Türü seçiniz
                </option>
                <option value="Tarama Çalışması"
                    {{ ($formData ? $formData->research_type : old('research_type')) == 'Tarama Çalışması' ? 'selected' : '' }}>
                    Tarama Çalışması
                </option>
                <option value="Deneysel Çalışma"
                    {{ ($formData ? $formData->research_type : old('research_type')) == 'Deneysel Çalışma' ? 'selected' : '' }}>
                    Deneysel Çalışma
                </option>
                <option value="Nitel Çalışma"
                    {{ ($formData ? $formData->research_type : old('research_type')) == 'itel Çalışma' ? 'selected' : '' }}>
                    Nitel Çalışma
                </option>
                <option value="Karma Yöntem"
                    {{ ($formData ? $formData->research_type : old('research_type')) == 'Karma Yöntem' ? 'selected' : '' }}>
                    Karma Yöntem
                </option>
                <option value="Diğer"
                    {{ ($formData ? $formData->research_type : old('research_type')) == 'Diğer' ? 'selected' : '' }}>
                    Diğer
                </option>
            </select>
            <div class="col-md-4 form-group"
                style="display: {{ ($formData ? $formData->research_type : old('research_type')) == 'Diğer' ? 'block' : 'none' }};">
                <input type="text" class="form-control" name="other" placeholder="Lütfen belirtiniz">
            </div>
        </div>

        <div class="col-md-4 form-group">
            <label for="institution_permission">Kurum İzni<br><span class="pt-0 small">Institutional Permit:</span><span
                    class="text-danger">*</span></label>
            <select class="form-control" name="institution_permission" required>
                <option value="" disabled
                    {{ ($formData ? $formData->institution_permission : old('institution_permission')) ? '' : 'selected' }}>
                    Kurum İzni seçiniz
                </option>
                <option value="Kurum İzni Alınmıştır"
                    {{ ($formData ? $formData->institution_permission : old('institution_permission')) == 'Kurum İzni Alınmıştır' ? 'selected' : '' }}>
                    Kurum İzni Alınmıştır
                </option>
                <option value="Kurum İzni İçin Başvuru Yapılmıştır"
                    {{ ($formData ? $formData->institution_permission : old('institution_permission')) == 'Kurum İzni İçin Başvuru Yapılmıştır' ? 'selected' : '' }}>
                    Kurum İzni İçin Başvuru Yapılmıştır
                </option>
                <option value="Kurum, etik kurul sonrası izin vereceğini belirtmektedir"
                    {{ ($formData ? $formData->institution_permission : old('institution_permission')) == 'Kurum, etik kurul sonrası izin vereceğini belirtmektedir' ? 'selected' : '' }}>
                    Kurum, etik kurul sonrası izin vereceğini belirtmektedir
                </option>
                <option value="Kurum iznine gerek yoktur"
                    {{ ($formData ? $formData->institution_permission : old('institution_permission')) == 'Kurum iznine gerek yoktur' ? 'selected' : '' }}>
                    Kurum iznine gerek yoktur
                </option>
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label for="research_start_date">Araştırma Başlama ve bitiş tarihi<br><span class="pt-0 small">Start date
                    of the research:</span><span class="text-danger">*</span> </label>
            <input type="date" name="research_start_date" class="form-control" placeholder="dd/mm/yyyy"
                pattern="\d{2}/\d{2}/\d{4}"
                value="{{ $formData ? $formData->research_start_date : old('research_start_date') }}">
        </div>

        <div class="col-md-4 form-group">
            <label for="research_end_date">Araştırma Bitiş Tarihi<br><span class="pt-0 small">End
                    date of the research:</span><span class="text-danger">*</span> </label>
            <input type="date" name="research_end_date" class="form-control" placeholder="dd/mm/yyyy"
                pattern="\d{2}/\d{2}/\d{4}"
                value="{{ $formData ? $formData->research_end_date : old('research_end_date') }}">
        </div>

    </div>



</div>
