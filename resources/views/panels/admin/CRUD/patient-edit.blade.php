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
                {{ __('Edit Patient Page') }}
            </h2>

        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">


        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.patient') }}"
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
                            Patient</span>
                    </div>
                </li>
            </ol>
        </nav>

    </div>

    <div class="p-6 mt-7  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex justify-center ">
        <div class="create_doctor_modal" id="create_doctor_modal">

            <div class="form_container bg-white dark:bg-gray-800">

                <form action="{{ route('admin.patient.edit', $patient->id) }}" method="POST" class="form"
                    id="form">
                    @csrf
                    @method('PUT')
                    <div class="form_title" style="font-size: 26px; font-weight: bold">
                        <h1>Add Patient</h1>
                    </div>


                    <div class="form_groups">
                        <div class="form_group nom_container">
                            <label for="nom">Nom Complet:</label>
                            <input type="text" name="nom" value="{{ old('nom', $patient->user->name) }}"
                                id="nom_input" placeholder="Enter Your Full Name">
                            <div class="error_input">
                                @error('nom')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form_group birthday_container">
                            <label for="birthday">Birthday:</label>
                            <input type="date" name="birthdate" value="{{ old('birthdate', $patient->birth_date) }}"
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
                            <input type="text"
                                name="city"value="{{ old('city', $patient->user->address->ville) }}"
                                placeholder="Enter Your City" id="city_input">
                            <div class="error_input">
                                @error('city')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form_group Rue_container">
                            <label for="rue">Street:</label>
                            <input type="text" name="rue" value="{{ old('rue', $patient->user->address->rue) }}"
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
                            <input type="email" name="email" value="{{ old('email', $patient->user->email) }}"
                                id="email_input" placeholder="test@exemple.com">
                            <div class="error_input">
                                @error('email')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form_group">
                            <label for="cin">Cin :</label>
                            <input type="text" name="cin"value="{{ old('cin', $patient->cin) }}" id="cin_input"
                                placeholder="Enter Patient Cin">

                            <div class="error_input">
                                @error('cin')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form_groups">
                        <div class="form_group phone_container">
                            <label for="phone">Phone:</label>
                            <input type="number" name="phone" value="0{{ old('phone', $patient->user->phone) }}"
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
                                <option selected value="">Chose The Patient Gender</option>

                                <option selected value="{{ old('gender', $patient->user->gender) }}">
                                    {{ old('gender', $patient->user->gender) }}</option>
                                @if ($patient->user->gender == 'male')
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

                    <div class="form_btn">
                        <button
                            class="rounded-lg mr-3  relative w-48 h-12 cursor-pointer flex items-center border border-green-500 bg-green-500 group hover:bg-green-500 active:bg-green-500 active:border-green-500">
                            <span
                                class="text-white font-semibold ml-8 transform group-hover:translate-x-30 transition-all duration-300">Edit
                                Patient</span>
                            <span
                                class="absolute right-0 h-full w-10 rounded-lg bg-green-500 flex items-center justify-center transform group-hover:translate-x-0 group-hover:w-full transition-all duration-300">
                                <svg class="svg w-8 text-white" fill="none" height="24" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
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

    </div>
</x-admin-layout>
