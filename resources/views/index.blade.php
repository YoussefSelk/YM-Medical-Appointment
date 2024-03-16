<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
            overflow-x: hidden;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 12px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .heading_container {
            position: relative;
        }

        /* Absolutely position the text container */
        .heading_container .absolute {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }

        @keyframes move {
            100% {
                transform: translate3d(0, 0, 1px) rotate(360deg);
            }
        }
    </style>
    <title>YM | Medical Appointment</title>
    <script src="finisher-header.es5.min.js" type="text/javascript"></script>

</head>

<body>


    <x-home.home-navbar></x-home.home-navbar>



    <div class="main mt-10 md:mt-20 lg:mt-40  animate__animated animate__zoomIn animate__delay-2s">
        <div class=" relative   heading_container flex justify-center items-center flex-col ">

            <div class="container flex flex-col justify-center items-center text-center">

                <div class="container relative p-8 flex justify-center items-center flex-col shadow-lg">
                    <h1
                        class="mb-4 text-3xl md:text-4xl lg:text-5xl xl:text-4xl font-extrabold leading-none tracking-tight text-gray-900 dark:text-white">
                        Want To Book Your Medical Appointment, It should be easy then
                    </h1>
                    <p
                        class="mb-6 text-base md:text-lg lg:text-xl font-normal text-gray-500 md:px-16 lg:px-24 xl:px-48 dark:text-gray-400">
                        You can make an appointment by registering or logging in.
                    </p>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center justify-center px-4 md:px-5 py-3 text-base md:text-lg font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                        Make an Appointment !!!
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>

        <div class="middle mt-60  flex justify-center items-center flex-row  ">

            <div class="container p-7 flex justify-center items-center flex-col md:flex-row shadow-lg">

                <div class="content mr-4">

                    <h1
                        class="mb-4 text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-gray-900 dark:text-white">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">About
                            Us</span>
                    </h1>
                    <p class="w-80 text-base md:text-lg lg:text-xl font-normal text-gray-500 dark:text-gray-400">
                        At <strong>YM</strong>, we empower patients with the convenience to book appointments with any
                        doctor effortlessly. Our user-friendly platform seamlessly connects patients with a diverse
                        range of healthcare providers, offering unparalleled access to medical care. With just a few
                        clicks, users can schedule appointments, manage their healthcare needs, and prioritize their
                        well-being. We are committed to revolutionizing the healthcare experience by making it more
                        accessible, efficient, and patient-centric. Join us on our journey to simplify healthcare
                        booking and enhance patient outcomes.
                    </p>
                </div>
                <div class="img_container">
                    <img src="{{ asset('img/graphics.png') }}" alt="">
                </div>
            </div>



        </div>
        <div class="middle mt-12 mb-12  flex justify-center items-center flex-row ">

            <div class="container p-7 flex justify-center items-center flex-row shadow-lg">

                <div class="content mr-4 flex justify-center items-center flex-col">
                    <h1
                        class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                        How To Book An
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">Appointment</span>
                    </h1>
                    <div class="steps mt-4">

                        <ol class="items-center w-full space-y-4 sm:flex sm:space-x-8 sm:space-y-0 rtl:space-x-reverse">
                            <li
                                class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse">
                                <span
                                    class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                                    1
                                </span>
                                <span>
                                    <h3 class="font-medium leading-tight">Register</h3>
                                    <p class="text-sm">Register -></p>
                                </span>
                            </li>
                            <li
                                class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse">
                                <span
                                    class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                                    2
                                </span>
                                <span>
                                    <h3 class="font-medium leading-tight">Chose Your Doctor</h3>
                                    <p class="text-sm">Step details here</p>
                                </span>
                            </li>
                            <li
                                class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse">
                                <span
                                    class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                                    3
                                </span>
                                <span>
                                    <h3 class="font-medium leading-tight">Book An Appointment</h3>
                                    <p class="text-sm">Step details here</p>
                                </span>
                            </li>
                        </ol>


                    </div>

                </div>
            </div>



        </div>
    </div>

    <x-home.home-footer></x-home.home-footer>

</body>

</html>
