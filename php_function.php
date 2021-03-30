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



    if(isset($pageIndex)){
        if($pageIndex == "index"){
            getDataStatusTiketBulan();
        }
    }

    if(isset($pageJourney)){
        if($pageJourney == "our_journey"){
            //$_SESSION['tes123'] = getDataSimple("SELECT bulan FROM tour_bulan_skedul", "bulan");
            
            $_SESSION['bulan_our_journey'] = getDaftarBulanID(getDataBaris("SELECT id FROM tour_bulan_skedul"));
    
        }    
    }
    
    if(isset($_GET['id_bulan_OJ']) && isset($_GET['nama_bulan_OJ'])){
        $id_bulan_OJ = str_replace(" ", "", $_GET['id_bulan_OJ']);

        $_SESSION['nama_bulan_OJ'] =  str_replace(" ", "", $_GET['nama_bulan_OJ']);

        //$_SESSION['tes'] 
        $_SESSION['gambar_perBulan'] = getDataGambarOJ(
                getDataBaris("SELECT id FROM galery_tour WHERE id_bulan='$id_bulan_OJ' "));
                

    }

//lanjut bikin fungsi dibawah, terus bikin bagian merchandise

    function getDataGambarOJ($id_){
        $array_ID_gDGOJ = $id_;
        $tmp_assoc_gDGOJ = array();

        for($i = 0; $i < count($array_ID_gDGOJ); $i++){

            $tmp_id_gDGOJ= $array_ID_gDGOJ[$i];

            $data_gDGOJ = runQuery("SELECT id, id_bulan, id_kota, pesan_img, kode_img, path_img 
                FROM galery_tour WHERE id = '$tmp_id_gDGOJ' ");
        
            $data_final_gDGOJ = array(
                $data_gDGOJ[0]['kode_img']
                    =>array('id'=>$data_gDGOJ[0]["id"],
                            'id_bulan'=>$data_gDGOJ[0]["id_bulan"],
                            'bulan'=> getBulanID($data_gDGOJ[0]["id_bulan"]),
                            'id_kota'=>$data_gDGOJ[0]["id_kota"],
                            'kota'=>getKotaID($data_gDGOJ[0]["id_kota"]),
                            'pesan_img'=>$data_gDGOJ[0]["pesan_img"],
                            'path_img'=>$data_gDGOJ[0]["path_img"]
                    )
            );
           
                $tmp_assoc_gDGOJ = array_merge($tmp_assoc_gDGOJ , $data_final_gDGOJ);
            
        }

        return $tmp_assoc_gDGOJ;

    }

    if(isset($_GET['id_bulan_BPT'])){
        unset($_SESSION['data_jadwal_perBulan']);

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
                            'gambar'=>$data_BPT[0]["gambar"]
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

    function getDaftarBulanID($id_gBID){

        $array_ID_gBID = $id_gBID;

        $tmp_assoc_gBID = array();

        for($i = 0; $i < count($array_ID_gBID); $i++){

            $tmp_id_gBID = $array_ID_gBID[$i];

            $data_gBID = runQuery("SELECT id, bulan FROM tour_bulan_skedul WHERE id = '$tmp_id_gBID' ");
        
            $data_final_gBID = array(
                $data_gBID[0]['bulan']
                    =>array('id'=>$data_gBID[0]["id"],
                            'bulan'=>$data_gBID[0]["bulan"]
                    )
            );
           
                $tmp_assoc_gBID = array_merge($tmp_assoc_gBID , $data_final_gBID);
            
        }

        return $tmp_assoc_gBID;

    }

    
    function getBulanID($id_gBID){

        global $db;

        //$sql_admin = "SELECT id FROM tour_bulan_skedul";

        $result_gKID = $db->query("SELECT bulan FROM tour_bulan_skedul WHERE id = '$id_gBID' ");
        $data_gKID = "";

        if ($result_gKID->num_rows > 0) {
            while($row_gKID = $result_gKID->fetch_assoc()) {
                $data_gKID =  $row_gKID['bulan'];
            }
        }
        return $data_gKID;

    }

    function getKotaID($id_){

        global $db;

        //$sql_admin = "SELECT id FROM tour_bulan_skedul";

        $result_gKID = $db->query("SELECT kota FROM tour_kota_skedul WHERE id = '$id_' LIMIT 1 ");
        $data_gKID = "";

        if ($result_gKID->num_rows > 0) {
            while($row_gKID = $result_gKID->fetch_assoc()) {
                $data_gKID =  $row_gKID['kota'];
            }
        }
        return $data_gKID;
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
        return $array_list_gDB;
    }

    function getDataSimple($sql_gDS, $id_){
        global $db;

        //$sql_admin = "SELECT id FROM tour_bulan_skedul";
        $tmp_gDS = str_replace(" ", "", $id_);

        $result_gDS = $db->query($sql_gDS);
        $array_list_gDS = [];
        $incre = 0;

        if ($result_gDS->num_rows > 0) {
            while($row_gDS = $result_gDS->fetch_assoc()) {
                    $array_list_gDS[$incre] =  $row_gDS[$tmp_gDS];
                    $incre = $incre + 1;
            }
        }
        return $array_list_gDS;
    }

    $db->close();

?>