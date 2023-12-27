<x-guest-layout>
    <style>
        table {
            width: 100%;
            max-width: 1024px;
            min-width: 300px;
            height: 100px;
            font-size: 16px;
        }

        td {
            word-wrap: break-word;
            /* or use overflow-wrap: break-word; */
            max-width: 200px;
            /* Set a specific max-width if needed */
        }

        @media (max-width: 500px) {
            .pdf-render {}
        }
    </style>
    <div class="pdf-render w-full  flex flex-col items-center  overflow-y-hidden  p-0 my-8 ">
        <!-- forms/display-querystage.blade.php -->
        <h1 class="text-4xl ">Nişantaşı Üniversitesi Etik Kurul Başvuru Sorgulama</h1>
        <div class="bg-gray-200 p-4 rounded-md shadow-md">
            <p class="text-lg font-bold mb-2">Etik Kurula Gönderilme Tarihi:
                {{ \Carbon\Carbon::parse($form['created_at'])->format('d/m/Y') ?? 'N/A' }}
            </p>

            <div class="mb-4">
                <p class="text-xl font-bold mb-2">Research Information:</p>
                <ul>
                    <li class="list-disc ml-4">Research Title: {{ $form->research_title }}</li>
                </ul>
            </div>

            <div>
                <p class="text-xl font-bold mb-2">Researcher Information:</p>
                <ul>
                    <li class="list-disc ml-4">Name: {{ $form->name }}</li>
                    <li class="list-disc ml-4">Lastname: {{ $form->lastname }}</li>
                    <li class="list-disc ml-4">Major: {{ $form->major }}</li>
                    <li class="list-disc ml-4">Department: {{ $form->department }}</li>
                </ul>
            </div>
        </div>

    </div>

</x-guest-layout>
