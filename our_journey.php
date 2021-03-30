<!-- sumber https://www.w3schools.com/w3css/w3css_templates.asp-->

<?php

    $infoJourney = pathinfo( __FILE__ );
    $pageJourney = $infoJourney['filename'];
    
    include('php_function.php');


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ticketing Official Website</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="css/main.css" />
        <!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato" />
        <link rel="stylesheet" href=
        "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <style>
            body {font-family: "Lato", sans-serif}
            .mySlides {display: none}
        </style>
    </head>
<body>

    <!-- Navbar -->
    <div class="w3-top"><!-- bagian fixed navigation bar, cari penjelasannya di https://www.w3schools.com/css/css_navbar.asp-->
        <div class="w3-bar w3-black w3-card">

            <!-- coba di kecilin layar browsernya, tag ini buat nampilin icon menu di pojok kiri atas-->
            <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" 
            href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu">
            <i class="fa fa-bars"></i></a>
            
            <a href="index.php" class="w3-bar-item w3-button w3-padding-large">HOME</a>
            <a href="#contact" class="w3-bar-item w3-button w3-padding-large w3-hide-small">CONTACT</a>
            <a href="ticketing/ticketing.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">TICKET</a>

            <div class="w3-dropdown-hover w3-hide-small">
            <button class="w3-padding-large w3-button" title="More">MORE <i class="fa fa-caret-down"></i></button>     
            <div class="w3-dropdown-content w3-bar-block w3-card-4">
                <a href="merchandise/merchandise.php" class="w3-bar-item w3-button">Merchandise</a>
                <a href="our_journey.php" class="w3-bar-item w3-button">Our Journey Gallery</a>
            </div>
            </div>

            <!--bagian search
            <a href="javascript:void(0)" class="w3-padding-large w3-hover-red w3-hide-small w3-right">
                <i class="fa fa-search"></i></a>
            -->

        </div>
    </div><!-- end dari Navbar -->

    <!--bagin bawah gunanya buat tampilin nemu kalo mode layar browser kecil diaktifkan
    gak bakalan keliatan di mode normal kalo layar kecil gak diaktifkan-->
    <!-- Navbar on small screens (remove the onclick attribute 
    if you want the navbar to always show on top of the content when clicking on the links) -->
    <div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
        <a href="#band" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">BAND</a>
        <a href="#tour" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">TOUR</a>
        <a href="#contact" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">CONTACT</a>
        <a href="#" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">MERCH</a>
    </div>

    <!-- Page content -->
    <div class="w3-content" style="max-width:2000px;margin-top:46px">

    <!--The Tour Section-->
    <div class="w3-black" id="tour">
        <div class="w3-container w3-content w3-padding-64" style="max-width:800px">

        <h2 class="w3-wide w3-center">TOUR SCHEDULE 2019</h2>
        <!--<p class="w3-opacity w3-center"><i>Remember to book your tickets!</i></p><br>-->

        <div class="w3-dropdown-hover w3-hide-small">
            <button class="w3-padding-large w3-button" title="More">
                <?php

                    if(isset($_SESSION['nama_bulan_OJ'])){
                        echo "".$_SESSION['nama_bulan_OJ'];
                    }else{
                        echo "PILIH BULAN ";
                    }

                ?> <i class="fa fa-caret-down"></i></button>     
            <div class="w3-dropdown-content w3-bar-block w3-card-4">

                <?php
                    if(isset($_SESSION['bulan_our_journey'])){
                        
                        foreach($_SESSION['bulan_our_journey'] as $itemBulan){
                            echo "<a href=\"our_journey.php?id_bulan_OJ=".$itemBulan['id']."
                                &nama_bulan_OJ=".$itemBulan['bulan']."\" 
                                class=\"w3-bar-item w3-button\">".$itemBulan['bulan']."</a>";
                        }
                    }else{
                        echo "  <a href=\"#\" class=\"w3-bar-item w3-button\">KOSONG</a>
                                <a href=\"#\" class=\"w3-bar-item w3-button\">KOSONG</a>
                                <a href=\"#\" class=\"w3-bar-item w3-button\">KOSONG</a>";
                    }
                
                ?>

            </div>
        </div>

            <div class="w3-row-padding w3-padding-32" style="margin:0 -16px">

                <?php

                    if(isset($_SESSION['nama_bulan_OJ'])){
                        echo "<h5 class=\"w3-center\">GALERY TOUR ".strtoupper($_SESSION['nama_bulan_OJ'])."</h5>";
                    }else{
                        if(isset($_SESSION['gambar_perBulan'])){
                            echo "<h5 class=\"w3-center\">SILAHKAN PILIH BULAN</h5>";
                        }else{
                            echo "<h5 class=\"w3-center\">TIDAK ADA FOTO PADA BULAN</h5>";
                        }                        
                    }

                    if(isset($_SESSION['gambar_perBulan'])){

                        foreach($_SESSION['gambar_perBulan'] as $img_bulan){
                            echo 
                            "<div class=\"w3-third w3-margin-bottom\">
                                <img src=\" ".$img_bulan['path_img']." \" alt=\"New York\" style=\"width:100%\" class=\"w3-hover-opacity\">
                                <div class=\"w3-container w3-white\">
                                    <p class=\"w3-opacity\">".$img_bulan['kota']."</p>
                                    <p>".$img_bulan['pesan_img'].".</p>
                                </div>
                            </div>";
                        }
                    }
                ?>

            </div>          
 


            <!--
            <div class="w3-third w3-margin-bottom">
                <ul class="w3-ul w3-border w3-white w3-center w3-opacity w3-hover-opacity-off">
                    <li class="w3-black w3-xlarge w3-padding-32">Tribun</li>
                    <li class="w3-padding-16">Sisa Tiket: </li>
                    <li class="w3-padding-16">
                        <h2>Rp. 1.000.000</h2>
                        <span class="w3-opacity">Early Bird</span>
                    </li>
                    <li class="w3-padding-16">
                        <h2>Rp. 1.300.000</h2>
                        <span class="w3-opacity">On The Spot</span>
                    </li>
                    <li class="w3-light-grey w3-padding-24">
                        <button class="w3-button w3-teal w3-padding-large w3-hover-black">Beli Tiket</button>
                    </li>
                </ul>
            </div>

            <div class="w3-third w3-margin-bottom">
                <ul class="w3-ul w3-border w3-white w3-center w3-opacity w3-hover-opacity-off">
                    <li class="w3-black w3-xlarge w3-padding-32">VIP</li>
                    <li class="w3-padding-16">Sisa Tiket: </li>
                    <li class="w3-padding-16">
                        <h2>Rp. 2.000.000</h2>
                        <span class="w3-opacity">Early Bird</span>
                    </li>
                    <li class="w3-padding-16">
                        <h2>Rp. 2.300.000</h2>
                        <span class="w3-opacity">On The Spot</span>
                    </li>
                    <li class="w3-light-grey w3-padding-24">
                        <button class="w3-button w3-teal w3-padding-large w3-hover-black">Beli Tiket</button>
                    </li>
                </ul>
            </div>

                    //lanjut menampilkan jumlah tiket ygn sisa, sekalian emnginputkan 
                    //tiket, abis tu bikin page mechandise

            <div class="w3-third">
                <ul class="w3-ul w3-border w3-white w3-center w3-opacity w3-hover-opacity-off">
                    <li class="w3-black w3-xlarge w3-padding-32">Super VIP</li>
                    <li class="w3-padding-16">Sisa Tiket: ~~ </li>
                    <li class="w3-padding-16">
                        <h2>Rp. ~~~ </h2>
                        <span class="w3-opacity">Early Bird</span>
                    </li>
                    <li class="w3-padding-16">
                        <h2>Rp. ~~~ </h2>
                        <span class="w3-opacity">On The Spot</span>
                    </li>
                    <li class="w3-light-grey w3-padding-24">
                        <button class="w3-button w3-teal w3-padding-large w3-hover-black">Beli Tiket</button>
                    </li>
                </ul>
            </div>
            -->
    
            </div>


        </div>
        
    </div><!--  akhir The Tour Section -->

    <div class="w3-row-padding" style="margin:0 -16px">

    </div>

    
    <!-- The Contact Section -->
    <div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="contact">
        <h2 class="w3-wide w3-center">CONTACT</h2>
        <div class="w3-row w3-padding-32">
        <div class="w3-col m6 w3-large w3-margin-bottom">
            <i class="fa fa-map-marker" style="width:30px"></i> Chicago, US<br>
            <i class="fa fa-phone" style="width:30px"></i> Phone: +00 151515<br>
            <i class="fa fa-envelope" style="width:30px"> </i> Email: mail@mail.com<br>
        </div>
        <div class="w3-col m6">
            <form action="/action_page.php" target="_blank">
            <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
                <div class="w3-half">
                <input class="w3-input w3-border" type="text" placeholder="Name" required name="Name">
                </div>
                <div class="w3-half">
                <input class="w3-input w3-border" type="text" placeholder="Email" required name="Email">
                </div>
            </div>
            <input class="w3-input w3-border" type="text" placeholder="Message" required name="Message">
            <button class="w3-button w3-black w3-section w3-right" type="submit">SEND</button>
            </form>
        </div>
        </div>
    </div>
    
    <!-- End Page Content -->
    </div>

    <!-- Image of location/map 
    <img src="/w3images/map.jpg" class="w3-image w3-greyscale-min" style="width:100%">
    -->

    <!--gak ngerti gimana cara kerjanya -->
    <!-- Footer -->
    <footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
    <!--
        <p class="w3-medium">Powered by <a href=
        "https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    -->
    </footer>

    <script>

    // Automatic Slideshow - change image sesuai setTimeout
    var myIndex = 0;
    carousel();

    function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 3000);//3000 artinya 3 detik    
    }

    // Used to toggle the menu on small screens when clicking on the menu button
    function myFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
    }

    // When the user clicks anywhere outside of the modal, close it
    var modal = document.getElementById('ticketModal');
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    }

    function DropMenuBulanTiket() {
                var x = document.getElementById("tiket_DropDownMenu");
                if (x.className.indexOf("w3-show") == -1) { 
                    x.className += " w3-show";
                } else {
                    x.className = x.className.replace(" w3-show", "");
                }
            }
    </script>

    </body>
</html>
