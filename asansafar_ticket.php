<?php
include ('inc/db_connection_session.php');

$ticketId = $_SESSION['ticketId'];
$srcPlace = $_SESSION['srcPlace'];
$destPlace = $_SESSION['destPlace'];
$distance = $_SESSION['distance'];
$departureDate = $_SESSION['departureDate'];
$arrivalDate = $_SESSION['arrivalDate'];
$departureTime = $_SESSION['departureTime'];
$arrivalTime = $_SESSION['arrivalTime'];
$price = $_SESSION['price'];
$setNo = $_SESSION['setNo'];
$discount = $_SESSION['discount'];
$vehicleType = $_SESSION['vehicleType'];
$duration = $_SESSION['duration'];
$vehicleImg = $_SESSION['vehicleImg'];
$clientFullName = $_SESSION['clientFullName'];
$clientMobile = $_SESSION['clientMobile'];
$clientEmail = $_SESSION['clientEmail'];
$bookingDate = $_SESSION['bookingDate'];
$bookingTime = $_SESSION['bookingTime'];
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
$pdf->SetTitle('Ticket Booking');
$pdf->SetKeywords('AsanSafar, Transportation Management System, Afghanistan, Kabul, Booking, Travel');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Online Ticket Booking', 'AsanSafar, Kabul-Afghanistan');

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
$pdf->Cell(0, 5, 'AsanSafar Ticket Booking', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('helvetica', '', 12);
// Ticket ID
$pdf->Cell(45, 6, 'Ticket Id:');
$pdf->TextField('ticketId',60, 6,array(),array('v'=>$ticketId));
$pdf->Ln(7);
// Source Place
$pdf->Cell(45, 6, 'Source Place:');
$pdf->TextField('srcPlace', 60, 6,array(),array('v'=>$srcPlace));
$pdf->Ln(7);
// Destination Place
$pdf->Cell(45, 6, 'Destination Place:');
$pdf->TextField('destPlace', 60, 6,array(),array('v'=>$destPlace));
$pdf->Ln(7);
// Distance
$pdf->Cell(45, 6, 'Distance:');
$pdf->TextField('distance', 60, 6,array(),array('v'=>$distance));
$pdf->Ln(7);
// Departure Date
$pdf->Cell(45, 6, 'Departure Date:');
$pdf->TextField('departureDate', 60, 6,array(),array('v'=>$departureDate));
$pdf->Ln(7);
// Arrival Date
$pdf->Cell(45, 6, 'Arrival Date:');
$pdf->TextField('arrivalDate', 60, 6,array(),array('v'=>$arrivalDate));
$pdf->Ln(7);
// Departure Time
$pdf->Cell(45, 6, 'Departure Time:');
$pdf->TextField('departureTime', 60, 6,array(),array('v'=>$departureTime));
$pdf->Ln(7);
// Arrival Time
$pdf->Cell(45, 6, 'Arrival Time:');
$pdf->TextField('arrivalTime', 60, 6,array(),array('v'=>$arrivalTime));
$pdf->Ln(7);
// Price
$pdf->Cell(45, 6, 'Price:');
$pdf->TextField('price', 60, 6,array(),array('v'=>$price));
$pdf->Ln(7);
// Set Number
$pdf->Cell(45, 6, 'Set Number:');
$pdf->TextField('setNo', 60, 6,array(),array('v'=>$setNo));
$pdf->Ln(7);
// Discount
$pdf->Cell(45, 6, 'Discount:');
$pdf->TextField('discount', 60, 6,array(),array('v'=>$discount));
$pdf->Ln(7);
// Vehicle Type
$pdf->Cell(45, 6, 'Vehicle Type:');
$pdf->TextField('vehicleType', 60, 6,array(),array('v'=>$vehicleType));
$pdf->Ln(7);
// Vehicle Type
$pdf->Cell(45, 6, 'Duration:');
$pdf->TextField('duration', 60, 6,array(),array('v'=>$duration));
$pdf->Ln(7);
// Client Full Name
$pdf->Cell(45, 6, 'Client Name:');
$pdf->TextField('clientFullName', 60, 6,array(),array('v'=>$clientFullName));
$pdf->Ln(7);
// Client Mobile
$pdf->Cell(45, 6, 'Client Mobile:');
$pdf->TextField('clientMobile', 60, 6,array(),array('v'=>$clientMobile));
$pdf->Ln(7);
// Client Email
$pdf->Cell(45, 6, 'Client Email:');
$pdf->TextField('clientEmail', 60, 6,array(),array('v'=>$clientEmail));
$pdf->Ln(7);
// Booking Date
$pdf->Cell(45, 6, 'Booking Date:');
$pdf->TextField('bookingDate', 60, 6,array(),array('v'=>$bookingDate));
$pdf->Ln(7);
// Booking Time
$pdf->Cell(45, 6, 'Booking Time:');
$pdf->TextField('bookingTime', 60, 6,array(),array('v'=>$bookingTime));
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



// set LTR direction for english translation
$pdf->setRTL(false);

$pdf->SetFontSize(10);

// print newline
$pdf->Ln();

// Persian and English content
$htmlpersiantranslation = '<span><strong>Email:</strong> asansafar@gmail.com
<br />
<strong>Contact Number: </strong>+9325025878,+93979858787<br />
<strong>Address: </strong> Kabul,Mazar,Herat,Ghazni,Laghman
</span>';
$pdf->WriteHTML($htmlpersiantranslation, true, 0, true, 0);

// set LTR direction for english translation
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetX(60);


$pdf->Button('print', 30, 10, 'Print', 'Print()', array('lineWidth'=>2, 'borderStyle'=>'beveled', 'fillColor'=>array(128, 196, 255), 'strokeColor'=>array(64, 64, 64)));

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
	print();
}
EOD;

// Add Javascript code
$pdf->IncludeJS($js);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('asansafar_ticket.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+
