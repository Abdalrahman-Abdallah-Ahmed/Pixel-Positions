<x-app-layout>
    <x-page-heading>Create a New Job</x-page-heading>

    <x-forms.form method='POST' action='/jobs'>
        <x-forms.input label='Title' name='title' placeholder='CEO' />
        <x-forms.input label='Salary' name='salary' placeholder='$90,000' />
        <x-forms.input label='Location' name='location' placeholder='Winter Park, Florida' />
        <x-forms.select label='Schedule' name='schedule'>
            <option>Part Time</option>
            <option>Full Time</option>
        </x-forms.select>
        <x-forms.input label='URL' name='url' placeholder='https://ex.com/job/ceo-wanted' />
        <x-forms.checkbox label='Featured (Costs Extra)' name='featured'/>

        <x-forms.divider/>

        <x-forms.input label='Tags (comma seperated)' name='tags' placeholder='Developer, Editer, Education' />

        <x-forms.button>Publish</x-forms.button>
    </x-forms.form>
</x-app-layout>
