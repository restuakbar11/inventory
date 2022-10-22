<?php

include ('config/connect.php');
session_start ();
$user 		= $_POST ['username'];
$pass_asli 	= md5($_POST ['password']);


	if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){
				//echo "You have logged in. </br> Please <a href='logout.php'> Logout. </a>";
			$data['status']='logon';
			echo json_encode($data);
	} else {
		$sql =$mysqli->query ( "SELECT * FROM M_USER s
											JOIN M_USERGROUP g ON g.USERGROUPID=s.USER_USERGROUPID
											WHERE USER_USERNAME='$user' AND USER_PASSWORD='$pass_asli' AND USER_ISACTIVE='Y' ");
		
		$jml =mysqli_num_rows($sql);
		$r =mysqli_fetch_array($sql);
		
		if ($jml > 0 ) 
		{
			
					date_default_timezone_set('Asia/Jakarta');
					$now  		= date('Y-m-d H:i:s');
					
					#jika sukses
					$_SESSION['LAST_ACTIVITY'] = time();
					$_SESSION['signed_in'] = true;
					$_SESSION['username']=$r['USER_USERNAME'];
					$_SESSION['grupID']=$r['USER_USERGROUPID'];
					$_SESSION['grupNama']=$r['USERGROUPNAMA'];
					$_SESSION['id_department']=$r['USER_IDDEPARTMENT'];
					$_SESSION['userID']=$r['USERID'];
					$_SESSION['userNama']=$r['USER_NAMA'];
					$_SESSION['userFoto']=$r['USER_FOTO'];
					$_SESSION['grupMasterID']=$r['USER_MASTERGROUPID'];
					$_SESSION['inventory_refrig']=true;
					
					if($_COOKIE['tema']=='') {
						setcookie('tema', 'amber');
					}
					if($_COOKIE['user_background']=='') {
						setcookie('user_background', 'user_background00.jpg');
					}

					$data['status']='sukses';
					echo json_encode($data);
			
			
		} else {
			
			$data['status']='gagal';
			echo json_encode($data);
		}
	}
/*https://sistemit.com/app/phpenc/process.php*/
?>

