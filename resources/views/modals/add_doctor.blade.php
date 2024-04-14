<head>
    <link rel="stylesheet" href="{{ asset('css/add_doctor_modal.css') }}">
    <script src="{{ asset('js/add_doctor_modal.js') }}"></script>
</head>
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Display errors and keep the modal open
            var modal = document.getElementById('create_doctor_modal');
            if (modal) {
                modal.style.display = "flex";
            }
        });
    </script>
@endif
@php
    $hasErrors = $errors->any();
    $temp = false;
    if ($hasErrors) {
        $temp = true;
    }
@endphp
<x-modal name="example-modal" :show="$temp" id="create_doctor_modal">
    <div class="items_to_hide flex justify-center">
        <div class="form_container bg-white dark:bg-gray-800 p-8 rounded-lg">
            <form action="{{ route('admin.doctor.add') }}" method="POST" class="form" id="form">
                @csrf
                <div class="form_title text-2xl font-bold mb-4">Add Doctor</div>

                <div class="form_groups">
                    <div class="form_group">
                        <label for="nom" class="text-lg  font-semibold">Nom Complet:</label>
                        <input type="text" name="nom" id="nom_input" value="{{ old('nom') }}"
                            placeholder="Enter Your Full Name"
                            class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        <div class="error_input text-red-500">
                            @error('nom')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form_group">
                        <label for="birthday" class="text-lg font-semibold">Birthday:</label>
                        <input type="date" name="birthdate" value="{{ old('birthdate') }}" id="birthday_input"
                            placeholder="Enter Your Birthday"
                            class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        <div class="error_input text-red-500">
                            @error('birthdate')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form_groups">
                    <div class="form_group">
                        <label for="city" class="text-lg font-semibold">City:</label>
                        <input type="text" name="city" value="{{ old('city') }}" id="city_input"
                            placeholder="Enter Your City"
                            class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        <div class="error_input text-red-500">
                            @error('city')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form_group">
                        <label for="rue" class="text-lg font-semibold">Street:</label>
                        <input type="text" name="rue" value="{{ old('rue') }}" id="rue_input"
                            placeholder="Enter Your Street"
                            class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        <div class="error_input text-red-500">
                            @error('rue')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form_groups">
                    <div class="form_group">
                        <label for="email" class="text-lg font-semibold">Email:</label>
                        <input type="email" name="email" value="{{ old('email') }}" id="email_input"
                            placeholder="test@example.com"
                            class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        <div class="error_input text-red-500">
                            @error('email')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form_group">
                        <label for="password" class="text-lg font-semibold">Password:</label>
                        <input type="password" name="password" value="{{ old('password') }}" id="password_input"
                            placeholder="Minimum 8 characters"
                            class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        <div class="error_input text-red-500">
                            @error('password')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form_groups">
                    <div class="form_group">
                        <label for="phone" class="text-lg font-semibold">Phone:</label>
                        <input type="number" name="phone" value="{{ old('phone') }}" id="phone_input"
                            placeholder="(06 / 05) 00 00 00 00"
                            class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        <div class="error_input text-red-500">
                            @error('phone')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form_group">
                        <label for="gender" class="text-lg font-semibold">Gender:</label>
                        <select name="gender" id="gender_input"
                            class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="" {{ old('gender') == '' ? 'selected' : '' }}>Choose The Doctor Gender
                            </option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        <div class="error_input text-red-500">
                            @error('gender')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form_groups">
                    <div class="form_group">
                        <label for="degree" class="text-lg font-semibold">Degree:</label>
                        <select name="degree" id="degree_input"
                            class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="" {{ old('degree') == '' ? 'selected' : '' }}>Choose The Doctor
                                Degree
                            </option>
                            <option value="MD" {{ old('degree') == 'MD' ? 'selected' : '' }}>Doctor of Medicine
                                (MD)</option>
                            <option value="DO" {{ old('degree') == 'DO' ? 'selected' : '' }}>Doctor of Osteopathic
                                Medicine (DO)</option>
                            <option value="MBBS" {{ old('degree') == 'MBBS' ? 'selected' : '' }}>Bachelor of
                                Medicine, Bachelor of Surgery (MBBS)</option>
                            <option value="BDS" {{ old('degree') == 'BDS' ? 'selected' : '' }}>Bachelor of Dental
                                Surgery (BDS)</option>
                            <option value="DMD" {{ old('degree') == 'DMD' ? 'selected' : '' }}>Doctor of Dental
                                Medicine (DMD)</option>
                            <option value="DDS" {{ old('degree') == 'DDS' ? 'selected' : '' }}>Doctor of Dental
                                Surgery (DDS)</option>
                            <option value="DPM" {{ old('degree') == 'DPM' ? 'selected' : '' }}>Doctor of Podiatric
                                Medicine (DPM)</option>
                            <option value="PharmD" {{ old('degree') == 'PharmD' ? 'selected' : '' }}>Doctor of
                                Pharmacy (PharmD)</option>
                            <option value="DPT" {{ old('degree') == 'DPT' ? 'selected' : '' }}>Doctor of Physical
                                Therapy (DPT)</option>
                            <option value="DVM" {{ old('degree') == 'DVM' ? 'selected' : '' }}>Doctor of Veterinary
                                Medicine (DVM)</option>
                            <option value="MD-PhD" {{ old('degree') == 'MD-PhD' ? 'selected' : '' }}>Doctor of
                                Medicine, Doctor of Philosophy (MD-PhD)</option>
                            <option value="MS" {{ old('degree') == 'MS' ? 'selected' : '' }}>Master of Surgery
                                (MS)</option>
                            <option value="MCh" {{ old('degree') == 'MCh' ? 'selected' : '' }}>Master of Chirurgery
                                (MCh)</option>
                            <option value="MDS" {{ old('degree') == 'MDS' ? 'selected' : '' }}>Master of Dental
                                Surgery (MDS)</option>
                            <option value="DC" {{ old('degree') == 'DC' ? 'selected' : '' }}>Doctor of
                                Chiropractic (DC)</option>
                            <option value="DSc" {{ old('degree') == 'DSc' ? 'selected' : '' }}>Doctor of Science
                                (DSc)</option>
                            <option value="EdD" {{ old('degree') == 'EdD' ? 'selected' : '' }}>Doctor of Education
                                (EdD)</option>
                            <option value="PsyD" {{ old('degree') == 'PsyD' ? 'selected' : '' }}>Doctor of
                                Psychology (PsyD)</option>
                            <option value="JD" {{ old('degree') == 'JD' ? 'selected' : '' }}>Doctor of
                                Jurisprudence (JD)</option>
                            <option value="DrPH" {{ old('degree') == 'DrPH' ? 'selected' : '' }}>Doctor of Public
                                Health (DrPH)</option>
                            <!-- Add options for different degrees -->
                        </select>
                        <div class="error_input text-red-500">
                            @error('degree')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form_group">
                        <label for="speciality" class="text-lg font-semibold">Speciality:</label>
                        <select name="speciality" id="speciality_input"
                            class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="" {{ old('speciality') == '' ? 'selected' : '' }}>Choose The Doctor
                                Speciality</option>
                            @foreach ($specialities as $speciality)
                                <option value="{{ $speciality->id }}"
                                    {{ old('speciality') == $speciality->id ? 'selected' : '' }}>
                                    {{ $speciality->name }}</option>
                            @endforeach
                            <!-- Add options for different specialities -->
                        </select>
                        <div class="error_input text-red-500">
                            @error('speciality')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form_btn mt-4">
                    <button
                        class="rounded-lg mr-3  relative w-48 h-12 cursor-pointer flex items-center border border-green-500 bg-green-500 group hover:bg-green-500 active:bg-green-500 active:border-green-500">
                        <span
                            class="text-white font-semibold ml-8 transform group-hover:translate-x-30 transition-all duration-300">Add
                            Doctor</span>
                        <span
                            class="absolute right-0 h-full w-10 rounded-lg bg-green-500 flex items-center justify-center transform group-hover:translate-x-0 group-hover:w-full transition-all duration-300">
                            <svg class="svg w-8 text-white" fill="none" height="24" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                width="24" xmlns="http://www.w3.org/2000/svg">
                                <line x1="12" x2="12" y1="5" y2="19"></line>
                                <line x1="5" x2="19" y1="12" y2="12"></line>
                            </svg>
                        </span>
                    </button>
                    <input type="reset" value="Reset"
                        class="rounded-lg px-6 py-2 ml-4 bg-gray-300 text-gray-700 font-semibold hover:bg-gray-400">
                </div>
            </form>
        </div>
    </div>
</x-modal>
<script src="{{ asset('js/validations/admin/add_doctor_modal.js') }}"></script>
