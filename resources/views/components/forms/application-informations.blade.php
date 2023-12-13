<div class="container mt-5">
    <div class="row g-3">
        <div class="col-md-4 form-group">
            <label for="q1">Başvuru Dönemi <br><span class="pt-0 small">Term:</span><span
                    class="text-danger">*</span></label>
            <select name="application_semester" class="form-control" id="q1" name="q1" required>
                <option value="">Başvuru dönemi seçiniz</option>
                <option value="güz">Güz</option>
                <option value="bahar">Bahar</option>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label for="q1">Akademik Yıl<br><span class="pt-0 small">Term:</span><span
                    class="text-danger">*</span></label>
            <input name="academic_year" type="text" class="form-control">
        </div>
        <div class="col-md-4 form-group">
            <label for="q2">Temel Alan Bilgisi<br><span class="pt-0 small">Basic Domain
                    Knowledge:</span><span class="text-danger">*</span></label>
            <select class="form-control" name="temel_alan_bilgisi" required>
                <option value="Temel Alanızı seçiniz">Temel Alanızı seçiniz</option>
                <option value="Sosyal Bilimler">Sosyal Bilimler</option>
                <option value="Fen/Mühendislik Bilimleri">Fen/Mühendislik Bilimleri</option>
                <option value="Sağlık Bilimleri">Sağlık Bilimleri</option>
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label for="q3">Başvuru Türü<br><span class="pt-0 small">Program Type:</span><span
                    class="text-danger">*</span></label>
            <select class="form-control" name="application_type" onchange="toggleOtherInput(this, 'otherInput');"
                required>
                <option value="Başvuru Türü">Başvuru Türü</option>
                <option value="Yeni Başvuru">Yeni Başvuru</option>
                <option value="Düzeltme">Düzeltme</option>
                <option value="Amaç/Yöntem Değişikliği">Amaç/Yöntem Değişikliği</option>
                <option value="Devam Eden Proje">Devam Eden Proje</option>
                <option value="Diğer">Diğer</option>
            </select>

        </div>
        <div class="col-md-4 form-group">
            <label for="q4">Çalışmanın Niteliği <br><span class="pt-0 small">The Nature of the
                    Work:</span><span class="text-danger">*</span></label>
            <select class="form-control" name="work_qualification" onchange="toggleOtherInput(this, 'otherInput');"
                required>
                <option value="">Çalışmanın Niteliğinızı seçiniz</option>
                <option value="Yüksek Lisans Tezi">Yüksek Lisans Tezi </option>
                <option value="Doktora/Sanatta Yeterlik Tezi">Doktora/Sanatta Yeterlik Tezi</option>
                <option value="BAP destekli proje">BAP destekli proje</option>
                <option value="TÜBİTAK Projesi">TÜBİTAK Projesi </option>
                <option value="Diğer">Diğer </option>
            </select>
            <div class="col-md-4 form-group" id="otherInput" style="display: none;">
                <input type="text" class="form-control" id="other" name="other"
                    placeholder="Lütfen belirtiniz">
            </div>
        </div>
        <div class="col-md-4 form-group">
            <label for="q5">Araştırma Türü<br><span class="pt-0 small">Type of Research:</span><span
                    class="text-danger">*</span></label>
            <select class="form-control" name="research_type" onchange="toggleOtherInput(this, 'otherInput');" required>
                <option value="">Araştırma Türü seçiniz</option>
                <option value="Tarama Çalışması">Tarama Çalışması</option>
                <option value="Deneysel Çalışma">Deneysel Çalışma</option>
                <option value="itel Çalışma">Nitel Çalışma</option>
                <option value="Karma Yöntem">Karma Yöntem</option>
                <option value="Diğer">Diğer</option>
            </select>
            <div class="col-md-4 form-group" id="otherInput" style="display: none;">
                <input type="text" class="form-control" id="other" name="other"
                    placeholder="Lütfen belirtiniz">
            </div>
        </div>
        <div class="col-md-4 form-group">
            <label for="institution_permission">Kurum İzni<br><span class="pt-0 small">Institutional Permit:</span><span
                    class="text-danger">*</span></label>
            <select class="form-control" name="institution_permission" required>
                <option value="Kurum İzni seçiniz">Kurum İzni seçiniz</option>
                <option value="Kurum İzni Alınmıştır">Kurum İzni Alınmıştır</option>
                <option value="Kurum İzni İçin Başvuru Yapılmıştır">Kurum İzni İçin Başvuru Yapılmıştır</option>
                <option value="Kurum, etik kurul sonrası izin vereceğini belirtmektedir">Kurum, etik kurul sonrası izin
                    vereceğini belirtmektedir</option>
                <option value="Kurum iznine gerek yoktur">Kurum iznine gerek yoktur</option>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label for="research_start_date">Araştırma Başlama ve bitiş tarihi<br><span class="pt-0 small">Start date
                    of the research:</span><span class="text-danger">*</span> </label>
            <input type="date" name="research_start_date" class="form-control" placeholder="dd/mm/yyyy"
                pattern="\d{2}/\d{2}/\d{4}">
        </div>
        <div class="col-md-4 form-group">
            <label for="research_end_date">Araştırma Bitiş Tarihi<br><span class="pt-0 small">End
                    date of the research:</span><span class="text-danger">*</span> </label>
            <input type="date" name="research_end_date" class="form-control" placeholder="dd/mm/yyyy"
                pattern="\d{2}/\d{2}/\d{4}">
        </div>
    </div>
</div>