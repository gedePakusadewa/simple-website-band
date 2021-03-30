<!-- sumber https://www.w3schools.com/w3css/w3css_templates.asp-->

<?php

    $infoTour = pathinfo( __FILE__ );
    $pageTour = $infoTour['filename'];

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
            <a href="tour_ulala.php?logout=1" class="w3-bar-item w3-button w3-padding-large" style="float:right;">Log Out</a>
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
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Status Tiket</th>
                </tr>

                <?php

                    //unset($_SESSION['data_tabel_HARGA_TIKET']);
                    if(isset($_SESSION['data_tabel_tour_bulan'])){
                        foreach($_SESSION['data_tabel_tour_bulan'] as $dataTabel){

                            if($dataTabel['status_tiket'] == "habis"){
                                $status_tiket = "<div style=\"background-color:red;\">habis</div>";
                            }else{
                                $status_tiket = "sisa";
                            }

                            echo"
                                <tr>
                                    <td>".$dataTabel['id']."</td>
                                    <td>".$dataTabel['bulan']."</td>
                                    <td>".$dataTabel['tahun']."</td>
                                    <td>".$status_tiket."</td>
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
                    <th>Bulan</th>
                    <th>Kota</th>
                    <th>Tanggal</th>
                    <th>Pesan</th>
                </tr>

                <?php

                    //unset($_SESSION['data_tabel_HARGA_TIKET']);
                    if(isset($_SESSION['data_tabel_tour_kota'])){
                        foreach($_SESSION['data_tabel_tour_kota'] as $dataTabel){


                            echo"
                                <tr>
                                    <td>".$dataTabel['id']."</td>
                                    <td>".$dataTabel['bulan']."</td>
                                    <td>".$dataTabel['kota']."</td>
                                    <td>".$dataTabel['tanggal']."</td>
                                    <td>".$dataTabel['pesan']."</td>
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
        </div>
    <!-- End Page Content -->
    </div>

    </body>
</html>
