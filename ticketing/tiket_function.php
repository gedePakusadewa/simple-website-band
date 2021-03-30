<?php
    session_start();   

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "band_cold_play";

    $db = new mysqli($servername, $username, $password, $dbname);

    if ($db->connect_error) {
        die("Koneksi Gagal: " . $db->connect_error);
    } 

    //inget ganti nama variabelnya
    if(isset($_GET['id_bulan_BPT'])){
        $_SESSION['placerHolder_drwopdown_bulan'] = $_GET['bulan_bulan_BPT'];
        unset($_SESSION['data_jadwal_perBulan']);
        unset($_SESSION['info_gIHT']);

        $id_bulan_BPT = str_replace(" ", "", $_GET['id_bulan_BPT']);

        $dta_baris_BPT = getDataBaris("SELECT id FROM tour_kota_skedul WHERE id_bulan= '$id_bulan_BPT' ");

        for($i = 0; $i < count($dta_baris_BPT); $i++){
            $id_BPT = $dta_baris_BPT[$i];
            $data_BPT = runQuery("SELECT id, id_bulan, kota, tanggal, pesan, gambar FROM tour_kota_skedul 
                WHERE id = '$id_BPT' ");
        
            $array_data_BPT = array(
                $data_BPT[0]['tanggal']
                    =>array('id'=>$data_BPT[0]["id"],
                            'kota'=>$data_BPT[0]["kota"], 
                            'tanggal'=>$data_BPT[0]["tanggal"],
                            'pesan'=>$data_BPT[0]["pesan"], 
                            'gambar'=>$data_BPT[0]["gambar"],
                    )
            );

            if(!isset($_SESSION['data_jadwal_perBulan'])){
                $_SESSION['data_jadwal_perBulan'] = $array_data_BPT;
            }else{
                $_SESSION['data_jadwal_perBulan'] = array_merge($_SESSION['data_jadwal_perBulan'] 
                    , $array_data_BPT);
            }
            
        }

    }

    if(isset($_GET['info_id_kota_tiket'])){
        unset($_SESSION['info_tiket_tiketing']);
        unset($_SESSION['info_gIHT']);
        getInfoTiketPerbulan($_GET['info_id_kota_tiket']);
        getInfoHargaTiket();

        if(isset($_SESSION['info_tiket_tiketing'])){
                
            $_SESSION['info_gIHT']['tribun']['jumlah_tiket_OTS'] = 
                $_SESSION['info_tiket_tiketing']['tribun']['jumlah_tiket_OTS'];
            $_SESSION['info_gIHT']['tribun']['jumlah_tiket_EB'] = 
                $_SESSION['info_tiket_tiketing']['tribun']['jumlah_tiket_EB'];

            $_SESSION['info_gIHT']['vip']['jumlah_tiket_OTS'] = 
                $_SESSION['info_tiket_tiketing']['vip']['jumlah_tiket_OTS'];
            $_SESSION['info_gIHT']['vip']['jumlah_tiket_EB'] = 
                $_SESSION['info_tiket_tiketing']['vip']['jumlah_tiket_EB'];

            $_SESSION['info_gIHT']['svip']['jumlah_tiket_OTS'] = 
                $_SESSION['info_tiket_tiketing']['svip']['jumlah_tiket_OTS'];
            $_SESSION['info_gIHT']['svip']['jumlah_tiket_EB'] = 
                $_SESSION['info_tiket_tiketing']['svip']['jumlah_tiket_EB'];
        }

    }

    if($pageTicketing == "ticketing"){
        getDataStatusTiketBulan();
    }

    function getInfoTiketPerbulan($dta){
        $id_kota_gITP = str_replace(" ", "", $dta);
        $dtaBaris_gITP = getDataBaris("SELECT id FROM jumlah_tiket_dibeli WHERE id_kota='$id_kota_gITP' ");

        for($i = 0; $i < count($dtaBaris_gITP); $i++){
            $tmp_gITP = $dtaBaris_gITP[$i];

            $data_user_gITP = runQuery("SELECT id, id_kota, tipe_tiket, early_bird, on_the_spot FROM jumlah_tiket_dibeli 
                WHERE id = '$tmp_gITP' ");        

            $array_data_gITP = array(
                $data_user_gITP[0]['tipe_tiket']
                    =>array('id'=>$data_user_gITP[0]["id"],
                            'id_kota'=>$data_user_gITP[0]["id_kota"], 
                            'tipe_tiket'=>$data_user_gITP[0]["tipe_tiket"],
                            'jumlah_tiket_OTS'=>$data_user_gITP[0]["on_the_spot"],
                            'jumlah_tiket_EB'=>$data_user_gITP[0]["early_bird"]
                    )
            );

            if(!isset($_SESSION['info_tiket_tiketing'])){
                $_SESSION['info_tiket_tiketing'] = $array_data_gITP;
            }else{
                $_SESSION['info_tiket_tiketing'] = array_merge($_SESSION['info_tiket_tiketing'] , $array_data_gITP);
            }
        }
    }

    function getInfoHargaTiket(){

        $dtaBaris_gIHT = getDataBaris("SELECT id FROM harga_tiket");
        
        for($i = 0; $i < count($dtaBaris_gIHT); $i++){
            $id_gIHT = $dtaBaris_gIHT[$i];
            $data_user_gIHT = runQuery("SELECT id, tipe_tiket, on_the_spot, early_bird FROM harga_tiket 
                WHERE id = '$id_gIHT' ");
        
            $array_data_gIHT = array(
                $data_user_gIHT[0]['tipe_tiket']
                    =>array('id'=>$data_user_gIHT[0]["id"],
                            'tipe_tiket'=>$data_user_gIHT[0]["tipe_tiket"], 
                            'on_the_spot'=>$data_user_gIHT[0]["on_the_spot"],
                            'early_bird'=>$data_user_gIHT[0]["early_bird"],
                            'jumlah_tiket_OTS'=>"0",
                            'jumlah_tiket_EB'=>"0"
                    )
            );

            if(!isset($_SESSION['info_gIHT'])){
                $_SESSION['info_gIHT'] = $array_data_gIHT;
            }else{
                $_SESSION['info_gIHT'] = array_merge($_SESSION['info_gIHT'] , $array_data_gIHT);
            }
        }
    }

    function getDataStatusTiketBulan(){
        unset($_SESSION['bulan_pesen_tiket']);

        $dtaBaris = getDataBaris("SELECT id FROM tour_bulan_skedul ORDER BY id DESC LIMIT 3");
        
        for($i = count($dtaBaris) - 1; $i >= 0; $i--){
            $id_gDSTB = $dtaBaris[$i];
            $data_user = runQuery("SELECT id, bulan, tahun, status_tiket FROM tour_bulan_skedul 
                WHERE id = '$id_gDSTB' ");
        
            $array_data_user = array(
                $data_user[0]['bulan']
                    =>array('id'=>$data_user[0]["id"],
                            'bulan'=>$data_user[0]["bulan"], 
                            'status_tiket'=>$data_user[0]["status_tiket"]
                    )
            );

            if(!isset($_SESSION['bulan_pesen_tiket'])){
                $_SESSION['bulan_pesen_tiket'] = $array_data_user;
            }else{
                $_SESSION['bulan_pesen_tiket'] = array_merge($_SESSION['bulan_pesen_tiket'] , $array_data_user);
            }
            
        }
        
    }

    function runQuery($query) {
        global $db;
        $result = mysqli_query($db,$query);
        
		while($row = mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
        }
        		
		if(!empty($resultset)){
            return $resultset;
        }
            
    }

    function getDataBaris($sql_gDB){
        global $db;

        //$sql_admin = "SELECT id FROM tour_bulan_skedul";

        $result_gDB = $db->query($sql_gDB);
        $array_list_gDB = [];
        $incre = 0;

        if ($result_gDB->num_rows > 0) {
            while($row_gDB = $result_gDB->fetch_assoc()) {
                    $array_list_gDB[$incre] =  $row_gDB['id'];
                    $incre = $incre + 1;
            }
        }
        //$_SESSION['tes'] = $array_list_gDB;
        return $array_list_gDB;
    }


    $db ->close();

?>