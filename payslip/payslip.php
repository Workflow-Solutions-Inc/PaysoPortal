<?php 
/*require('fpdf/fpdf.php');

$pdf = new FPDF();
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();




$pdf->SetFont('Arial','B',15);
$pdf->Cell(10,10,'',0);
$pdf->Cell(10,10,'',0);
$pdf->Cell(40,10,'',0);
$pdf->Cell(10,10,'Company Name',0);
$pdf->Cell(60,10,'',0,0);
$pdf->Cell(60,10,'',0,0);



$pdf->Cell(60,10,'',0,1);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,10,'',0);
$pdf->Cell(10,10,'',0);
$pdf->Cell(45,10,'',0);
$pdf->Cell(10,10,'Payslip Details',0);
$pdf->Cell(60,10,'',0,0);
$pdf->Cell(60,10,'',0,0);

$pdf->Cell(60,10,'',0,1);


$pdf->SetFont('Arial','B',9);
$pdf->Cell(15,10,'',0);
$pdf->Cell(8,10,'Name:',0);
$pdf->Cell(8,10,'',0);
$pdf->Cell(10,10,'John David Bachao',0);
$pdf->Cell(60,10,'',0,0);
$pdf->Cell(20,10,'Worker No:',0,0);
$pdf->Cell(10,10,'NEW000028',0,0);
$pdf->Cell(10,10,'',0,0);
$pdf->Cell(10,10,'',0,0);


$pdf->Output('','payslip.pdf', false);*/

$payrollid = $_GET['payroll'];
$dataareaid = $_GET['comp'];
$workernum = $_GET['worker'];
require('fpdf/htmlpdf.php');
include('../dbconn.php');

$pdf=new PDF('P','mm','letter');


$query = "CALL payslipRPT('".$payrollid."', '".$dataareaid."', '".$workernum."')";
//$query = "CALL payslipRPT('WFSIPY0000005', 'WFSI', 'WFSIWR000002')";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();

        $name = $row["name"];
        $workerid = $row["workerid"];
        $rate = $row["rate"];
        $contractid = $row["contractid"];
        $department = $row['department'];
        $position = $row['position'];
	        $fromdate = $row['fromdate'];
        $todate = $row['todate'];

        $rdays = $row["RDAYS"];
        $late = $row["LTE"];
        $lateH = $row["LTEA"];
        $overtime = $row["OT"];
        $overtimeH = $row["OTA"];
        $nightdeferential = $row["ND"];
        $nightdeferentialH = $row["NDA"];
        $bpay = $row["BPAY"];
        $abs =$row['ABS'];
        $absa =$row['ABSA'];

        $rdaysAmount = 0;
        $rdayNum = (float)$rdays;
        $rateNum = (float)$rate;

        $tallow = $row['TALLOW'];
        $mallow = $row['MALLOW'];
        
					$pdf->AddPage();
					$pdf->SetFont('Arial','B',15);
					$pdf->Cell(10,10,'',0);
					$pdf->Cell(10,10,'',0);
					$pdf->Cell(55,10,'',0);
					$pdf->Cell(10,10,$row["dataareaname"],0);
					$pdf->Cell(60,10,'',0,0);
					$pdf->Cell(60,10,'',0,0);

					$pdf->Cell(60,8,'',0,1);


					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(10,10,'',0);
					$pdf->Cell(10,10,'',0);
					$pdf->Cell(60,10,'',0);
					$pdf->Cell(10,10,'Payslip Details',0);
					$pdf->Cell(60,10,'',0,0);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(8,7,'',0,1);

					$pdf->Cell(60,10,'',0);
					$pdf->Cell(10,10,'',0);
					$pdf->Cell(60,10,'Payroll Covered: '.$fromdate.' - '.$todate,0);

					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(10,10,'',0,0);
					$pdf->Cell(10,10,'',0,0);
					$pdf->Cell(10,10,'',0,1);

        $rdaysAmount = number_format($rdayNum * $rateNum,2);

        $sholiday = $row["SHOL"];
        $sholidayH = $row["SHOLA"];
        $sholidayot = $row["SHOLOT"];
        $sholidayotH = $row["SHOLOTA"];
        $lholiday = $row["LHOLA"];
        $lholidayH = $row["LHOL"];
        $lholidayot = $row["LHOLOT"];
        $lholidayotH = $row["LHOLOTA"];


        $sss = number_format($row["SSS"],2);
        $philhealth = number_format($row["PH"],2);;
        $pagibig = $row["PIBIG"];
        $pagibigl = $row["PIBIGL"];
        $ssloan  = $row["SSSL"];
        $overp 	 = number_format($row["OPAY"],2);

        $ecola = $row["ecola"];
        $prm = $row["PRM"];
        $aback = $row["ABACK"];

        $ufm = $row["UFM"];
        $shuttle = $row["SHTTL"];
        $ochrg = $row["OCHRG"];

        $tax = $row["WTAX"];

        $cbond = $row["CBOND"];
        $cadvance = $row["CADV"];
        $cchrg = $row["CCHRG"];

        $apt = $row["APT"];
       
        $ctn = $row["CTN"];

        $tded = $row["TDED"];
        $npay = $row["NPAY"];
        $gpay = $row['GPAY'];
        $inc = $row['INC'];

