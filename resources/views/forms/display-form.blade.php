<x-app-layout :title="'Your Custom Title'">
    <title>Başvuru : {{ $form->student_no }}</title>

    <x-forms.display-form :form="$form" />
</x-app-layout>
