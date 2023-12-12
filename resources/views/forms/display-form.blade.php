<x-app-layout>
    <div class="w-full h-full">
        @foreach ($forms as $form)
            <div>
                <div>
                    <h1>FORM BİLGİLERİ</h1>
                    <p>ID: {{ $form['id'] }}</p>
                    <p>Document Number: {{ $form['document_number'] }}</p>
                    <p>Stage: {{ $form['stage'] }}</p>
                    <p>Created At: {{ $form['created_at'] }}</p>
                    <p>Updated At: {{ $form['updated_at'] }}</p>
                </div>
                <div>
                    <h1>ARAŞTIRMACI BİLGİLERİ</h1>
                    <h2>Researcher Information</h2>
                    <p>Name: {{ $form['researcher_informations']['name'] }}</p>
                    <p>Lastname: {{ $form['researcher_informations']['lastname'] }}</p>
                </div>
                <div>
                    <h2>Başvuru Bilgileri</h2>
                    <p>Application Semester: {{ $form['application_informations']['application_semester'] }}</p>
                    <p>Academic Year: {{ $form['application_informations']['academic_year'] }}</p>

                </div>

                <div>
                    <h2>Araştırma Bilgileri</h2>
                    <p>Research Title: {{ $form['research_informations']['research_title'] }}</p>
                    <p>Research Subject/Purpose: {{ $form['research_informations']['research_subject_purpose'] }}</p>
                </div>


            </div>
        @endforeach
    </div>



</x-app-layout>
