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

    if(isset($pageMerchan)){
        if($pageMerchan == "merchandise"){
            getDataListMerchan();
        }
    }

    if(isset($_GET['kode_item'])){
        tambahItemPesan($_GET['kode_item']);
        unset($_GET['kode_item']);
        header('Location: merchandise.php');
        exit();
    }

    if(isset($_GET['empty_keranjang'])){
        if($_GET['empty_keranjang'] == TRUE){
            unset($_SESSION['item_dipesan']);
        }
        unset($_GET['empty_keranjang']);
    }
    
    function tambahItemPesan($kode){
        $kode_ = str_replace(" ", "", $kode);
        $data_TIP = runQuery("SELECT id, nama, kode_item, harga_item, gambar_item FROM merchandise_item 
                WHERE kode_item = '$kode_' ");
        $array_data_TIP = array(
            $data_TIP[0]['kode_item']
                =>array('id'=>$data_TIP[0]['id'],
                        'nama'=>$data_TIP[0]['nama'], 
                        'kode_item'=>$data_TIP[0]['kode_item'],
                        'harga_item'=>$data_TIP[0]['harga_item'], 
                        'gambar_item'=>$data_TIP[0]['gambar_item'],
                        'kuantitas'=>'1'
                )
        );

        if(!empty($_SESSION['item_dipesan'])){
             
            if(cekProdukDalamArray($kode_, $_SESSION['item_dipesan']) == TRUE ){
                
                (int)$_SESSION['item_dipesan'][$kode_]['kuantitas'] += 1;

            }else{
                
                //hati2 saat menggunakan array_merge, kalo key tiap assosiative arraynya int maka
                //tiap kali akses fungsi ini maka arraynya akan direset. coba bukak link
                //https://www.w3schools.com/php/func_array_merge.asp => example 2

                $_SESSION['item_dipesan'] = array_merge($_SESSION['item_dipesan'], $array_data_TIP);
            }
        }else{
            $_SESSION['item_dipesan'] = $array_data_TIP;
        } 
    }

    function getDataListMerchan(){
        unset($_SESSION['list_merchan']);


        $dta_gDLM = getDataBaris("SELECT id FROM merchandise_item");

        
        for($i = 0; $i < count($dta_gDLM); $i++){
            $id_gDLM = $dta_gDLM[$i];
            $data_gDLM = runQuery("SELECT id, nama, kode_item, harga_item, gambar_item FROM merchandise_item 
                WHERE id = '$id_gDLM' ");
        
            $array_data_gDLM = array(
                $data_gDLM[0]['kode_item']
                    =>array('id'=>$data_gDLM[0]['id'],
                            'nama'=>$data_gDLM[0]['nama'], 
                            'kode_item'=>$data_gDLM[0]['kode_item'],
                            'harga_item'=>$data_gDLM[0]['harga_item'], 
                            'gambar_item'=>$data_gDLM[0]['gambar_item']
                    )
            );

            if(!isset($_SESSION['list_merchan'])){
                $_SESSION['list_merchan'] = $array_data_gDLM;
            }else{
                $_SESSION['list_merchan'] = array_merge($_SESSION['list_merchan'] 
                    , $array_data_gDLM);
            }
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

    //ngecek isi session booking roti, ada ggak kode roti data_cPDA di sessio booking roti 
    function cekProdukDalamArray($data_cPDA, $dataArray_cPDA){
        //bisa makek fungsi array php => in_array
        //cari aja gimana fungsinya

        $kunci_cPDA = $data_cPDA;
        $status_cPDA = false;
        
        $keyArray_cPDA = array_keys($dataArray_cPDA);
        
        foreach($keyArray_cPDA as $value_cPDA){

            if($value_cPDA == $kunci_cPDA){
                $status_cPDA = true;
                break;
            }
        }

        return $status_cPDA;
    }

    $db->close();

?>