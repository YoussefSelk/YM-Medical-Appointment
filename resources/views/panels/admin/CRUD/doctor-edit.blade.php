<style>
    .form_container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: white;
        padding: 20px;
        border-radius: 10px;

        width: 600px;
        height: 600px;
        margin-bottom: 10px;
    }

    .form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .form_group {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form_group input {
        width: 270px;
        padding: 5px;
        margin-bottom: 7px;
        border-radius: 5px;
        border: 1px solid gray;
    }

    .form_group select {
        width: 270px;
        padding: 6px;
        margin-bottom: 7px;
        border-radius: 5px;
        border: 1px solid gray;
    }

    .form_title {
        font-size: 18px;
        text-align: center;
        margin-bottom: 10px;
    }

    .form_btn {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin-top: 20px;
    }

    .form_btn input[type="submit"] {
        padding: 10px;
        width: 150px;
        border-radius: 7px;
        border: none;
        background-color: rgb(39, 162, 255);
        color: rgb(227, 241, 255);
        z-index: 0;
        transition: 0.3s;
        cursor: pointer;
        font-size: 18px;
        margin-right: 10px;
    }

    .form_btn input[type="reset"] {
        padding: 10px;
        width: 150px;
        border-radius: 7px;
        border: none;
        background-color: rgba(0, 0, 0, 0.541);
        color: rgb(255, 255, 255);
        z-index: 0;
        transition: 0.3s;
        cursor: pointer;
        font-size: 18px;
        margin-right: 10px;
    }

    .form_btn input[type="submit"]:hover {
        background-color: rgb(0, 145, 255);
    }

    .form_btn input[type="reset"]:hover {
        background-color: rgba(0, 0, 0, 0.6);
    }

    .form_groups {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-around;
        width: 100%;
    }
</style>
<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight ">
                {{ __('Edit Doctor Page') }}
            </h2>

        </div>
    </x-slot>
    <x-success-flash></x-success-flash>
    <x-error-flash></x-error-flash>
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.doctor') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Doctor
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Edit
                            Doctor</span>
                    </div>
                </li>
            </ol>
        </nav>

    </div>

    <div class="p-6 mt-7  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center ">
        <div class="create_doctor_modal" id="create_doctor_modal">



            <div class="form_container">

                <form action="{{ route('admin.doctor.edit', $doctor->id) }}" method="POST" class="form"
                    id="form">
                    @csrf
                    @method('PUT')
                    <h2 class="text-4xl font-semibold leading-tight mb-10">
                        {{ __('Edit Doctor') }}
                    </h2>


                    <div class="form_groups">
                        <div class="form_group nom_container">
                            <label for="nom">Nom Complet:</label>
                            <input type="text" name="nom" value="{{ old('nom', $doctor->user->name) }}"
                                id="nom_input" placeholder="Enter Your Full Name">
                            <div class="error_input">
                                @error('nom')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form_group birthday_container">
                            <label for="birthday">Birthday:</label>
                            <input type="date" value="{{ old('birthdate', $doctor->birth_date) }}" name="birthdate"
                                id="birthday_input" placeholder="Enter Your Birthday">
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
                            <input type="text" value="{{ old('city', $doctor->user->address->ville) }}"
                                name="city" placeholder="Enter Your City" id="city_input">
                            <div class="error_input">
                                @error('city')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form_group Rue_container">
                            <label for="rue">Street:</label>
                            <input type="text" value="{{ old('rue', $doctor->user->address->rue) }}" name="rue"
                                id="rue_input" placeholder="Enter Your Street">
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
                            <input type="email" name="email" value="{{ old('email', $doctor->user->email) }}"
                                id="email_input" placeholder="test@exemple.com">
                            <div class="error_input">
                                @error('email')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form_group password_container hidden">
                            <label for="password">Password:</label>
                            <input type="password" value="{{ old('password') }}" name="password" id="password_input"
                                placeholder="Minimum 8 characters">
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
                            <input type="number" name="phone" value="0{{ old('phone', $doctor->user->phone) }}"
                                id="phone_input" placeholder="(06 / 05) 00 00 00 00">
                            <div class="error_input">
                                @error('phone')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form_group">
                            <label for="gender">Gender:</label>
                            <select name="gender" id="gender_input">
                                <option value="">Chose The Doctor Gender</option>
                                <option selected value="{{ old('gender', $doctor->user->gender) }}">
                                    {{ old('gender', $doctor->user->gender) }}</option>
                                @if ($doctor->user->gender == 'male')
                                    <option value="female">Female</option>
                                @else
                                    <option value="male">Male</option>
                                @endif
                            </select>
                            <div class="error_input">
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
                                <option value="">Chose The Doctor Degree</option>
                                <option selected value="{{ old('degree', $doctor->degree) }}">
                                    {{ old('degree', $doctor->degree) }}</option>

                                <option value="MD">Doctor of Medicine (MD)</option>
                                <option value="DO">Doctor of Osteopathic Medicine (DO)</option>
                                <option value="MBBS">Bachelor of Medicine, Bachelor of Surgery (MBBS)</option>
                                <option value="BDS">Bachelor of Dental Surgery (BDS)</option>
                                <option value="DMD">Doctor of Dental Medicine (DMD)</option>
                                <option value="DDS">Doctor of Dental Surgery (DDS)</option>
                                <option value="DPM">Doctor of Podiatric Medicine (DPM)</option>
                                <option value="PharmD">Doctor of Pharmacy (PharmD)</option>
                                <option value="DPT">Doctor of Physical Therapy (DPT)</option>
                                <option value="DVM">Doctor of Veterinary Medicine (DVM)</option>
                                <option value="MD-PhD">Doctor of Medicine, Doctor of Philosophy (MD-PhD)</option>
                                <option value="MS">Master of Surgery (MS)</option>
                                <option value="MCh">Master of Chirurgery (MCh)</option>
                                <option value="MDS">Master of Dental Surgery (MDS)</option>
                                <option value="DC">Doctor of Chiropractic (DC)</option>
                                <option value="DSc">Doctor of Science (DSc)</option>
                                <option value="EdD">Doctor of Education (EdD)</option>
                                <option value="PsyD">Doctor of Psychology (PsyD)</option>
                                <option value="JD">Doctor of Jurisprudence (JD)</option>
                                <option value="DrPH">Doctor of Public Health (DrPH)</option>
                            </select>
                            <div class="error_input">
                                @error('degree')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="form_group">
                            <label for="speciality">Speciality:</label>

                            <select name="speciality" id="speciality_input">
                                <option value="">Chose The Doctor Speciality</option>
                                <option selected value="{{ old('speciality', $doctor->speciality->id) }}">
                                    {{ old('speciality', $doctor->speciality->name) }}</option>
                                @foreach ($specialities as $speciality)
                                    @if ($speciality->name == $doctor->speciality->name)
                                    @endif
                                    <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                                @endforeach
                            </select>
                            <div class="error_input">
                                @error('speciality')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="form_btn">
                        <input type="submit" value=" Edit Doctor">
                        <input type="reset" value="Reset">
                    </div>
                </form>
            </div>

        </div>

    </div>
</x-admin-layout>
