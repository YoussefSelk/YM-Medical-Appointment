{{-- <!DOCTYPE html>
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
    <link rel="icon" type="image/png" href="{{ asset('img/app-logo.png') }}">

</head>

<body>


    <x-home.home-navbar></x-home.home-navbar>



    <div class="main mt-10 md:mt-20 lg:mt-10  ">
        <div class=" relative   heading_container flex justify-center items-center flex-col ">

            <div class="container flex flex-row justify-center items-center text-center">

                <div class="container  p-8 flex justify-center items-center flex-col ">
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
                <div>
                    <img src="{{ asset('img/banner-img.png') }}" alt="app logo" class="w-100">
                </div>
            </div>
        </div>
        <div class="middle mt-12 mb-12  flex justify-center items-center flex-row ">

            <div class="container p-7 flex justify-center items-center flex-row ">

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
        <div class="middle mt-30  flex justify-center items-center flex-row  ">

            <div class="container p-7 flex justify-center items-center flex-col md:flex-row ">

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

    </div>

    <!--End of Tawk.to Script-->
    <x-home.home-footer></x-home.home-footer>

</body>

</html>

 --}}




{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>



<style>
body{
  width: 100%;
  font-family: sans-serif;
  height: 100%;
  margin: 0;
  padding: 0;
}
header{
  position: fixed;
  top:
  padding: 25px; 15px;
  height: 60px;
  display: flex;
  justify-content: space-between;
  align-item: center;
  background-color: black;
  width: 100%;
  opacity: 0.7;
  z-index: 5;
  font-size: 1.2rem;

}
.container h3{
  font-size: 1.9rem;


}
a{
  color: white;
  position: relative;
  top: 0.8rem;
}

a:hover{
  text-decoration: underline;
   filter: brightness(150%);
  filter: drop-shadow(8px 8px 10px white);

}
.company-img {
  background: url(https://miro.medium.com/max/1000/1*QYN28tTOSwsnnfSK4H2iZg.jpeg);
  background-repeat: no-repeat;
  background-size: cover;
  background-positon: center;
  position: relative;
  height: 800px;
  justify-content: center;
  width: 100%;
}
.company-img::before{
 content: "";
 position: absolute;
 top: 0;
 width: 100%;
 height: 100%;
 background: rgba(0,0,0,0.95);
 opacity: 0.9;
}



#shop{
  width: 100%;
  height: 1100px;
  background-color:  #808080;
  position: relative;
  bottom: 2.1rem;
}
#images{
   display: grid;
  grid-auto-flow: column;
  gap: 33.3%;
  text-align: center;
  margin-top: 7em;
}
.logo-image-1{
  margin-left: 1em;
}
.logo-image-3{
  position: relative;
  bottom: 0.8rem;
  margin-right: 3em;
}
.img-1,.img-2,.img-3{
  border-radius: 50px;
}

.last-layer-img{
  margin-top: 5.5rem;
  margin-left: 30rem;
}
.layer-caption{
  text-align: right;
  font-size: 1.5rem;
  position: relative;
  bottom: 11em;
  padding-right: 10em;
  font-size: 2.3em;
  font-family: sans-serif;
  font-weight: 200;
}
.offer{
  text-align: center;
  font-size: 2.5rem;
  text-transform: uppercase;
  color: white;
  position: relative;
  top: 1em;
  font-family: sans-serif;
}
.product-label{
  text-transform: uppercase;
  font-family: sans-serif;
  font-size: 1rem;
  color: white;
}
.product-label-2{
  font-size: 1.2rem;
  font-family: sans-serif;
  line-height: 1.5rem;
}
.landing-page{
  text-align: center;
  position: relative;
  top: 6.5em;
  font-size: 2.68rem;
  margin: auto;
  color: white;
  font-weight: 400;
}
h2{
  font-size: 2.5rem;
  font-family: sans-serift;
  text-transform: capitalize;
  font-weight: 200;
}
 .description{
  color: white;
   text-align: center;
   margin-top: 15em;
   position: relative;
   font-family: sans-serif;
   font-size: 1.5rem;
}
.container {
    align-self: center;
    background-color: #4E5254;
    border-radius: 3rem;
    color: #F2F2F2;
    font-size: 1.2rem;
    padding: 0.02rem 0.1rem;
    width: 21rem;
    margin: auto;
    position: relative;
    top: 5em;
    left: 1rem;
    cursor: pointer;
}

