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
    <!-- Modal content goes here -->
    <div class="items_to_hide flex justify-center  ">

        <div class="form_container bg-white dark:bg-gray-800">

            <form action="{{ route('admin.doctor.add') }}" method="POST" class="form" id="form">
                @csrf
                <div class="form_title">
                    <h1>Add Doctor</h1>
                </div>


                <div class="form_groups">
                    <div class="form_group nom_container">
                        <label for="nom">Nom Complet:</label>
                        <input type="text" name="nom" id="nom_input" value="{{ old('nom') }}"
                            placeholder="Enter Your Full Name">
                        <div class="error_input" id="nom_error">
                            @error('nom')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form_group birthday_container">
                        <label for="birthday">Birthday:</label>
                        <input type="date" name="birthdate" value="{{ old('birthdate') }}" id="birthday_input"
                            placeholder="Enter Your Birthday">
                        <div class="error_input" id="birthday_error">
                            @error('birthdate')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form_groups">
                    <div class="form_group city_container">
                        <label for="city">City:</label>
                        <input type="text" name="city" value="{{ old('city') }}" placeholder="Enter Your City"
                            id="city_input">
                        <div class="error_input" id="city_error">
                            @error('city')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form_group Rue_container">
                        <label for="rue">Street:</label>
                        <input type="text" name="rue" value="{{ old('rue') }}" id="rue_input"
                            placeholder="Enter Your Street">
                        <div class="error_input" id="rue_error">
                            @error('rue')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form_groups">
                    <div class="form_group email_container">
                        <label for="email">Email:</label>
                        <input type="email" name="email" value="{{ old('email') }}" id="email_input"
                            placeholder="test@exemple.com">
                        <div class="error_input" id="email_error">
                            @error('email')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form_group password_container">
                        <label for="password">Password:</label>
                        <input type="password" name="password" value="{{ old('password') }}" id="password_input"
                            placeholder="Minimum 8 characters">
                        <div class="error_input" id="password_error">
                            @error('password')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form_groups">
                    <div class="form_group phone_container">
                        <label for="phone">Phone:</label>
                        <input type="number" name="phone" value="{{ old('phone') }}" id="phone_input"
                            placeholder="(06 / 05) 00 00 00 00">
                        <div class="error_input" id="phone_error">
                            @error('phone')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form_group">
                        <label for="gender">Gender:</label>
                        <select name="gender" id="gender_input">
                            <option value="" {{ old('gender') == '' ? 'selected' : '' }}>Choose The Doctor Gender
                            </option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        <div class="error_input" id="gender_error">
                            @error('gender')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="form_groups">
                    <div class="form_group degree_container">
                        <label for="degree">Degree:</label>
                        <select name="degree" id="degree_input">
                            <option value="" {{ old('degree') == '' ? 'selected' : '' }}>Choose The Doctor Degree
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
                        </select>
                        <div class="error_input" id="degree_error">
                            @error('degree')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>



                    <div class="form_group">
                        <label for="speciality">Speciality:</label>
                        <select name="speciality" id="speciality_input">
                            <option value="" {{ old('speciality') == '' ? 'selected' : '' }}>Choose The Doctor
                                Speciality</option>
                            @foreach ($specialities as $speciality)
                                <option value="{{ $speciality->id }}"
                                    {{ old('speciality') == $speciality->id ? 'selected' : '' }}>
                                    {{ $speciality->name }}</option>
                            @endforeach
                        </select>
                        <div class="error_input" id="speciality_error">
                            @error('speciality')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                </div>

                <div class="form_btn">
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
                    <input type="reset" value="Reset">
                </div>
            </form>
        </div>
    </div>
</x-modal>
<script src="{{ asset('js/validations/admin/add_doctor_modal.js') }}"></script>
