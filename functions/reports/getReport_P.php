<?php
$out = ob_get_contents();
ob_end_clean();
include("../../vendor/mpdf-5.7/mpdf.php");
$mpdf = new mPDF('C','A4','','',10,10,10,10,10,''); //10 -> margin kiri, 10 -> margin kanan, 37 ->margin atas, 10 -> margin bawah, 10 -> margin header, 10 -> margin footer
$mpdf->mirrorMargins = 1;
$mpdf->SetHTMLHeader($header,'O');
$mpdf->SetHTMLHeader($headerE,'E');
$mpdf->SetDisplayMode('fullpage');
$stylesheet = file_get_contents('../../vendor/mpdf-5.7/mpdf.css');
$mpdf->use_kwt = true;
$mpdf->SetHTMLFooter('
<table width="100%">
    <tr>
        <td width="33%">'.$kode_laporan.'</td>
        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
        <td width="33%" style="text-align: right;">'.$tgl.'</td>
    </tr>
</table>');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($out);
$mpdf->Output();
?>