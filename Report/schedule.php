<?php
session_start();
// Include the main TCPDF library (search for installation path).
include(__DIR__ . '/tcpdf_min/tcpdf.php');
include('dbconn.php');
// $dataareaid = $_SESSION["defaultdataareaid"];
// $usrname = $_GET["usr"];
// $soc = $dataareaid;
// $yr = $_GET["yr"];
// $wkType = $_GET["wkType"];
// $monthcal = $_GET["monthcal"];

$dataareaid = "NPI";


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
      // Logo
      include('dbconn.php');
      $dataareaid = $_SESSION["defaultdataareaid"];
      $soc = "NPI";
      $logo = '';
      //$dataareaid = '';
      //$yr = $_GET["yr"];

      $query = "SELECT *,cast(dataarealogo as char) as img FROM dataarea WHERE dataareaid = '$soc'";
        $result = $conn->query($query);

       while($row = $result->fetch_assoc()) {
          $logo = $row["img"];
           /* $img = '<img src="' . $logo . '" width="100" height="85">';
             $this->SetY(8);
        $this->writeHTML($img,true, false, true, false, '');*/

        $img_base64_encoded = $logo;

        $img = '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $img_base64_encoded) . '" width="100" height="85">';
        $this->SetY(19);
        $this->writeHTML($img, true, false, true, false, '');



        }

         $this->SetY(15);
      
        // Set font
        $this->SetFont('helvetica', 'B', 13);
        $this->SetTextColor(0,0,0);
        // Title
        $this->Cell(50, 15, $_GET["comp"], 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetFont('helvetica', 'B', 12);
        $this->SetTextColor(128,128,128);
        $this->SetY(35);

        $this->Cell(18, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(21, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(25, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(200, 5, 'Schedule of the week', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'B', 8);
        $this->SetY(40);
        $this->Cell(328, 15, 'For the Week of 2020-01-20 to 2020-01-26', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'B', 8);
        $this->SetY(45);
        $this->Cell(564, 15, 'Printed By: admin', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $currentDateTime = date('Y-m-d H:i:s');
   

        
        $this->SetY(48);
        $this->Cell(585, 15, 'Printed Date: '.$currentDateTime.'', 0, false, 'C', 0, '', 0, false, 'M', 'M');
   

        $this->SetY(55);
      //  $this->Cell(50, 15, $yr, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(50, 5, 'Name',0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(3, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(2, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(10, 1, 'Monday', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(30, 5, 'Tuesday', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(4, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(15, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(6, 5, 'Wednesday', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(15, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(5, 5, 'Thursday', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(6, 5, 'Friday', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(14, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(6, 5, 'Saturday', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(8, 5, 'Sunday', 0, false, 'C', 0, '', 0, false, 'M', 'M');



    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, 'LEGAL', true, 'UTF-8', false);

// set document information

$pdf->SetTitle('SSS CONTRIBUTION REPORT');


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

// set font

$pdf->SetFont('helvetica', '', 9);
$pdf->SetTextColor(128,128,128);
// add a page
$pdf->AddPage();

// set some text to print

$output = '';
$outputTotal = '';
$finaloutput= '';
$count = 0;



$startoutput = '<table cellspacing="0" width="100%" cellpadding="1" border="0"><tr></tr>';

$queryworker = "Select workerid from worker where dataareaid = 'NPI' and branch = 'PHV'";
        $resultworker = $conn->query($queryworker);
        while ($rowworker = $resultworker->fetch_assoc())
        {
            $workerid = $rowworker["workerid"];
            $query = "call generatesched('NPI', '2020-11-23', '2020-11-29', '$workerid');";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc())
            {

                $output .= '
                            <table width="100%" cellspacing="3" cellpadding="1" border="0">
                                <tr>
                                    <td  width="3%"  style="text-align:left"></td>
                                    <td  width="15%"  style="text-align:left">'.$row["name"].'</td>
                                    <td  width="12%"  style="text-align:left">'.$row["starttime1"].' - '.$row["endtime1"].'</td>
                                    <td  width="12%"  style="text-align:left">'.$row["starttime2"].' - '.$row["endtime2"].'</td>
                                    <td  width="12%"  style="text-align:left">'.$row["starttime3"].' - '.$row["endtime3"].'</td>
                                    <td  width="12%"  style="text-align:left">'.$row["starttime4"].' - '.$row["endtime4"].'</td>
                                    <td  width="12%"  style="text-align:left">'.$row["starttime5"].' - '.$row["endtime5"].'</td>
                                    <td  width="12%"  style="text-align:left">'.$row["starttime6"].' - '.$row["endtime6"].'</td>
                                    <td  width="12%"  style="text-align:left">'.$row["starttime7"].' - '.$row["endtime7"].'</td>
                                </tr>
                            </table>
                            ';
            }
            $count++;
            $conn->close();
            include("dbconn.php");
        }



    

  $finaloutput =  $startoutput.$output.$outputTotal;

  

// print a block of text using Write()
$pdf->SetY(65);
$pdf->WriteHtml($finaloutput, '', 0, 'C',  false, 0, false, false, 0);

#$pdf->SetY(-20);
        // Set font
#$pdf->WriteHtml('AAAAAAAAA', '', 0, 'C',  false, 0, false, false, 0);

//$pdf->WriteHtml( $startoutput.$outputTotal, '', 0, 'C',  false, 0, false, false, 0);
// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('Schedule.pdf', 'I');

?>