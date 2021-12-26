<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Landing</title>

        <!-- Font Family -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

        <!-- CSS -->
        <link rel="stylesheet" href="./css/output.css?v=4" />

        <!-- Javascript -->
        <script src="./js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="./js/script.js"></script>

        
    </head>
    <body class="bg-gray-soft">
        <!-- Hero -->
        <div class="bg-hero-landing h-[720px] sm:h-[800px] lg:h-[750px] pt-24">
            <!-- Navbar -->
            <nav id="navbar-landing" class="navbar-landing">
                <div class="nav-content">
                    <div class="nav-left-side">
                        <a href="./"><img class="w-14 h-14" src="./img/icons/logo_oembah_putih.svg" alt="logo_oembah" /></a>
                    </div>
                    <div class="nav-right-side">
                        <div class="hidden lg:block">
                            <ul class="nav-links">
                                <li class="nav-landing-link"><a href="#">Service</a></li>
                                <li class="nav-landing-link"><a href="#">Partner</a></li>
                                <li class="nav-landing-link"><a href="#">Blog</a></li>
                                <li class="nav-landing-link"><a href="#">About</a></li>
                                <li class=""><a class="px-4 py-2 bg-gold-yellow hover:bg-yellow-600 text-dark-blue font-semibold rounded" href="./page/login.php">Masuk</a></li>
                            </ul>
                        </div>
                    </div>
                    <a id="toggle-menu" class="flex lg:hidden"><img class="w-8 h-8 p-1 border-2 border-gray-400 rounded-lg" src="./img/icons/menu_icon_putih.svg" alt="Menu Icon" /></a>
                </div>
                <div id="item-menu-mobile" class="top-20 absolute w-full bg-hero hidden lg:hidden drop-shadow-lg">
                    <hr class="border border-gray-400 mt-4 w-11/12 mx-auto" />
                    <ul class="relative mobile-links">
                        <li class="landing-mobile-link"><a href="#">Service</a></li>
                        <li class="landing-mobile-link"><a href="#">Partner</a></li>
                        <li class="landing-mobile-link"><a href="#">Blog</a></li>
                        <li class="landing-mobile-link"><a href="#">About</a></li>
                        <li class="my-5"><a class="px-4 py-2 bg-gold-yellow hover:bg-yellow-600 text-dark-blue font-semibold rounded" href="./page/login.php">Masuk</a></li>
                    </ul>
                </div>
            </nav>

            <!-- Hero Content -->
            <div class="flex flex-col lg:flex-row items-center mx-auto w-10/12 xl:w-8/12 justify-between mt-10 space-y-10">
                <div class="flex flex-col space-y-6">
                    <h1 class="text-white text-[1.5rem] font-bold leading-relaxed text-center lg:text-left sm:text-[1.875rem] md:text-[2.25rem] xl:text-[2.5rem]">
                        Easiest way to get <br />
                        your laundry service
                    </h1>
                    <p class="text-white leading-relaxed text-center text-[0.875rem] sm:text-[1.125rem] lg:text-left">
                        Oembah is website that will connect you <br />
                        with the best laundry around you
                    </p>
                    <a class="w-[150px] py-3 rounded text-center bg-gold-yellow hover:bg-yellow-600 text-dark-blue font-semibold mt-10 mx-auto lg:mx-0" href="">Get Started</a>
                </div>
                <div>
                    <img class="w-[275px] h-[225px] sm:w-[300px] sm:h-[250px] lg:w-[440px] lg:h-[400px]" src="./img/icons/hero_person.svg" alt="" />
                </div>
            </div>
        </div>

        <!-- Services -->
        <div class="w-9/12 mx-auto mt-20">
            <p class="text-center text-lg text-dark-blue">SERVICES</p>
            <h1 class="text-center text-3xl text-dark-blue font-bold">Find Your Service</h1>
            <div class="w-full lg:w-10/12 mx-auto flex flex-col lg:flex-row lg:gap-x-20 gap-y-16 justify-center mt-10">
                
                <!-- Left Side Service -->
                <div class="item grid grid-rows-4 lg:grid-rows-2 grid-flow-col gap-10">
                    <div class="mx-auto">
                        <div id="btn-clothes" class="text-center flex flex-col rounded-lg justify-center text-dark-blue bg-white w-[200px] h-[200px] space-y-4 cursor-pointer shadow-lg">
                            <img class="w-20 mx-auto" src="./img/icons/clothes_icon.svg" alt="" />
                            <a class="font-semibold">Clothes Laundry</a>
                        </div>
                    </div>
                    <div class="mx-auto">
                        <div id="btn-helmet" class="text-center flex flex-col rounded-lg justify-center text-dark-blue bg-white w-[200px] h-[200px] space-y-4 cursor-pointer">
                            <img class="w-20 mx-auto" src="./img/icons/helm_icon.svg" alt="" />
                            <a class="font-semibold">Helmet Laundry</a>
                        </div>
                    </div>
                    <div class="mx-auto">
                        <div id="btn-shoes" class="text-center flex flex-col rounded-lg justify-center text-dark-blue bg-white w-[200px] h-[200px] space-y-4 cursor-pointer">
                            <img class="w-20 mx-auto" src="./img/icons/shoes_icon.svg" alt="" />
                            <a class="font-semibold">Cleaning Shoes</a>
                        </div>
                    </div>
                    <div class="mx-auto">
                        <div id="btn-hotel" class="text-center flex flex-col rounded-lg justify-center text-dark-blue bg-white w-[200px] h-[200px] space-y-4 cursor-pointer">
                            <img class="w-20 mx-auto" src="./img/icons/hotel_icon.svg" alt="" />
                            <a class="font-semibold">Hotel Laundry</a>
                        </div>
                    </div>
                </div>

                <!-- Right Side Service  -->
                <div id="clothes" class="text-right space-y-4">
                    <img class="w-[480px] h-[220px]" src="./img/clothes.jpg" alt="" />
                    <h1 class="text-left text-dark-blue font-semibold">Clothes Laundry</h1>
                    <p class="text-left text-dark-blue text-sm">
                        You can choose this to clean your <span class="underline">clothes</span> and <span class="underline">linens</span> that need to be washed or that have been newly washed.
                    </p>
                </div>
                <div id="shoes" class="text-right space-y-4">
                    <img class="w-[480px] h-[220px]" src="./img/cleaning_shoes.jpg" alt="" />
                    <h1 class="text-left text-dark-blue font-semibold">Cleaning Shoes</h1>
                    <p class="text-left text-dark-blue text-sm">
                        You can choose this to clean your <span class="underline">shoes</span> and <span class="underline">sandals</span> that need to be washed or that have been newly washed.
                    </p>
                </div>
                <div id="helmet" class="text-right space-y-4">
                    <img class="w-[480px] h-[220px]" src="./img/helmet_laundry.jpg" alt="" />
                    <h1 class="text-left text-dark-blue font-semibold">Helmet Laundry</h1>
                    <p class="text-left text-dark-blue text-sm">You can choose this to clean your <span class="underline">helmet</span> that need to be washed or that have been newly washed.</p>
                </div>
                <div id="hotel" class="text-right space-y-4">
                    <img class="w-[480px] h-[220px]" src="./img/hotel_laundry.jpg" alt="" />
                    <h1 class="text-left text-dark-blue font-semibold">Hotel Laundry</h1>
                    <p class="text-left text-dark-blue text-sm">
                        You can choose this to clean your <span class="underline">hotel equipment</span> that need to be washed or that have been newly washed.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card AboutUs -->
        <div class="bg-[#4914D9] mt-24">
            <div class="w-10/12 mx-auto flex flex-col-reverse lg:flex-row items-center gap-x-20 justify-center py-10 text-center lg:text-left">
                <div class="pt-16">
                    <img class="w-[400px] h-[300px] lg:w-[500px] lg:h-[400px]" src="./img/icons/about_card.svg" alt="" />
                </div>
                <div class="flex flex-col space-y-4">
                    <p class="text-white">ABOUT US</p>
                    <h1 class="text-white text-3xl font-bold">Welcome to Oembah</h1>
                    <p class="text-white">
                        Oembah is one platform who help you manage <br />
                        your laundry and make it easier to find
                    </p>
                    <a class="w-[150px] py-3 rounded text-center bg-gold-yellow hover:bg-yellow-600 text-dark-blue font-semibold mt-10 mx-auto lg:mx-0" href="#">Learn more</a>
                </div>
            </div>
        </div>

        <!-- Join -->
        <div class="my-36">
            <p class="text-center text-lg text-dark-blue">PARTNER</p>
            <h1 class="text-center text-3xl text-dark-blue font-bold">Let's Join Us</h1>
            <div class="bg-join w-full">
                <div class="mx-auto py-16 w-9/12 flex flex-col lg:flex-row justify-center gap-x-24 gap-y-10 items-center mt-10">
                    <div onclick="location.href='#'" class="text-center flex flex-col shadow-xl rounded-lg justify-center text-dark-blue bg-white w-[200px] h-[200px] space-y-4 cursor-pointer">
                        <img class="w-20 mx-auto" src="./img/icons/user_join_icon.svg" alt="" />
                        <a class="font-semibold">User</a>
                    </div>
                    <div onclick="location.href='#'" class="text-center flex flex-col shadow-xl rounded-lg justify-center text-dark-blue bg-white w-[200px] h-[200px] space-y-4 cursor-pointer">
                        <img class="w-20 mx-auto" src="./img/icons/merchant_join_icon.svg" alt="" />
                        <a class="font-semibold">Merchant</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer>
            <div class="footer-container">
                <div class="footer-links">
                    <div>
                        <img class="w-14 h-14" src="./img/icons/logo_oembah.svg" alt="logo_oembah" />
                        <p class="text-dark-blue mt-2">Tak lagi takut kehabisan baju di musim hujan!</p>
                    </div>
                    <div class="footer-items">
                        <div>
                            <h1 class="text-dark-blue font-semibold">OEMBAH LAUNDRY</h1>
                            <ul class="grid grid-cols-1 xl:grid-cols-2 gap-x-4 gap-y-2 mt-4">
                                <li><a class="footer-item" href="#">Tentang Kami</a></li>
                                <li><a class="footer-item" href="#">Mitra Oembah</a></li>
                                <li><a class="footer-item" href="#">Pusat Bantuan</a></li>
                                <li><a class="footer-item" href="#">Blog Oembah</a></li>
                                <li><a class="footer-item" href="#">Booking Laundry</a></li>
                            </ul>
                        </div>
                        <div>
                            <ul>
                                <h1 class="text-dark-blue font-semibold">KEBIJAKAN</h1>
                                <div class="grid grid-cols-1 gap-x-4 gap-y-2 mt-4">
                                    <a class="footer-item" href="#">Kebijakan Privasi</a>
                                    <a class="footer-item" href="#">Syarat dan Ketentuan Umum</a>
                                </div>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-dark-blue font-semibold">HUBUNGI KAMI</h1>
                            <div class="grid grid-col-1 gap-x-4 gap-y-2 mt-4 text-sm">
                                <a class="footer-contacts" href="#">
                                    <img class="w-5" src="./img/icons/mail_icon.svg" alt="Logo Email" />
                                    <span>cs@oembah.xyz</span>
                                </a>

                                <a class="footer-contacts" href="#">
                                    <img class="w-5" src="./img/icons/call_icon.svg" alt="Logo Call" />
                                    <span>021-345-678-90</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border border-gray-300" />

                <div class="footer-copyright">
                    <div class="flex items-center space-x-2">
                        <img class="w-4" src="./img/icons/copyrigth_icon.svg" alt="" />
                        <p class="text-dark-blue text-sm">Oembah.xyz, All rights reserved</p>
                    </div>
                    <div class="flex items-center space-x-8">
                        <a href="#"><img class="w-7" src="./img/icons/fb_icon.svg" alt="Icon Facebook" /></a>
                        <a href="#"><img class="w-7" src="./img/icons/instagram_icon.svg" alt="Icon Instagram" /></a>
                        <a href="#"><img class="w-7" src="./img/icons/youtube_icon.svg" alt="Icon Youtube" /></a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
