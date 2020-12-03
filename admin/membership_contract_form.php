<?php
include ('inc/db_connection_session.php');
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}

$agentId = $_SESSION['agentId'];
$agentFullName = $_SESSION['agentFullName'];
$membershipDate = $_SESSION['membershipDate'];
$address = $_SESSION['address'];
$noOfVehicles = $_SESSION['noOfVehicles'];
$vehicleDescription = $_SESSION['vehicleDescription'];
$membershipFee = $_SESSION['membershipFee'];
$paidAmount = $_SESSION['paidAmount'];
$remainingAmount = $_SESSION['remainingAmount'];
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Javascript Form and user rights (only works on Adobe Acrobat)
 * @author Nicola Asuni
 * @since 2008-03-04
 */


// Include the main TCPDF library (search for installation path).

require_once('plugins/tcpdf-master/tcpdf_include.php');
include('plugins/tcpdf-master/tcpdf.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('AsanSafar');
$pdf->SetTitle('AsanSafar Membership Form');
$pdf->SetSubject('Client Membership');
$pdf->SetKeywords('AsanSafar, Transportation Management System, Afghanistan, Kabul, Booking, Travel');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// IMPORTANT: disable font subsetting to allow users editing the document
$pdf->setFontSubsetting(false);

// set font
$pdf->SetFont('helvetica', '', 10, '', false);

// add a page
$pdf->AddPage();

/*
It is possible to create text fields, combo boxes, check boxes and buttons.
Fields are created at the current position and are given a name.
This name allows to manipulate them via JavaScript in order to perform some validation for instance.
*/

// set default form properties
$pdf->setFormDefaultProp(array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 200), 'strokeColor'=>array(255, 128, 128)));

$pdf->SetFont('helvetica', 'BI', 18);
$pdf->Cell(0, 5, 'AsanSafar Membership Contract', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('helvetica', '', 12);
// Agency ID
$pdf->Cell(45, 6, 'Agency ID:');
$pdf->TextField('agencyId', 60, 6,array(),array('v'=>$agentId));
$pdf->Ln(7);
// Full name
$pdf->Cell(45, 6, 'Full name:');
$pdf->TextField('fullName', 60, 6,array(),array('v'=>$agentFullName));
$pdf->Ln(7);
// Membership date
$pdf->Cell(45, 6, 'Date:');
$pdf->TextField('date', 60, 6, array(), array('v'=>date('Y-m-d'), 'dv'=>date('Y-m-d')));
$pdf->Ln(7);
// Address
$pdf->Cell(45, 6, 'Address:');
$pdf->TextField('address', 60, 18, array('multiline'=>true, 'lineWidth'=>0, 'borderStyle'=>'none'),array('v'=>$address));
$pdf->Ln(19);

// Total Number of Vehicles
$pdf->Cell(45, 6, 'Number of Vehicles:');
$pdf->TextField('noOfVehicles', 60, 6,array(),array('v'=>$noOfVehicles));
$pdf->Ln(7);
// Vehicles description
$pdf->Cell(45, 6, 'Vehicles Description:');
$pdf->TextField('desc', 60, 25, array('multiline'=>true, 'lineWidth'=>0, 'borderStyle'=>'none'),array('v'=>$vehicleDescription));
$pdf->Ln(26);
// Membership fee
$pdf->Cell(45, 6, 'Membership Fee:');
$pdf->TextField('membershipFee', 60, 6,array(),array('v'=>$membershipFee));
$pdf->Ln(7);
// Membership fee
$pdf->Cell(45, 6, 'Paid Amount:');
$pdf->TextField('paidAmount', 60, 6,array(),array('v'=>$paidAmount));
$pdf->Ln(7);
// Membership fee
$pdf->Cell(45, 5, 'Remaining Amount:');
$pdf->TextField('remainingAmount', 60, 6,array(),array('v'=>$remainingAmount));
$pdf->Ln(7);

$pdf->Ln();
$pdf->writeHTML("<hr>", true, false, false, false, '');

// set some language dependent data:
$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'fa';
$lg['w_page'] = 'page';

// set some language-dependent strings (optional)
$pdf->setLanguageArray($lg);

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 12);
// set LTR direction for english translation
$pdf->setRTL(true);

// Persian and English content
$htmlpersian = '<span></span><br /> بنده تمام معلومات درج این قرارداد خط را به شکل درست خوانده و تصدیق مینمایم و اینک با تمام مقررات شرکت آسان سفر موافقه نموده و این قرارداد خط را به امضا میرسانم و درصورت هرگونه تخطی و یا خلاف ورزی طرفین میتوانند قرارداد ذیل را منسوخ نمایند. .<br /><br /><br />امضا و یا شصت .<br />مهر شر کت (درصورت داشتن مهر)<br /><br />';
$pdf->WriteHTML($htmlpersian, true, 0, true, 0);

// set LTR direction for english translation
$pdf->setRTL(false);

$pdf->SetFontSize(10);

// print newline
$pdf->Ln();

// Persian and English content
$htmlpersiantranslation = '<span>AsanSafar CEO Signature<br /><br />AsanSafar Stamp</span>';
$pdf->WriteHTML($htmlpersiantranslation, true, 0, true, 0);

// set LTR direction for english translation
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetX(60);

// Button to validate and print
$pdf->Button('print', 30, 10, 'Print', 'Print()', array('lineWidth'=>2, 'borderStyle'=>'beveled', 'fillColor'=>array(128, 196, 255), 'strokeColor'=>array(64, 64, 64)));

// Reset Button
$pdf->Button('reset', 30, 10, 'Reset', array('S'=>'ResetForm'), array('lineWidth'=>2, 'borderStyle'=>'beveled', 'fillColor'=>array(128, 196, 255), 'strokeColor'=>array(64, 64, 64)));

// Submit Button
$pdf->Button('submit', 30, 10, 'Submit', array('S'=>'SubmitForm', 'F'=>'http://localhost/printvars.php', 'Flags'=>array('ExportFormat')), array('lineWidth'=>2, 'borderStyle'=>'beveled', 'fillColor'=>array(128, 196, 255), 'strokeColor'=>array(64, 64, 64)));

// Form validation functions
$js = <<<EOD
function CheckField(name,message) {
	var f = getField(name);
	if(f.value == '') {
	    app.alert(message);
	    f.setFocus();
	    return false;
	}
	return true;
}
function Print() {
	if(!CheckField('agencyId','Agench Id is mandatory')) {return;}
	if(!CheckField('fullName','Full name is mandatory')) {return;}
	if(!CheckField('date','Membership date is mandatory')) {return;}
	if(!CheckField('address','Address is mandatory')) {return;}
	if(!CheckField('noOfVehicles','Number of vehicle is mandatory')) {return;}
	if(!CheckField('desc','Vehicles description is mandatory')) {return;}
	if(!CheckField('membershipFee','Membership fee is mandatory')) {return;}
	if(!CheckField('paidAmount','Paid amount is mandatory')) {return;}
	if(!CheckField('remainingAmount','Remaining amount is mandatory')) {return;}
	print();
}
EOD;

// Add Javascript code
$pdf->IncludeJS($js);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('membership_contract_form.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+
