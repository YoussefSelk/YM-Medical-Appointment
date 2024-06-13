# Medical Appointment Management Application ![Medical Icon](https://img.icons8.com/ios/50/000000/stethoscope.png)

This application facilitates the scheduling and management of medical appointments. It is designed to improve the efficiency and accessibility of medical services for both patients and healthcare providers.

![App Screenshot](https://via.placeholder.com/800x400)

## Table of Contents
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Features

- **User Management**: Separate panels for administrators, doctors, and patients.
- **Appointment Scheduling**: Easy scheduling, modification, and cancellation of appointments.
- **Doctor and Patient Management**: Manage doctors' and patients' profiles and their respective appointments.
- **Specialty Management**: Manage medical specialties and related doctors.
- **Notifications**: Send notifications to doctors and patients.
- **Security**: Protection against brute force attacks, XSS, SQL Injection, and CSRF attacks.

![Features Icon](https://img.icons8.com/ios/50/000000/features-list.png)

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript, Tailwind CSS, Vite.js ![Frontend Icon](https://img.icons8.com/ios/50/000000/html-5.png)
- **Backend**: PHP, Laravel ![Backend Icon](https://img.icons8.com/ios/50/000000/php.png)
- **Libraries and Frameworks**: jQuery, DataTable.js, DomPdf, Alpine.js, Chart.js, FontAwesome, Sweetalert2, jQuery UI, jQuery Migrate.js, Animate.css, UI Avatar, Laravel charts ![Libraries Icon](https://img.icons8.com/ios/50/000000/library.png)
- **Database**: MariaDB (managed through HeidiSQL) ![Database Icon](https://img.icons8.com/ios/50/000000/database.png)
- **Development Tools**: Visual Studio Code, XAMPP, Git, GitHub, Browser DevTools ![DevTools Icon](https://img.icons8.com/ios/50/000000/code.png)

## Installation

Follow these steps to set up the project on your local machine.

### Prerequisites

- PHP (>= 7.3)
- Composer
- Node.js and npm
- XAMPP (or any other LAMP stack)

### Steps

1. **Clone the repository:**
    ```sh
    git clone https://github.com/YoussefSelk/YM-Medical-Appointment.git
    cd YM-Medical-Appointment
    ```

2. **Install PHP dependencies:**
    ```sh
    composer install
    ```

3. **Install JavaScript dependencies:**
    ```sh
    npm install
    ```

4. **Set up the database:**
    - Create a database named `your_database_name`.
    - Update your `.env` file with your database credentials.

5. **Run migrations and seed the database:**
    ```sh
    php artisan migrate:fresh --seed
    ```

6. **Create a symbolic link for storage:**
    ```sh
    php artisan storage:link
    ```

7. **Clear route cache:**
    ```sh
    php artisan route:clear
    ```

8. **Start the development server:**
    ```sh
    php artisan serve
    ```

9. **Start the scheduler worker:**
    ```sh
    php artisan schedule:work
    ```

10. **Compile the assets:**
    ```sh
    npm run dev
    ```

Your application should now be running at `http://localhost:8000`.

![Installation Icon](https://img.icons8.com/ios/50/000000/installation.png)

## Usage

### Admin Panel ![Admin Icon](https://img.icons8.com/ios/50/000000/admin-settings.png)

The admin panel allows administrators to manage doctors, patients, appointments, schedules, and specialties.

### Doctor Panel ![Doctor Icon](https://img.icons8.com/ios/50/000000/doctor-male.png)

Doctors can manage their appointments, schedules, patient profiles, and view evaluations.

### Patient Panel ![Patient Icon](https://img.icons8.com/ios/50/000000/patient-oxygen-mask.png)

Patients can schedule and manage their appointments, view doctor profiles, and read health-related articles.

## Contributing

We welcome contributions from the community. Please follow these steps to contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/YourFeature`).
3. Commit your changes (`git commit -m 'Add your feature'`).
4. Push to the branch (`git push origin feature/YourFeature`).
5. Create a Pull Request.

![Contributing Icon](https://img.icons8.com/ios/50/000000/conference.png)

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

![License Icon](https://img.icons8.com/ios/50/000000/license.png)
