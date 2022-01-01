<?php 
require 'functions.php';
session_start();

if(checkCookie($_COOKIE) === true) {
    $_SESSION['admin'] = $_COOKIE['admin_email'];
}

if(!isset($_SESSION['admin'])){
    header('location: login.php');
}

$laundry = getLaundryProfile($_SESSION['admin']);

$orders = getTotalOrders($_SESSION['admin']);

$transactions = getAllTransactions($_SESSION['admin']);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard</title>

        <!-- Font Family -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
        <script src="./js/script.js"></script>

        <link rel="stylesheet" href="./css/output.css" />
    </head>
    <body>
        <div class="flex flex-row">
            <!-- Sidebar -->

            <nav id="navbar" class="bg-dark-blue px-4 py-8 h-screen w-[60px] fixed left-0 top-0 z-10 transition-all duration-150 ease-in-out">
                <div class="flex items-center gap-x-4 text-white cursor-pointer">
                    <img id="open-menu" class="w-7 flex" src="./img/icons/menu_icon.svg" alt="Menu Icon" />
                    <span class="nav-link hidden font-bold">OEMBAH</span>
                </div>
                <ul class="flex flex-col gap-y-8 mt-10">
                    <li title="Dashboard">
                        <a class="flex items-center gap-x-4 text-white" href="./">
                            <img class="w-7" src="./img/icons/home_icon.svg" alt="Dashboard Icon" />
                            <span class="nav-link hidden">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-4 text-white" href="#">
                            <img class="w-7" src="./img/icons/statistic_icon.svg" alt="Statistic Icon" />
                            <span class="nav-link hidden">Statistik</span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-4 text-white" href="profile.php">
                            <img class="w-7" src="./img/icons/profile_icon.svg" alt="Profile Icon" />
                            <span class="nav-link hidden">Profile</span>
                        </a>
                    </li>
                </ul>
                <div>
                    <a class="absolute bottom-4 flex items-center gap-x-4 text-white" href="logout.php">
                        <img class="w-7" src="./img/icons/logout_icon.svg" alt="Logout Icon" />
                        <span class="nav-link hidden">Keluar</span>
                    </a>
                </div>
            </nav>

            <!-- Overlay -->
            <div id="overlay" class="bg-dark-blue bg-opacity-50 absolute inset-0 hidden"></div>

            <!-- Content -->
            <main class="w-full bg-gray-soft ml-[3.7rem] h-screen px-2 overflow-y-scroll">
                <div class="flex">
                    <a class="ml-auto flex items-center pt-4 pr-4 gap-x-4" href="profile.php">
                        <h1 class="text-dark-blue font-semibold"><?= $laundry['nama_laundry'];?></h1>
                        <img class="h-14" src="https://cdn.pixabay.com/photo/2017/06/13/12/54/profile-2398783_960_720.png" alt="" />
                    </a>
                </div>

                <hr class="w-full mt-4 my-10" />

                <div class="w-10/12 mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 auto-cols-auto mt-4 gap-x-4 gap-y-4">
                    <a class="text-center text-white text-sm lg:text-base font-semibold bg-dark-blue rounded-md py-4" href="page/order_in.php">ORDER IN</a>
                    <a class="text-center text-white text-sm lg:text-base font-semibold bg-dark-blue rounded-md py-4" href="page/on_process.php">PROCESS </a>
                    <a class="text-center text-white text-sm lg:text-base font-semibold bg-dark-blue rounded-md py-4" href="page/send_order.php">SEND ORDER</a>
                    <a class="text-center text-white text-sm lg:text-base font-semibold bg-dark-blue rounded-md py-4" href="page/on_delivery.php">ON DELIVERY</a>
                    <a class="text-center text-white text-sm lg:text-base font-semibold bg-dark-blue rounded-md py-4" href="page/order_finish.php">FINISH</a>
                </div>

                <div class="w-10/12 mx-auto mt-8 flex flex-col gap-y-4">
                    <h1 class="text-dark-blue text-2xl font-semibold">Summary</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-2">
                        <div class="flex items-center bg-blue-800 p-4 gap-x-6 rounded-lg justify-center">
                            <img class="w-14" src="./img/icons/order_icon.svg" alt="" />
                            <ul class="text-white">
                                <h1 class="text-4xl font-semibold text-center"><?= sizeof($orders);?></h1>
                                <h2 class="text-sm lg:text-base">Total Pesanan</h2>
                            </ul>
                        </div>
                        <div class="flex items-center bg-green-600 p-4 gap-x-6 rounded-lg justify-center">
                            <img class="w-14" src="./img/icons/transaction_icon.svg" alt="" />
                            <ul class="text-white">
                                <h1 class="text-4xl font-semibold text-center"><?= sizeof($transactions);?></h1>
                                <h2 class="text-sm lg:text-base">Total Transaksi</h2>
                            </ul>
                        </div>
                        <div class="flex items-center bg-pink-600 p-4 gap-x-6 rounded-lg justify-center">
                            <img class="w-14" src="./img/icons/customer_icon.svg" alt="" />
                            <ul class="text-white">
                                <h1 class="text-4xl font-semibold text-center">035</h1>
                                <h2 class="text-sm lg:text-base">Total Pelanggan</h2>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="w-10/12 mx-auto my-10 gap-y-4 flex flex-col">
                    <h1 class="text-dark-blue text-2xl font-semibold">Tabel Transaksi</h1>

                    <div class="overflow-x-scroll whitespace-nowrap">
                        <table class="table-auto w-full text-sm lg:text-base">
                            <thead class="text-center">
                                <tr class="border border-black bg-blue-300">
                                    <th class="border border-black px-4">Id Transaksi</th>
                                    <th class="border border-black px-4">Id Order</th>
                                    <th class="border border-black px-4">Total Biaya</th>
                                    <th class="border border-black px-4">Tanggal Transaksi</th>
                                    <th class="border border-black px-4">Status Transaksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr class="border">
                                    <th class="border border-black">001</th>
                                    <th class="border border-black">OD001</th>
                                    <th class="border border-black">20.000</th>
                                    <th class="border border-black">19-11-2021</th>
                                    <th class="border border-black">Selesai</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
