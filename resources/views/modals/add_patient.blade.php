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
<x-modal name="add_patient" :show="$temp" id="create_doctor_modal">
    <!-- Modal content goes here -->
    <div class="items_to_hide flex justify-center  ">

        <div class="form_container bg-white dark:bg-gray-800">

            <form action="{{ route('admin.patient.add') }}" method="POST" class="form" id="form">
                @csrf
                <div class="form_title" style="font-size: 26px; font-weight: bold">
                    <h1>Add Patient</h1>
                </div>


                <div class="form_groups">
                    <div class="form_group nom_container">
                        <label for="nom">Nom Complet:</label>
                        <input type="text" name="nom" id="nom_input" placeholder="Enter Your Full Name">
                        <div class="error_input">
                            @error('nom')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form_group birthday_container">
                        <label for="birthday">Birthday:</label>
                        <input type="date" name="birthdate" id="birthday_input" placeholder="Enter Your Birthday">
                        <div class="error_input">
                            @error('birthdate')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form_groups">
                    <div class="form_group city_container">
                        <label for="city">City:</label>
                        <input type="text" name="city" placeholder="Enter Your City" id="city_input">
                        <div class="error_input">
                            @error('city')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form_group Rue_container">
                        <label for="rue">Street:</label>
                        <input type="text" name="rue" id="rue_input" placeholder="Enter Your Street">
                        <div class="error_input">
                            @error('rue')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form_groups">
                    <div class="form_group email_container">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email_input" placeholder="test@exemple.com">
                        <div class="error_input">
                            @error('email')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form_group password_container">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password_input" placeholder="Minimum 8 characters">
                        <div class="error_input">
                            @error('password')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form_groups">
                    <div class="form_group phone_container">
                        <label for="phone">Phone:</label>
                        <input type="number" name="phone" id="phone_input" placeholder="(06 / 05) 00 00 00 00">
                        <div class="error_input">
                            @error('phone')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form_group">
                        <label for="gender">Gender:</label>
                        <select name="gender" id="gender_input">
                            <option selected value="">Chose The Doctor Gender</option>

                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <div class="error_input">
                            @error('gender')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form_group">
                    <label for="gender">Cin :</label>
                    <input type="text" name="cin" id="cin_input" placeholder="Enter Patient Cin">

                    <div class="error_input">
                        @error('cin')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form_btn">
                    <button
                        class="rounded-lg mr-3  relative w-48 h-12 cursor-pointer flex items-center border border-green-500 bg-green-500 group hover:bg-green-500 active:bg-green-500 active:border-green-500">
                        <span
                            class="text-white font-semibold ml-8 transform group-hover:translate-x-30 transition-all duration-300">Add
                            Patient</span>
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
