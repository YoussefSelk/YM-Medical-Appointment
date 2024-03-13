<head>
    <link rel="stylesheet" href="{{ asset('css/add_doctor_modal.css') }}">
    <script src="{{ asset('js/add_doctor_modal.js') }}"></script>
</head>

<div class="create_doctor_modal hidden" id="create_doctor_modal">
    <div class="items_to_hide ">

    
    <div class="close_modal">
        <button onclick="closeModal()">X</button>
    </div>
    <div class="form_container">
        <form action="" method="POST" class="form" id="form">
            <div class="form_title">
                <h1>Add Doctor</h1>
            </div>


            <div class="form_groups">
                <div class="form_group nom_container">
                    <label for="nom">Nom Complet:</label>
                    <input type="text" name="nom" id="nom_input" placeholder="Enter Your Full Name">
                </div>
                <div class="form_group birthday_container">
                    <label for="birthday">Birthday:</label>
                    <input type="date" name="birthdate" id="birthday_input" placeholder="Enter Your Birthday">
            </div>
            </div>
            <div class="form_groups">
                <div class="form_group city_container">
                        <label for="city">City:</label>
                        <input type="text" name="city" placeholder="Enter Your City" id="city_input">
                </div>
                <div class="form_group Rue_container">
                        <label for="rue">Street:</label>
                        <input type="text" name="rue" id="rue_input" placeholder="Enter Your Street">
                </div>
            </div>
            <div class="form_groups">
                <div class="form_group email_container">
                    <label for="email">Email:</label>
                    <input type="email" name="email"  id="email_input" placeholder="test@exemple.com">
                </div>

                <div class="form_group password_container">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password_input" placeholder="Minimum 8 characters">
                </div>
            </div>

            <div class="form_groups">
                <div class="form_group phone_container">
                    <label for="phone">Phone:</label>
                    <input type="number" name="phone" id="phone_input" placeholder="(06 / 05) 00 00 00 00">
                </div>

                <div class="form_group">
                    <label for="gender">Gender:</label>
                    <select name="gender" id="gender_input">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>

            <div class="form_groups">
                <div class="form_group degree_container">
                    <label for="degree">Degree:</label>
                    <select name="degree" id="degree_input">
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
                </div>


                <div class="form_group">
                    <label for="speciality">Speciality:</label>

                    <select name="speciality" id="speciality_input">
                        
                    </select>

                </div>
                
            </div>
            
            <div class="form_btn">
                <input type="submit" value="+ Add Doctor">
                <input type="reset" value="Reset">
            </div>
        </form>
    </div>
</div>
</div>