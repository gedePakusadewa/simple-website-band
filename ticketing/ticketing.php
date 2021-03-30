<!-- sumber https://www.w3schools.com/w3css/w3css_templates.asp-->

<?php

    $infoTicketing = pathinfo( __FILE__ );
    $pageTicketing = $infoTicketing['filename'];
    
    include('tiket_function.php');


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ticketing Official Website</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="../css/main.css" />
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
            
            <a href="../index.php" class="w3-bar-item w3-button w3-padding-large">HOME</a>
            <a href="#contact" class="w3-bar-item w3-button w3-padding-large w3-hide-small">CONTACT</a>

            <div class="w3-dropdown-hover w3-hide-small">
            <button class="w3-padding-large w3-button" title="More">MORE <i class="fa fa-caret-down"></i></button>     
            <div class="w3-dropdown-content w3-bar-block w3-card-4">
                <a href="../merchandise/merchandise.php" class="w3-bar-item w3-button">Merchandise</a>
                <a href="../our_journey.php" class="w3-bar-item w3-button">Our Journey Gallery</a>
            </div>
            </div>

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

            <ul class="w3-ul w3-border w3-white w3-text-grey">
            
            <!-- <li class="w3-padding">September<span class="w3-badge w3-right w3-margin-right">999</span></li> -->
                <?php
                    /*
                    $status_tiket = "";

                    foreach($_SESSION['bulan_pesen_tiket'] as $dataBulan){

                        if($dataBulan['status_tiket'] == "habis"){
                            $status_tiket = "<span class=\"w3-tag w3-red w3-margin-left\">Sold out</span>";
                        }else{
                            $status_tiket ="<span class=\"w3-badge w3-right w3-margin-right\">999</span>";
                        }

                        echo "<a href = \"index.php?id_bulan_BPT=".$dataBulan['id']."\" class=\"\" >
                            <li class=\"w3-padding\">".$dataBulan['bulan'].$status_tiket."</li></a>";

                    }
                    */
                ?>
            
            </ul>

            <div class="w3-dropdown-click" style="width:100%;">
                <button onclick="DropMenuBulanTiket()" class="w3-button" >
                    <?php
                        if(!isset($_SESSION['placerHolder_drwopdown_bulan'])){
                            echo "
                                <span id=\"bulan_tiket\">Pilih Bulan Tour</span></button>";
                        }else{
                            echo "
                                <span id=\"bulan_tiket\">"
                                .$_SESSION['placerHolder_drwopdown_bulan']."</span></button>"; 
                        }
                    
                    ?>

                <div id="tiket_DropDownMenu" class="w3-dropdown-content w3-bar-block w3-border">
                    <!-- <a href="#" class="w3-bar-item w3-button">Link 1</a> -->

                    <?php
                    
                        foreach($_SESSION['bulan_pesen_tiket'] as $dataBulan){
                            /*
                            if($dataBulan['status_tiket'] == "habis"){
                                $status_tiket = "<span class=\"w3-tag w3-red w3-margin-left\">Sold out</span>";
                            }else{
                                $status_tiket ="<span class=\"w3-badge w3-right w3-margin-right\">999</span>";
                            }
                            */
                            echo "<a href = \"ticketing.php?id_bulan_BPT=".$dataBulan['id'].
                                "&bulan_bulan_BPT=".$dataBulan['bulan']."\" 
                                class=\"w3-bar-item w3-button\" >
                                ".$dataBulan['bulan']."</a>";

                        }
                    
                    ?>

                </div>
            </div>

            <div class="w3-row-padding w3-padding-32" style="margin:0 -16px">

                <?php

                    if(isset($_SESSION['data_jadwal_perBulan'])){
                        //var_dump($_SESSION['data_jadwal_perBulan']);
                        foreach($_SESSION['data_jadwal_perBulan'] as $info_tiket_bulan){
                            echo 
                            "<div class=\"w3-third w3-margin-bottom\">
                                <img src=\"../".$info_tiket_bulan['gambar']."\" alt=\"New York\" style=\"width:100%\" class=\"w3-hover-opacity\">
                                <div class=\"w3-container w3-white\">
                                    <p><b>".$info_tiket_bulan['kota']."</b></p>
                                    <p class=\"w3-opacity\">".$info_tiket_bulan['tanggal']."</p>
                                    <p>".$info_tiket_bulan['pesan'].".</p>
                                    <a href=\"ticketing.php?info_id_kota_tiket=".$info_tiket_bulan['id']."\" 
                                        class=\"w3-button w3-black w3-margin-bottom\">Informasi Tiket</a>
                                </div>
                            </div>";
                        }
                    }
                ?>

            </div>          
            
            <?php
            
                if(isset($_SESSION['info_gIHT'])){
                    foreach($_SESSION['info_gIHT'] as $info_gIHT){

                        if($info_gIHT["tipe_tiket"] == "tribun"){
                            $tipe_tiket = "Tribun";
                        }else if($info_gIHT["tipe_tiket"] == "vip"){
                            $tipe_tiket = "VIP";
                        }else if($info_gIHT["tipe_tiket"] == "svip"){
                            $tipe_tiket = "Super VIP";
                        }else{
                            $tipe_tiket = "XX TRIBUN XX";
                        }
    
                        if((int)$info_gIHT['jumlah_tiket_OTS'] >= 10){
                            $sisa_tiket_OTS = "
                                <div class=\"w3-tag w3-round w3-red\" style=\"padding:3px\">
                                    <div class=\"w3-tag w3-round w3-red\">
                                        Habis
                                    </div>
                                </div>";
                            $tombol_pesan_OTS = "<button class=\"w3-button w3-teal w3-padding-large w3-hover-black\" disabled>
                                Beli Tiket</button>";
                        }else{
                            $sisa_tiket_OTS = "Tersedia";
                            $tombol_pesan_OTS = "<button class=\"w3-button w3-teal w3-padding-large w3-hover-black\">
                                Beli Tiket</button>";
                        }

                        if((int)$info_gIHT['jumlah_tiket_EB'] >= 10){
                            $sisa_tiket_EB = "
                                <div class=\"w3-tag w3-round w3-red\" style=\"padding:3px\">
                                    <div class=\"w3-tag w3-round w3-red\">
                                        Habis
                                    </div>
                                </div>";
                            $tombol_pesan_EB = "<button class=\"w3-button w3-teal w3-padding-large w3-hover-black\" disabled>
                                Beli Tiket</button>";
                        }else{
                            $sisa_tiket_EB = "Tersedia";
                            $tombol_pesan_EB = "<button class=\"w3-button w3-teal w3-padding-large w3-hover-black\">
                                Beli Tiket</button>";
                        }

                        echo"
                        <div class=\"w3-third w3-margin-bottom\">
                            <ul class=\"w3-ul w3-border w3-white w3-center w3-opacity w3-hover-opacity-off\">
                                <li class=\"w3-black w3-xlarge w3-padding-32\">".$tipe_tiket."</li>
                                <li class=\"w3-padding-16\">
                                    <span class=\"w3-opacity\">Early Bird</span><br />
                                    <span class=\"w3-opacity\">".$sisa_tiket_EB."</span>
                                    <h2>Rp. ".$info_gIHT['early_bird']."</h2>
                                    ".$tombol_pesan_EB."
                                </li>
                                <li class=\"w3-padding-16\">
                                    <span class=\"w3-opacity\">On The Spot</span><br />
                                    <span class=\"w3-opacity\">".$sisa_tiket_OTS."</span>
                                    <h2>Rp. ".$info_gIHT['on_the_spot']."</h2>
                                    ".$tombol_pesan_OTS."
                                </li>
                            </ul>
                        
                        </div>";
                    }
                }
                
                
            ?>


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
