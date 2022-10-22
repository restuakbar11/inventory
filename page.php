<?php error_reporting(E_ERROR | E_WARNING | E_PARSE);
$page = $_GET['page'];

    switch($page)
    {
      	 
		
		// MASTER
		case 'master_data'   : include "module/master_data/master_data.php";
		break;
		
		case 'refrigerator'   : include "module/refrigerator/refrigerator.php";
		break;
		
		case 'ref_detail'   : include "module/refrigerator/refrigerator_detail.php";
		break;
		
		case 'ref_detail_more'   : include "module/refrigerator/v_refDetailMore.php";
		break;
		
		case 'ref_detail_user'   : include "module/refrigerator/v_refDetailUser.php";
		break;
		
		case 'user'   : include "module/user/user.php";
		break;
		
		case 'usergroup'   : include "module/usergroup/usergroup.php";
		break;
		
		case 'usergroupaccess'   : include "module/usergroupaccess/usergroupaccess.php";
		break;
		
		case 'satuan'   : include "module/satuan/satuan.php";
		break;
		
		case 'kelompok_item'   : include "module/kelompok_item/kelompok_item.php";
		break;
		
		case 'item'   : include "module/item/item.php";
		break;
		
		case 'supplier'   : include "module/supplier/supplier.php";
		break;
		
		case 'itemsupplier'   : include "module/itemsupplier/itemsupplier.php";
		break;

		//RESTU
		case 'master_data'   : include "module/master/v_master.php";
		break;
		case 'rakKulkas'   : include "module/rak_kulkas/v_rakKulkas.php";
		break;
		
		case 'add_rak'	: include "module/rak_kulkas/v_addRak.php";
		break;
		// KULKAS
		case 'kulkas'   : include "module/kulkas/v_kulkas.php";
		break;
		case 'add_kulkas'   : include "module/kulkas/v_addKulkas.php";
		break;
		//TYPE KULKAS
		case 'type_kulkas'   : include "module/type_kulkas/v_typekulkas.php";
		break;
		case 'add_typekulkas'   : include "module/type_kulkas/v_addType.php";
		break;
		// GEDUNG
		case 'gedung'	: include "module/gedung/v_gedung.php";
		break;
		case 'add_gedung'	: include "module/gedung/v_addGedung.php";
		break;
		// RUANGAN
		case 'ruangan'	: include "module/ruangan/v_ruangan.php";
		break;
		case 'add_ruangan'	: include "module/ruangan/v_addRuangan.php";
		break;
		// DEPARTMENT
		case 'department'	: include "module/department/v_department.php";
		break;
		case 'add_department'	: include "module/department/v_addDepartment.php";
		break;
		// SUB DEPARTMENT
		case 'sub_department'	: include "module/sub_department/v_subDepartment.php";
		break;
		case 'add_subdep'	: include "module/sub_department/v_addSubDep.php";
		break;
		// SUB DEPARTMENT KULKAS 
		case 'sub_department_kulkas'	: include "module/sub_departmentkulkas/v_subDeptKulkas.php";
		break;
		case 'add_subdeptkulkas'	: include "module/sub_departmentkulkas/v_addSubDepartmentKulkas.php";
		break;
		//Gudang
		case 'gudang'	: include "module/gudang/v_gudang.php";
		break;
		case 'add_gudang'	: include "module/gudang/v_addGudang.php";
		break;
		case 'rakgudang'	: include "module/rakgudang/v_rakgudang.php";
		break;
		case 'add_rakgudang'	: include "module/rakgudang/v_addRakgudang.php";
		break;
		
		
		// KONFIGURASI
		

		// TRANSAKSI
		case 'brg_masuk'	: include "module/barang_masuk/v_brg_masuk.php";
		break;
        
        case 'checkin_brg'	: include "module/checkin_barang/v_checkin_barang.php";
		break;

		case 'add_brg_masuk'	: include "module/barang_masuk/v_addBrg_masuk.php";
		break;

		case 'ctk_barcode'	: include "module/barang_masuk/v_ctk_barcode.php";
		break;

		case 'batal_masuk'	: include "module/barang_masuk/v_btl_msk.php";
		break;
		
		case 'tag'	: include "module/tag/v_tag.php";
		break;
		
		case 'add_tag'	: include "module/tag/v_addTag.php";
		break;

		case 'bataltag'	: include "functions/tag/bataltag.php";
		break;
		
		case 'check_out_tag'	: include "module/tag/v_check_out_tag.php";
		break;
		
		case 'penerimaan_tag'	: include "module/penerimaan_tag/v_penerimaan_tag.php";
		break;
		
		case 'retur'	: include "module/retur/v_retur.php";
		break;
		
		case 'add_retur'	: include "module/retur/v_addRetur.php";
		break;

		case 'batalretur'	: include "functions/retur/batalretur.php";
		break;
		
		case 'check_out_retur'	: include "module/retur/v_check_out_retur.php";
		break;
		
		case 'penerimaan_retur'	: include "module/penerimaan_retur/v_penerimaan_retur.php";
		break;
		
		case 'brg_keluar'	: include "module/barang_keluar/v_barangkeluar.php";
		break;
		
		case 'add_barangkeluar'	: include "module/barang_keluar/v_addbarangkeluar.php";
		break;
		
		case 'check_out_barangkeluar'	: include "module/barang_keluar/v_check_out_barangkeluar.php";
		break;
		
		case 'breakdown'	: include "module/breakdown/v_breakdown.php";
		break;
		
		case 'add_breakdown'	: include "module/breakdown/v_addbreakdown.php";
		break;
		
		case 'view_breakdown'	: include "module/breakdown/v_view_breakdown.php";
		break;

		case 'batal_keluar'	: include "module/barang_keluar/v_btl_keluar.php";
		break;
		
		//PENYIMPANAN
		case 'stock'	: include "module/stock/v_stock.php";
		break;
		
		case 'stock_per_dept'	: include "module/stock_per_dept/v_stock_per_dept.php";
		break;
		
		case 'history'	: include "module/history/v_history.php";
		break;


		// LAPORAN		
		case 'performa'   : include "module/reports/v_lap_performa.php";
		break;
		case 'report_prompt'   : include "module/reports/report_prompt.php";
		break;
		case 'rekap'   : include "module/reports/v_lap_rekap.php";
		break;		

		
			
		default : include "home.php"; break;
    } ;
?>	