$html='
	<table>
		<tr>
			<td width="721" height="30" bgcolor="#73d0e6"><font face="Verdana" color="#ffffff"><b>                                                                             WORKER DETAILS</b></font></td>
		</tr>
	</table>

	<table border="1">
	<tr>
		<td width="120" height="30">Name:</td>
		<td width="200" height="30">'.$name.'</td>
		<td width="150" height="30">Position:</td>
		<td width="250" height="30">'.$position.'</td>
	</tr>
	<tr>
		<td width="120" height="30">Rate:</td>
		<td width="200" height="30">'.$rate.'</td>
		<td width="150" height="30">Department:</td>
		<td width="250" height="30">'.$department.'</td>
	</tr>

	<tr>
	</tr>
	<tr>
		<table border="0">
			<tr>
				<td width="420" height="30" bgcolor="#73d0e6"><font face="Verdana" color="#ffffff"><b>EARNINGS</b></font></td>
				<td width="200" height="30" bgcolor="#73d0e6"><font color="#ffffff"><b>VALUES</b></font></td>
				<td width="100" height="30" bgcolor="#73d0e6"><font color="#ffffff"><b>AMOUNT</b></font></td>
			</tr>
			<tr>
				<td width="420" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">No of. Days:</font></td>
				<td width="200" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$rdays.'</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$bpay.'</font></td>
			</tr>
			<tr>
				<td width="420" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">Late (Hours):</font></td>
				<td width="200" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$late.'</font></td>
				<td width="100" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$lateH.'</font></td>
			</tr>

			<tr>
				<td width="420" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">Absent (Days):</font></td>
				<td width="200" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$abs.'</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$absa.'</font></td>
			</tr>

			<tr>
				<td width="620" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324" >Basic Pay:</font></td>
				<td width="100" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$bpay.'</font></td>
			</tr>

		</table>
		<tr>
		</tr>

		<table border="0">
			<tr>
				<td width="720" height="30" bgcolor="#73d0e6"><font face="Verdana" color="#ffffff"><b>HOLIDAY/S</b></font></td>
			</tr>
			<tr>
				<td width="420" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">Special Holiday:</font></td>
				<td width="200" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$sholidayH.'</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$sholiday.'</font></td>
			</tr>
			<tr>
				<td width="420" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">Special Holiday OT:</font></td>
				<td width="200" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$sholidayotH.'</font></td>
				<td width="100" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$sholidayot.'</font></td>
			</tr>
			<tr>
				<td width="420" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">Legal Holiday:</font></td>
				<td width="200" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$lholidayH.'</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$lholiday.'</font></td>
			</tr>
			<tr>
				<td width="420" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">Legal Holiday OT:</font></td>
				<td width="200" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$lholidayotH.'</font></td>
				<td width="100" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$lholidayot.'</font></td>
			</tr>

		</table>
		<tr>
		</tr>
		<table border="0">
			<tr>
				<td width="720" height="30" bgcolor="#73d0e6"><font face="Verdana" color="#ffffff"><b>OTHER INCOME</b></font></td>
			</tr>
			<tr>
				<td width="420" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">Overtime:</font></td>
				<td width="200" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$overtime.'</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$overtimeH.'</font></td>
			</tr>

			<tr>
				<td width="420" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">Night Differential:</font></td>
				<td width="200" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$nightdeferentialH.'</font></td>
				<td width="100" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$nightdeferential.'</font></td>
			</tr>

			<tr>
				<td width="620" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">Transporation Allowance:</font></td>
				<td width="200" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$tallow.'</font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">Meal Allowance:</font></td>
				<td width="100" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$mallow.'</font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">Incentives:</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$inc.'</font></td>
			</tr>

		</table>
		<tr>
		</tr>
		<table border="0">
			<tr>
				<td width="720" height="30" bgcolor="#73d0e6"><font face="Verdana" color="#ffffff"><b>CONTRIBUTIONS</b></font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324" >SSS:</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$sss.'</font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">PHIC:</font></td>
				<td width="100" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$philhealth.'</font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">HMDF:</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$pagibig.'</font></td>
			</tr>
			
		</table>
		<tr>
		</tr>
		<table border="0">
			<tr>
				<td width="720" height="30" bgcolor="#73d0e6"><font face="Verdana" color="#ffffff"><b>LOAN/S</b></font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324" >SSS Loan:</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$ssloan.'</font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">HMDF Loan:</font></td>
				<td width="100" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$pagibigl.'</font></td>
			</tr>
		</table>

		<tr>
		</tr>

		<table border="0">
			<tr>
				<td width="720" height="30" bgcolor="#73d0e6"><font face="Verdana" color="#ffffff"><b>OTHER DEDUCTIONS</b></font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">Over Payment:</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$overp.'</font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324" >Comapany Charges:</font></td>
				<td width="100" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$cchrg.'</font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324" >Other Charges:</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$ochrg.'</font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">Tax:</font></td>
				<td width="100" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324">'.$tax.'</font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">Cash Advance:</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$cadvance.'</font></td>
			</tr>
		</table>


		<tr>
		</tr>
		<table border="0">
			<tr>
				<td width="720" height="30" bgcolor="#73d0e6"><font face="Verdana" color="#ffffff"><b>TOTALS</b></font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324" >Gross Pay:</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="red">'.$gpay.'</font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#d5dadb"><font face="courier new" color="#212324" >Deductions:</font></td>
				<td width="100" height="30" bgcolor="#d5dadb"><font face="courier new" color="red">'.$tded.'</font></td>
			</tr>
			<tr>
				<td width="620" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">Net Pay:</font></td>
				<td width="100" height="30" bgcolor="#ffffff"><font face="courier new" color="red">'.$npay.'</font></td>
			</tr>
		</table>
	</tr>

</table>';

$pdf->WriteHTML($html);
$pdf->Output('I',''.$workernum.'.pdf');

?>