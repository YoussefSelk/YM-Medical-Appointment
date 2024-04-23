<x-patient-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold">Emergency Contacts</h1>
    </x-slot>

    <x-slot name="slot">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @if(isset($emergencyContacts) && count($emergencyContacts) > 0)
                    @foreach($emergencyContacts as $contact)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-4">{{ $contact['display_name'] }}</h3>
                                <p class="text-gray-700">
                                    @if(isset($contact['address']['road']))
                                        {{ $contact['address']['road'] }},
                                    @endif
                                    @if(isset($contact['address']['city']))
                                        {{ $contact['address']['city'] }},
                                    @endif
                                    @if(isset($contact['address']['state']))
                                        {{ $contact['address']['state'] }},
                                    @endif
                                    @if(isset($contact['address']['country']))
                                        {{ $contact['address']['country'] }}
                                    @endif
                                </p>
                                @if(isset($contact['phone']))
                                    <p class="text-gray-700">Phone: {{ $contact['phone'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No emergency contacts available in .</p>
                @endif
            </div>
        </div>
    </x-slot>
</x-patient-layout>