.container:hover{
  transform: scale(0.9);
}
#shop{
  justify-content: space-between;

}


#our-story{
 display: flex;
  flex-direction: column;
  background: #808080;
  right: 0;
  width: 100%;
  height: 1000px;
}

h3{
font-size: 3.3rem;
font-family: sans-serif;
text-transform: capitalize;
padding: -10rem 0rem 0rem;
margin-left: 5.5rem;
}


cite {
    align-self: flex-end;
    margin: 0 30px 10% 0;
    text-align: right;

}

#our-quote{
  display: flex;
  flex-direction: column;
  justify-content: center;
  max-width: 500px;
  margin: -17.5rem 45rem;
  font-size: 1.2rem;

}
@media(min-width: 570px)
  #our-quote{
    max-width: 60px;
}
blockquote{
margin: 0rem 2rem 2rem;
 padding: 0;
}
blockquote p{
  font-style: italic;
  margin-bottom: 1rem;
}

#our-story{
    display: flex;
    flex-direction: column;
    height:600px;
    width:100%;
    position:relative;
    background:white;
}
#our-story::after, #our-story::before {
    height:100vh;
    content:' ';
    position: absolute;
    right: 0;
    width: 40%;
}
#our-story::before {
    right: 0;
    background-color: hsl(200, 10%, 60%);
    height: 100%;

}
#contact-us{
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 1200px;
  background: #807060;
}
iframe{
  max-width: 500px;
  width: 100%;

}
.my-video{
 margin: 0rem 4rem;
}
#name,#email,#age,#submit{
  display: flex;
  flex-direction: column;
  width: 37%;
  height: 33px;
  padding-top: 3px;
  margin-bottom: 15px;
  font-size: 1.1rem;
}

#message{
  width: 37.1%;
  font-size: 1.1rem;
}
#submit{
  width: 120px;
  border-radius: 50px;
  font-size: 1.5rem;
  position: relative;
  top: 2em;
}
#form{
  margin-left: 4%;
  margin-top: 3%;
}

#contact-here{
  margin-left: 4%;
}
.privacy p{
 font-size: 5rem;
}
.privacy p{
  font-size: 1rem;
  max-width: 36.5%;
  margin-top: 7rem;
  margin-left: 5%;
}
.our-details{
  display: flex;
  flex-direction: column;
  margin: 0 auto;
  padding-left: 20%;
  position: relative;
  bottom: 45.9em;
  font-size: 1.2rem;
}


#reach p{
 padding-left: 5%;
  font-size: 1.5rem;
  font-family: helevicta;

}
h6{
  text-transform: uppercase;
  color: white;
  font-size: 2.1rem;
  text-align: center;
  position: relative;
  bottom: 26.7em;
  padding-left: 7%;

}
h2,h4,h5{
font-size: 1.5rem;

}
h2{
  font-weight: bold;
  font-size: 1.7rem;
  text-transform: capitalize;
}
#contact{
  color: white;
  font-size: 1.9rem;
  font-weight: bold;
  text-transform: uppercase;
}
#contact-here p{
 font-size: 1.3rem;
 font-weight: bold;
 padding-bottom: -2em;
}
#contact-here {
  position: relative;
  top: 2em;
}
#submit{
background-color: #807060;
    border: 1px solid #F2F2F2;
    border-radius: 3rem;
    color: #F2F2F2;
    font-weight: 500;
    font-size: 1.2rem;
    text-align: center;
    width: 8rem;
    padding-left: 1.5rem;
    position: relative;
    left: 3em;
    cursor: pointer;
}
#submit:hover{
  transform: scale(1.1);
}
#footer{
  background-color:  #808080;
  text-align: center;
  font-size: 1.6rem;
 1 font-family: helevicta;
}
#reach p{
font_size: 1rem;
}
} /* end of media query */
</style>

