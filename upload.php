<?php
  include 'config/connect.php';
  session_start();
 
	/*$temp = "images222/";
	if (!file_exists($temp))
		mkdir($temp);*/
	$temp = dirname (__FILE__)."/images/";

	# periksa apakah folder sudah ada
	if (!is_dir($temp)) {
		# jika tidak maka folder harus dibuat terlebih dahulu
		mkdir($temp, 0777, $rekursif = true);
	}

	$file_type	= array('jpg','jpeg','png');
	
	$file_name	= $_FILES['gambar']['name'];
	$explode	= explode('.',$file_name);
	$extensi	= $explode[count($explode)-1];
	$file_tmp 	= $_FILES['gambar']['tmp_name'];
	$random		= rand(1,999);
	if($file_name=="") {
		/*$data['hasil']=0; //nama file kosong
		$data['nama']=$file_name;
		$data['ext']=$extensi;*/
		echo"kosong";
	}else {
		$namafile=$random.$file_name;
		if(!in_array($extensi,$file_type)){
			/*$data['hasil']=1; //extensi tidak sesuai
			$data['nama']=$file_name;
			$data['ext']=$extensi;
			$data['newnama']=$namafile;*/
			echo"ext";
		}
		else {
			if (is_uploaded_file($_FILES['gambar']['tmp_name'])) {
				chmod("$gambar", 0644);
				$cek = move_uploaded_file($_FILES['gambar']['tmp_name'], $temp.$nama_file);
				if ($cek) {
					die( "File berhasil diupload");

				} else {
					die("File gagal diupload, kode error = " . $_FILES['gambar']['error']);
					echo ($_FILES);
				}
				//echo "masuk";
			} else {
				echo "gagal";
			}
			//move_uploaded_file($file_tmp,"$temp/$namafile");
			/*$data['hasil']=3; //berhasil
			$data['nama']=$file_name;
			$data['ext']=$extensi;
			$data['newnama']=$namafile;
			$data['tmp']=$file_tmp;*/
			//echo"$temp/$namafile <br> $file_tmp";
		}
	}
	//echo json_encode($data);
	
	/*$update =$mysqli->query( "UPDATE M_USER SET
									USER_PROFIL ='$_POST[foto]'
								WHERE USERID='2' ");
	$data['hasil']=3; //berhasil
	echo json_encode($data);*/
?>