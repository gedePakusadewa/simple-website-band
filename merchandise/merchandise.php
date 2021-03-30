<!-- sumber https://www.w3schools.com/w3css/w3css_templates.asp-->

<?php

    $infoMerchan = pathinfo( __FILE__ );
    $pageMerchan = $infoMerchan['filename'];
    
    include('merchandise_function.php');


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Merchandise Official Website</title>
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
            <a href="../ticketing/ticketing.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">TICKET</a>

            <div class="w3-dropdown-hover w3-hide-small">
            <button class="w3-padding-large w3-button" title="More">MORE <i class="fa fa-caret-down"></i></button>     
            <div class="w3-dropdown-content w3-bar-block w3-card-4">
                <a href="merchandise.php" class="w3-bar-item w3-button">Merchandise</a>
                <a href="../our_journey.php" class="w3-bar-item w3-button">Our Journey Gallery</a>
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
    <div class="w3-white" id="tour">
        <div class="w3-container w3-content w3-padding-64" style="max-width:800px">

        <h2 class="w3-wide w3-center">MERCHANDISE TOUR 2019</h2>
        <!--<p class="w3-opacity w3-center"><i>Remember to book your tickets!</i></p><br>-->

        <br /><br />
        <div class="w3-right">
            <div class="w3-bar">

                <?php

                    if(isset($_SESSION["item_dipesan"])){
                        echo "<a class=\"w3-button w3-black w3-margin-bottom\" 
                        href=\"merchandise.php?empty_keranjang=true\">Batalkan Pesanan</a>";
                    }else{
                        echo "<a class=\"w3-button w3-black w3-margin-bottom w3-disabled\" 
                        href=\"merchandise.php?empty_keranjang=true\">Batalkan Pesanan</a>";
                    }
                
                ?>
                    
            </div>
        </div> 

        <br /><br />

        <table class="w3-table-all" cellpadding="10" cellspacing="1">
            <tbody>			
                <tr class="w3-black">
                    <th style="text-align:left;">Produk</th>
                    <th style="text-align:left;" width="10%">Kode Produk</th>
                    <th style="text-align:right;" width="5%">Kuantitas</th>
                    <th style="text-align:center;" width="20%">Harga Satuan</th>
                    <th style="text-align:center;" width="20%">Total Harga</th>
                </tr>

        <?php
        
                if(isset($_SESSION["item_dipesan"])){
                    $total_quantity = 0;
                    $total_price = 0;

                    foreach ($_SESSION['item_dipesan'] as $item){
                        
                        //echo "<br /> SESSION-".var_dump($_SESSION['cart_item'])."-SESSION<br />";

                        //echo "<br /><br />".var_dump($item)."<br />";
                        
                        $item_price = (int)$item['kuantitas'] * (int)$item['harga_item'];

                        echo"
                            <tr class=\"w3-hover-black\">
                                <td><img src=\"".$item["gambar_item"]."\" class=\"cart-item-image\" /> ".$item["nama"]."</td>
                                <td>".$item["kode_item"]."</td>
                                <td style=\"text-align:right;\">".$item["kuantitas"]."</td>
                                <td style=\"text-align:right;\">Rp. ".number_format($item["harga_item"])."</td>
                                <td style=\"text-align:right;\">Rp. ".number_format($item_price,2)."</td>
                            </tr>";
                        
                        $total_quantity += $item['kuantitas'];
                        $total_price += ($item['harga_item']*$item['kuantitas']);
                    }
                    
                        echo"
                            <tr>
                                <td colspan=\"2\" style=\"text-align:right;\">Total:</td>
                                <td style=\"text-align:right;\">".$total_quantity."</td>
                                <td style=\"text-align:right;\" colspan=\"2\"><strong>Rp. "
                                    .number_format($total_price, 2)."</strong></td>
                            </tr>";
                    
                } else {
                
                    echo "<tr><td colspan=\"5\" style=\"text-align:center;\">Silahkan memilih produk yang akan dipesan</td></tr>";
                
                }


        ?>
            </tbody>
        </table>

        <br />
        <div class="w3-left">
            <div class="w3-bar">

                <?php
                    if(isset($_SESSION["item_dipesan"])){
                        echo "<a class=\"w3-button w3-black w3-margin-bottom\" 
                        href=\"dashboard_rotiku.php?empty_status=true\">Pesan</a>";
                    }else{
                        echo "<a class=\"w3-button w3-black w3-margin-bottom w3-disabled\" 
                        href=\"dashboard_rotiku.php?empty_status=true\">Pesan</a>";
                    }
                ?>
            </div>
        </div> 

        <div class="w3-row-padding w3-padding-32" style="margin:0 -16px">
                
                <?php
                
                    if(isset($_SESSION['list_merchan'])){
                        //var_dump($_SESSION['data_jadwal_perBulan']);
                        foreach($_SESSION['list_merchan'] as $info_item){
                            echo 
                            "<div class=\"w3-third w3-margin-bottom\">
                                <img src=\"../".$info_item['gambar_item']."\" alt=\"New York\" style=\"width:100%\" class=\"w3-hover-opacity\">
                                <div class=\"w3-container w3-black\">
                                    <p><b>".$info_item['nama']."</b></p>
                                    <p class=\"w3-opacity\">Harga Rp.<span class=\"w3-large w3-white\"> 
                                        ".number_format($info_item["harga_item"])."</span></p>
                                    <a href=\"merchandise.php?kode_item=".$info_item['kode_item']."\" 
                                        class=\"w3-button w3-white w3-margin-bottom\">Beli</a>
                                </div>
                            </div>";
                        }
                    }else{
                        echo "<div style=\"text-align:center;\">Tidak Ada Data</div>";
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
    
    <!-- The Contact Section -->
    <div class=" w3-black w3-container w3-content w3-padding-64" style="max-width:800px" id="contact">
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
