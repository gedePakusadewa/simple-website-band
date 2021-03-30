
<?php 
    //<!-- https://codewithawa.com/posts/admin-and-user-login-in-php-and-mysql-database-->

    session_start();   

    $_SESSION['pesan'] = "";
    
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "band_cold_play";

    $db = new mysqli($servername, $username, $password, $dbname);

    if ($db->connect_error) {
        die("Koneksi Gagal: " . $db->connect_error);
    } 
    
    //variable buat login dan register
    $username = "";
    $email    = "";
    $errors   = array(); 

    if (isset($_POST['register_btn'])) {
        register();
    }

    function register(){

        global $db, $errors, $username, $email;

        $username    =  e($_POST['username']);
        $username    =  stripslashes($username);

        $password_1  =  e($_POST['password_1']);
        $password_2  =  e($_POST['password_2']);

        if (empty($username)) { 
            array_push($errors, "Username is required"); 
        }
        if (empty($password_1)) { 
            array_push($errors, "Password is required"); 
        }
        if ($password_1 != $password_2) {
            array_push($errors, "The two passwords do not match");
        }

        if (count($errors) == 0) {
            $password = md5($password_1);
        
            $dat1 = $username;
            $dat2 = $password;

            $stmt_register = $db->prepare("INSERT INTO ulala_beibeh (username, 
            password) VALUES (?, ?)");
            $stmt_register->bind_param("ss", $dat1, $dat2);           

            if($stmt_register->execute()){
                $_SESSION['user'] = getUserById($db->insert_id);
                header('Location: log_in.php');
            }

            $stmt_register->close();
        
            exit();	
        }
    }

    function getUserById($id){
        global $db;

        $id_user = $id;

        //hati2 naruh $stmt->close()
        if($stmt_user = $db->prepare("SELECT * FROM user_roti_ku WHERE id = ?")){
            $stmt_user->bind_param("d", $id_user);

            $stmt_user->execute();
    
            $stmt_user->bind_result($hasil);
    
            $stmt_user->fetch();

            $stmt_user->close();
        }        

        return $hasil;
    }

    // escape string
    function e($val){
        global $db;
        return mysqli_real_escape_string($db, trim($val));
    }

    function display_error() {
        global $errors;

        if (count($errors) > 0){
            echo "<div class=\"error\">";
                foreach ($errors as $error){
                    echo $error ."<br />";
                }
            echo "</div>";
        }
    }
    
    function isLoggedIn(){
        if (isset($_SESSION['user'])){
            return true;
        }else{
            return false;
        }
    }

    if (isset($_POST['login_btn'])) {
        login();
    }

    function login(){
        global $db, $username, $errors;

        $username  = e($_POST['username']);
        $username  = stripslashes($username);

        $password  = e($_POST['password']);

        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }

        if (count($errors) == 0) {
            $password = md5($password);

            if($stmt_login = $db->prepare("SELECT * FROM ulala_beibeh WHERE username = ? AND 
                password = ? LIMIT 1")){

                $stmt_login->bind_param("dd", $username, $password);

                $stmt_login->execute();
        
                $hasil_login = $stmt_login->get_result();

                if (($hasil_login->num_rows) == 1) {
                    
                    $logged_in_user = $hasil_login->fetch_assoc();

                    //if ($logged_in_user['user_type_log'] == 'admin') {

                        $_SESSION['user'] = $logged_in_user;
                        header('Location: ulala_page.php');	
                        exit();	  
                    //}else if ($logged_in_user['user_type_log'] == 'normal'){
                        /*
                        $_SESSION['user'] = $logged_in_user;
                        header('Location: /websiteJualRoti/dashboard_rotiku.php');
                        exit();
                        */
                    //}
                }else {
                    array_push($errors, "Wrong username/password combination");
                }

                $stmt_login->close();
            }    
        }        
    }

    if(isset($pageUlala)){
        if($pageUlala == "ulala_page"){
            tampilTabel_harga_tiket();
            tampilTabel_jumlah_tiket();
        }
    }
    
    if(isset($pageTour)){
        if($pageTour == "tour_ulala"){
            tampilTabel_tour_bulan();
            tampilTabel_tour_kota();
        }
    }

    function tampilTabel_harga_tiket(){

        unset($_SESSION['data_tabel_HARGA_TIKET']);

        $dta_baris_tTht = getDataBaris("SELECT id FROM harga_tiket");

        for($i = 0; $i < count($dta_baris_tTht); $i++){
            $id_tTht = $dta_baris_tTht[$i];
            $data_tTht = runQuery("SELECT id, tipe_tiket, on_the_spot, early_bird FROM harga_tiket 
                WHERE id = '$id_tTht' ");
        
            $array_data_tTht = array(
                $data_tTht[0]['tipe_tiket']
                    =>array('id'=>$data_tTht[0]["id"],
                            'tipe_tiket'=>$data_tTht[0]["tipe_tiket"], 
                            'on_the_spot'=>$data_tTht[0]["on_the_spot"],
                            'early_bird'=>$data_tTht[0]["early_bird"]
                    )
            );

            if(!isset($_SESSION['data_tabel_HARGA_TIKET'])){
                $_SESSION['data_tabel_HARGA_TIKET'] = $array_data_tTht;
            }else{
                $_SESSION['data_tabel_HARGA_TIKET'] = array_merge($_SESSION['data_tabel_HARGA_TIKET'] 
                    , $array_data_tTht);
            }
        }   
    }

    
    function tampilTabel_jumlah_tiket(){

        unset($_SESSION['data_tabel_JUMLAH_TIKET']);

        $dta_baris_tTjt = getDataBaris("SELECT id FROM jumlah_tiket_dibeli");
        
        $_SESSION['tes'] = $dta_baris_tTjt; 

        for($i = 0; $i < count($dta_baris_tTjt); $i++){

            $id_tTjt = $dta_baris_tTjt[$i];
            
            $data_tTjt = runQuery("SELECT id, id_bulan, id_kota, tipe_tiket, 
                early_bird, on_the_spot FROM jumlah_tiket_dibeli 
                WHERE id = '$id_tTjt' ");
        
            $array_data_tTjt = array(
                $data_tTjt[0]['id']
                    =>array('id'=>$data_tTjt[0]["id"],
                            'bulan'=>getBulanDariID($data_tTjt[0]["id_bulan"]), 
                            'kota'=>getKotaDariID($data_tTjt[0]["id_kota"]),
                            'tipe_tiket'=>$data_tTjt[0]["tipe_tiket"],
                            'early_bird'=>$data_tTjt[0]["early_bird"], 
                            'on_the_spot'=>$data_tTjt[0]["on_the_spot"]
                    )
            );

            if(!isset($_SESSION['data_tabel_JUMLAH_TIKET'])){
                $_SESSION['data_tabel_JUMLAH_TIKET'] = $array_data_tTjt;
            }else{
                $_SESSION['data_tabel_JUMLAH_TIKET'] = array_merge($_SESSION['data_tabel_JUMLAH_TIKET'] 
                    , $array_data_tTjt);
            }
        }   
    }

    function tampilTabel_tour_bulan(){

        unset($_SESSION['data_tabel_tour_bulan']);

        $dta_baris_tTtb = getDataBaris("SELECT id FROM tour_bulan_skedul");
        
        //$_SESSION['tes'] = $dta_baris_tTtb; 

        for($i = 0; $i < count($dta_baris_tTtb); $i++){

            $id_tTtb = $dta_baris_tTtb[$i];
            
            $data_tTtb = runQuery("SELECT id, bulan, tahun, status_tiket FROM tour_bulan_skedul 
                WHERE id = '$id_tTtb' ");
        
            $array_data_tTtb = array(
                $data_tTtb[0]['id']
                    =>array('id'=>$data_tTtb[0]["id"],
                            'bulan'=>$data_tTtb[0]["bulan"], 
                            'tahun'=>$data_tTtb[0]["tahun"],
                            'status_tiket'=>$data_tTtb[0]["status_tiket"]
                    )
            );

            if(!isset($_SESSION['data_tabel_tour_bulan'])){
                $_SESSION['data_tabel_tour_bulan'] = $array_data_tTtb;
            }else{
                $_SESSION['data_tabel_tour_bulan'] = array_merge($_SESSION['data_tabel_tour_bulan'] 
                    , $array_data_tTtb);
            }
        }   
    }

    function tampilTabel_tour_kota(){

        unset($_SESSION['data_tabel_tour_kota']);

        $dta_baris_tTtk = getDataBaris("SELECT id FROM tour_kota_skedul");
        
        //$_SESSION['tes'] = $dta_baris_tTtb; 

        for($i = 0; $i < count($dta_baris_tTtk); $i++){

            $id_tTtk = $dta_baris_tTtk[$i];
            
            $data_tTtk = runQuery("SELECT id, id_bulan, kota, tanggal, pesan FROM tour_kota_skedul 
                WHERE id = '$id_tTtk' ");
        
            $array_data_tTtk = array(
                $data_tTtk[0]['id']
                    =>array('id'=>$data_tTtk[0]["id"],
                            'bulan'=>getBulanDariID($data_tTtk[0]["id_bulan"]), 
                            'kota'=>$data_tTtk[0]["kota"],
                            'tanggal'=>$data_tTtk[0]["tanggal"],
                            'pesan'=>$data_tTtk[0]["pesan"],
                    )
            );

            if(!isset($_SESSION['data_tabel_tour_kota'])){
                $_SESSION['data_tabel_tour_kota'] = $array_data_tTtk;
            }else{
                $_SESSION['data_tabel_tour_kota'] = array_merge($_SESSION['data_tabel_tour_kota'] 
                    , $array_data_tTtk);
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
    
    function getBulanDariID($id_bulan_gBDID){
        global $db;

        if($stmt_gBDID = $db->prepare("SELECT bulan FROM tour_bulan_skedul WHERE id = ?")){
            $stmt_gBDID->bind_param("d", $id_bulan_gBDID);

            $stmt_gBDID->execute();
    
            $hasil_gBDID = $stmt_gBDID->get_result();

            if(($hasil_gBDID->num_rows) != 0) {
                while ($row_gBDID = $hasil_gBDID->fetch_assoc()) {
                    $bulan_gBDID = $row_gBDID['bulan']; 
                }
            }

            $stmt_gBDID->close();  
        }
        return $bulan_gBDID;
    }

    function getKotaDariID($id_bulan_gKDID){
        global $db;

        if($stmt_gKDID = $db->prepare("SELECT kota FROM tour_kota_skedul WHERE id = ?")){
            $stmt_gKDID->bind_param("d", $id_bulan_gKDID);

            $stmt_gKDID->execute();
    
            $hasil_gKDID = $stmt_gKDID->get_result();

            if(($hasil_gKDID->num_rows) != 0) {
                while ($row_gKDID = $hasil_gKDID->fetch_assoc()) {
                    $bulan_gKDID = $row_gKDID['kota']; 
                }
            }

            $stmt_gKDID->close();  
        }
        return $bulan_gKDID;
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

    $db->close();
    
?>