</head>
<body>

</body>




    <x-home.home-navbar></x-home.home-navbar>


  <main>

    <section id="about-us">
      <div class="company-img">
        <div class="cta-banner">
          <div class="cta-wrapper">
            <strong>
              <h1 class="landing-page">Health-line Landing page </h1>
            </strong>
            <h2 class="description"> Experiencing the unprecented beauty of quality health only at Health-line,<br>we offer the best services available... </h2>

          </div>
        </div>
      </div>
    </section>

    <section id="shop">
      <h2 class="offer"> What we offer </h2>
      <div id="images">
        <div class="logo-image-1">
          <img class="img-1" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdGWg5zPTc1VDbKwYUILoh4vdZBzS_6gm_sQ&usqp=CAU" width="157px" height="115px">
          <p class="product-label"><strong> offering quality health-care </strong> </p>
          <p class="product-label-2"> Health-line main priority is to ensure it's patients gets the best treatments available, Our doctors and nurses are 100% commited in ensuring you get the best treatments. </p>
        </div>
        <div class="logo-image-2">
          <img class="img-2" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRdy7Bc8EStU7cZds-q1R5UuOz47k2sLlOJlw&usqp=CAU" height="110px">
          <p class="product-label"><strong> Daily health-tracking </strong> </p>
          <p class="product-label-2"> Health-line proffesionals do help in monitoring and tracking your health activities day to day,We are fully indebted to such course and we are 100% active in monitoring your health progress. </p>
        </div>
        <div class="logo-image-3"> <img class="img-3" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSTxFbkqWpAowtVjtXK2BZ9Tuq9nmnG34wCvg&usqp=CAU" height="115px">
          <p class="product-label"><strong> 24/7 Medical attention </strong> </p>
          <p class="product-label-2"> Health-line assures you of all round the clock quality health services , we make sure we are always available to attend to you no matter the time or incoveniences. </p>
        </div>
      </div>

    </section>




    <section id="contact-us">
      <div id="contact-here">
        <h4 id="contact"> Contact-us </h4>
        <p> Reach out to us here </p>
      </div>
      <form id="form" action="https://www.freecodecamp.com/email-submit">
        <label for="name">Name:</label>
        <input id="name" type="email" placeholder="Enter your name" </input>
        <label for="email">Email:</label>
        <input id="email" name="email" type="email" placeholder="Enter your email adress"></input>
        <label for="age">Age: </label>
        <input id="age" type="number" min="5" max="99" placeholder="Enter your age" </input>
        <textarea id="message" name="message" placeholder="Message us...." rows="10"></textarea>
        <input type="submit" id="submit" class="submit" value="submit" </input>

      </form>
      </div>
      <div class="privacy">
        <p>We are 100% committed to your privacy and will use the information you provide us solely to contact you about relevant content and services. For more information, please read our Privacy Policy.</p>
      </div>

      <div id="reach">
        <h6> WANT TO REACH OUT TO US ? </h6>
        <p> Our team are online 24/7 </p>
      </div>
      <div class="our-details">
        <div class="phone-us">
          <h2> Call us here: </h2>
          <p> 08089670928 </p>
        </div>
        <div class="our-email">
          <h4> Email us here: </h4>
          <p> Email us at Joexef87@gmail.com </p>
        </div>
        <div class="message-us">
          <h5> Message us: </h5>
          <p> Send us a message through our contact form. </p>
        </div>
      </div>
    </section>

    <footer>

      <p class="copyright"> Copyright &copy; 2022. All rights reserved. </p>
    </footer>

    </body>

</html> --}}
