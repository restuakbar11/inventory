<?php
error_reporting(0);
include "../../config/connect.php";
session_start();

date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$username		=$_SESSION['username'];

switch ($_POST['act']){
	
	
	case "form" :
	$sql =$mysqli->query( "SELECT * FROM M_USER WHERE USERID='$_POST[userID]' ");
	// oci_execute($sql);
	$r =mysqli_fetch_array($sql);
	
    $data['USER_NAMA']			=$r['USER_NAMA'];
    $data['USERID']				=$r['USERID'];
    $data['USER_USERGROUPID']	=$r['USER_USERGROUPID'];
    $data['USER_KELAMIN']		=$r['USER_KELAMIN'];
    $data['USER_ALAMAT']		=$r['USER_ALAMAT'];
    $data['USER_USERNAME']		=$r['USER_USERNAME'];
    $data['USER_IDDEPARTMENT']	=$r['USER_IDDEPARTMENT'];
    echo json_encode($data);
    break;




	case "hapus":
	$delete =$mysqli->query( "UPDATE M_USER SET 
							USER_ISACTIVE='N',
							USER_LASTUPDATE='$now'
						WHERE USERID='$_POST[userID]' ");
	// oci_execute($delete);
	// oci_commit;
    $data['hasil']=1;
    echo json_encode($data);
	break;




	case "save":
	$inp=$_POST['user'];
    if($inp['act']=='add'){
				/*Action Add Data*/
				$cek_username =$mysqli->query( "SELECT * FROM M_USER WHERE USER_USERNAME='$inp[username]' AND USER_ISACTIVE='Y' ");
				// oci_execute($cek_username);
				$jml =mysqli_num_rows($cek_username);
				
				if($jml>0) {
					$data['hasil']=0;
				} else {
						if($inp['kelamin']=='Laki-laki') {
							$foto='avatar_laki.png';
						} else {
							$foto='avatar_perempuan.png';
						}
						$password=password_hash("$inp[password]", PASSWORD_DEFAULT);
						$input =$mysqli->query( "INSERT INTO M_USER 
												(USER_NAMA,USER_KELAMIN,USER_ALAMAT,USER_FOTO,USER_USERGROUPID,USER_IDDEPARTMENT,USER_USERNAME,USER_PASSWORD,USER_LASTUPDATE) VALUES
												('$inp[nm_user]','$inp[kelamin]','$inp[alamat]','$foto','$inp[grup]','$inp[department]','$inp[username]','$password','$now')
												") ;
						// oci_execute($input);
						// oci_commit;
						$data['hasil']=2;
						$data['nm_user']=$inp['nm_user'];
						$data['kelamin']=$inp['kelamin'];
						$data['alamat']=$inp['alamat'];
						$data['grup']=$inp['grup'];
						$data['username']=$inp['username'];
						$data['password']=$password;
						$data['foto']=$foto;
				}
				
				echo json_encode($data);
    }
    else{
				/*Action Update Data*/
				//Tidak merubah password
				if($_POST['status']==0) {
						if($inp['kelamin']=='Laki-laki') {
							$foto='avatar_laki.png';
						} else {
							$foto='avatar_perempuan.png';
						}
						$update =$mysqli->query( "UPDATE M_USER SET 
													USER_NAMA		='$inp[nm_user]',
													USER_KELAMIN	='$inp[kelamin]',
													USER_ALAMAT		='$inp[alamat]',
													USER_FOTO		='$foto',
													USER_USERGROUPID='$inp[grup]',
													USER_IDDEPARTMENT='$inp[department]',
													USER_LASTUPDATE	='$now'
												WHERE USERID='$inp[userID]' ") ;
						// oci_execute($update);
						// oci_commit;
						$data['hasil']=2;
				} 
				else if($_POST['status']==1) {
				//Merubah password
						if($inp['kelamin']=='Laki-laki') {
							$foto='avatar_laki.png';
						} else {
							$foto='avatar_perempuan.png';
						}
						$password=password_hash("$inp[password]", PASSWORD_DEFAULT);
						$update =$mysqli->query( "UPDATE M_USER SET 
												USER_NAMA		='$inp[nm_user]',
												USER_KELAMIN	='$inp[kelamin]',
												USER_ALAMAT		='$inp[alamat]',
												USER_FOTO		='$foto',
												USER_USERGROUPID='$inp[grup]',
												USER_IDDEPARTMENT='$inp[department]',
												USER_PASSWORD	='$password',
												USER_LASTUPDATE	='$now'
											WHERE USERID='$inp[userID]' ") ;
						// oci_execute($update);
						// oci_commit;
						$data['hasil']=2;
				}
				echo json_encode($data);
    }
	break;
	
}