<?php
error_reporting(0);
include "../../config/connect.php";
session_start();
	if($_GET['status']=='all') {
		$cek_barcode =$mysqli->query( "SELECT * FROM M_ITEMBARCODE WHERE BARANGMASUKDETAILIDMASUK='$_GET[nobarangmasuk_detail]' ");
		// oci_execute($cek_barcode);
		$h =mysqli_num_rows($cek_barcode);
		
		$sql2=$mysqli->query( "SELECT KODEBARCODE,M_ITEMIDITEM,NAMAITEM,LOT_NUMBER,ED
								FROM M_ITEMBARCODE b
								JOIN M_ITEM i ON i.IDITEM=b.M_ITEMIDITEM
								WHERE BARANGMASUKDETAILIDMASUK='$_GET[nobarangmasuk_detail]'  ");
		// oci_execute($sql2);
		$j=1;
		while($m=mysqli_fetch_array($sql2)){
			$kodebarcode[$j]	=$m['KODEBARCODE'];
			$iditem[$j]			=$m['M_ITEMIDITEM'];
			$namaitem[$j]		=$m['NAMAITEM'];
			$lot_number[$j]		=$m['LOT_NUMBER'];
			$ed[$j]				=$m['ED'];
			

			echo"<input type=hidden name='kodebarcode[$j]' id='kodebarcode$j' size=50 value='$kodebarcode[$j]'>
				<input type=hidden name='iditem[$j]' id='iditem$j' size=50 value='$iditem[$j]'>
				<input type=hidden name='namaitem[$j]' id='namaitem$j' size=50 value='$namaitem[$j]'>
				<input type=hidden name='lot_number[$j]' id='lot_number$j' size=50 value='$lot_number[$j]'>
				<input type=hidden name='ed[$j]' id='ed$j' size=50 value='$ed[$j]'>
				</br>";
				 
			$j++;
		}
	} else if($_GET['status']=='satuan') {
		$cek_barcode =$mysqli->query( "SELECT * FROM M_ITEMBARCODE WHERE KODEBARCODE='$_GET[kodebarcode]' ");
		// oci_execute($cek_barcode);
		$h =mysqli_num_rows($cek_barcode);
		
		$sql2=$mysqli->query( "SELECT KODEBARCODE,M_ITEMIDITEM,NAMAITEM,LOT_NUMBER,ED
								FROM M_ITEMBARCODE b
								JOIN M_ITEM i ON i.IDITEM=b.M_ITEMIDITEM
								WHERE KODEBARCODE='$_GET[kodebarcode]'  ");
		// oci_execute($sql2);
		$j=1;
		while($m=mysqli_fetch_array($sql2)){
			$kodebarcode[$j]	=$m['KODEBARCODE'];
			$iditem[$j]			=$m['M_ITEMIDITEM'];
			$namaitem[$j]		=$m['NAMAITEM'];
			$lot_number[$j]		=$m['LOT_NUMBER'];
			$ed[$j]				=$m['ED'];
			

			echo"<input type=hidden name='kodebarcode[$j]' id='kodebarcode$j' size=50 value='$kodebarcode[$j]'>
				<input type=hidden name='iditem[$j]' id='iditem$j' size=50 value='$iditem[$j]'>
				<input type=hidden name='namaitem[$j]' id='namaitem$j' size=50 value='$namaitem[$j]'>
				<input type=hidden name='lot_number[$j]' id='lot_number$j' size=50 value='$lot_number[$j]'>
				<input type=hidden name='ed[$j]' id='ed$j' size=50 value='$ed[$j]'>
				</br>";
				 
			$j++;
		}
	}
		echo "<input type=hidden id='jml' value='$h' >" ; ?>
   <body onload="print(<?= $h ?>)">
   <html>
   <script>
      
    function print(h) {
        var i;
         var applet = document.jZebra;
         if (applet != null) {
            applet.findPrinter("zebra");
	    	while (!applet.isDoneFinding()) {
            }
	    	var ps = applet.getPrintService();
			if ( ps == null ) {
				alert('Printer dengan nama zebra tidak ditemukan!');
				return;
			}
         }
         else {
            alert("Applet not loaded!");
            return;
         }
                  
         if (applet != null) {
            for (i = 1; i <= h; i++){
				var kodebarcode = document.getElementById("kodebarcode"+i).value;
				var iditem = document.getElementById("iditem"+i).value;
				var namaitem = document.getElementById("namaitem"+i).value;
				var lot_number = document.getElementById("lot_number"+i).value;
				var ed = document.getElementById("ed"+i).value;
					
				/*applet.append("CT~~CD,~CC^~CT~");
				applet.append("^XA~TA000~JSN^LT0^MNW^MTT^PON^PMN^LH0,0^JMA^PR5,5~SD15^JUS^LRN^CI0^XZ");
				applet.append("^XA");
				applet.append("^MMT");
				applet.append("^PW384");
				applet.append("^LL0208");
				applet.append("^LS0");
				applet.append("^FT38,170^BQN,2,5");
				applet.append("^FH\^FDMA,"+kodebarcode+"^FS");
				applet.append("^FT375,175^A0I,28,28^FH\^FDPT GRACIA VISI PRATAMA^FS");
				applet.append("^FT371,13^A0I,11,12^FH\^FD"+namaitem+"^FS");
				applet.append("^FT137,28^A0I,17,16^FH\^FD"+iditem+"^FS");
				applet.append("^FT365,146^A0I,11,12^FH\^FDLot Number :^FS");
				applet.append("^FT366,119^A0I,17,16^FH\^FD"+lot_number+"^FS");
				applet.append("^FT363,90^A0I,11,12^FH\^FDED :^FS");
				applet.append("^FT364,65^A0I,17,16^FH\^FD"+ed+"^FS");
				applet.append("^PQ1,0,1,Y^XZ");*/
				applet.append("CT~~CD,~CC^~CT~");
				applet.append("^XA~TA000~JSN^LT0^MNW^MTT^PON^PMN^LH0,0^JMA^PR2,2~SD15^JUS^LRN^CI0^XZ");
				applet.append("^XA");
				applet.append("^MMT");
				applet.append("^PW416");
				applet.append("^LL0272");
				applet.append("^LS0");
				applet.append("^FT27,212^BQN,2,5");
				applet.append("^FH\^FDLA,"+kodebarcode+"^FS");
				applet.append("^FT399,221^A0I,28,28^FH\^FDPT GRACIA VISI PRATAMA^FS");
				applet.append("^FT399,177^A0I,20,19^FH\^FDLot Number :^FS");
				applet.append("^FT400,152^A0I,17,16^FH\^FD"+lot_number+"^FS");
				applet.append("^FT397,116^A0I,20,19^FH\^FDED :^FS");
				applet.append("^FT400,92^A0I,17,16^FH\^FD"+ed+"^FS");
				applet.append("^FT399,24^A0I,17,16^FH\^FD"+namaitem+"^FS");
				applet.append("^FT246,57^A0I,20,19^FH\^FD"+iditem+"^FS");
				applet.append("^PQ1,0,1,Y^XZ");
				applet.print();
			}
		}
	}
   </script>
   
   <applet name="jZebra" code="jzebra.RawPrintApplet.class" archive="jzebra.jar" style="position:relative;top:-1000px;" width="1" height="1">
      <param name="printer" value="zebra">
      <param name="sleep" value="5000">
   </applet><br><br>
   </body>
</html>