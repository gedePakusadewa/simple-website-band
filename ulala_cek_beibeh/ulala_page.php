<!-- sumber https://www.w3schools.com/w3css/w3css_templates.asp-->

<?php

    $infoUlala = pathinfo( __FILE__ );
    $pageUlala = $infoUlala['filename'];

    include('ulala_function.php');
    //echo $_SESSION['tes'];

    if(!isset($_SESSION['user'])){
        header("Location: log_in.php");
        exit();
    }

    if (isset($_GET['logout'])) {
        unset($_SESSION['data_tabel_HARGA_TIKET']);
        unset($_SESSION['data_tabel_JUMLAH_TIKET']);
        session_destroy();
        header("Location: log_in.php");
        exit();
	}	

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ulala Official Website</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato" />
        <link rel="stylesheet" href=
        "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <style>
            body {font-family: "Lato", sans-serif}
            .mySlides {display: none}
            #customers {
                border-collapse: collapse;
                width: 100%;
            }

            #customers td, #customers th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #customers tr:nth-child(even){background-color: #f2f2f2;}

            #customers tr:hover {background-color: #ddd;}

            #customers th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #000; 
                color: white;
            }
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
            
            <a href="#" class="w3-bar-item w3-button w3-padding-large">HAI, MIN</a>
            <a href="ulala_page.php" class="w3-bar-item w3-button w3-padding-large">HOME</a>
            <a href="tour_ulala.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">TOUR</a>
            <a href="ulala_page.php?logout=1" class="w3-bar-item w3-button w3-padding-large" style="float:right;">Log Out</a>

            <!--bagian search
            <a href="javascript:void(0)" class="w3-padding-large w3-hover-red w3-hide-small w3-right">
                <i class="fa fa-search"></i></a>
            -->

        </div>
    </div><!-- end dari Navbar -->

    <!-- Page content -->
    <div class="w3-content" style="max-width:2000px;margin-top:46px">

        <div class="w3-container w3-content w3-padding-64" style="max-width:800px">

            <table id="customers">
                <tr>
                    <th>id</th>
                    <th>Tipe Tiket</th>
                    <th>Harga On The Spot</th>
                    <th>Harga Early Bird</th>
                </tr>

                <?php

                    //unset($_SESSION['data_tabel_HARGA_TIKET']);
                    if(isset($_SESSION['data_tabel_HARGA_TIKET'])){
                        foreach($_SESSION['data_tabel_HARGA_TIKET'] as $dataTabel){
                            echo"
                                <tr>
                                    <td>".$dataTabel['id']."</td>
                                    <td>".$dataTabel['tipe_tiket']."</td>
                                    <td>".$dataTabel['on_the_spot']."</td>
                                    <td>".$dataTabel['early_bird']."</td>
                                </tr>";
                        }
                    }else{
                        echo"
                            <tr>
                                <td colspan=\"4\" style=\"text-align:center;\" ><b>TIDAK ADA DATA</b></td>
                            </tr>";
                    }
                
                ?>
            </table>
                    <br /><br />
            <table id="customers">
                <tr>
                    <th>id</th>
                    <th>ID Bulan</th>
                    <th>ID Kota</th>
                    <th>Tipe Tiket</th>
                    <th>Early Bird</th>
                    <th>On The Spot</th>
                </tr>

                <?php

                    //var_dump($_SESSION['data_tabel_JUMLAH_TIKET']);

                    if(isset($_SESSION['data_tabel_JUMLAH_TIKET'])){
                        foreach($_SESSION['data_tabel_JUMLAH_TIKET'] as $dataTabel){
                            
                            if((int)$dataTabel['early_bird'] >= 10){
                                $jumlah_tiket_EB = "<div style=\"background-color:red;\">10</div>";
                            }else{
                                $jumlah_tiket_EB = $dataTabel['early_bird'];
                            }

                            if((int)$dataTabel['on_the_spot'] >= 10){
                                $jumlah_tiket_OTS = "<div style=\"background-color:red;\">10</div>";
                            }else{
                                $jumlah_tiket_OTS = $dataTabel['on_the_spot'];
                            }

                            echo"
                                <tr>
                                    <td>".$dataTabel['id']."</td>
                                    <td>".$dataTabel['bulan']."</td>
                                    <td>".$dataTabel['kota']."</td>
                                    <td>".$dataTabel['tipe_tiket']."</td>
                                    <td>".$jumlah_tiket_EB."</td>
                                    <td>".$jumlah_tiket_OTS."</td>
                                </tr>";
                        }
                    }else{
                        echo"
                            <tr>
                                <td colspan=\"6\" style=\"text-align:center;\" ><b>TIDAK ADA DATA</b></td>
                            </tr>";
                    }
                    
                
                ?>
            </table>
        </div>
    <!-- End Page Content -->
    </div>

    </body>
</html>
