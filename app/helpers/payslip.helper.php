<?php

use Fpdf\Fpdf;

class PDF extends Fpdf {
	public function Header() {
		$this->Image(URLROOT.'/public/assets/img/logo.png' , 10, 6, 30);
	    $this->SetFont('Arial','B', 15);
	    $this->Cell(80);
	    $this->Cell(30, 10, 'QUEZON CITY UNIVERSITY', 1, 0, 'C');
	    $this->Ln(20);
	}

	public function personal($id, $name) {
		$this->Cell(10, 10, 'ID : '.$id, 1, 0, 'C');
		$this->Ln();
		$this->Cell(10, 10, 'Name : '.$name, 1, 0, 'C');
		$this->Ln();
	}

	public function items($header, $data) {

	    $w = array(70, 40);
	    
	    for($i=0;$i<count($header);$i++)
	        $this->Cell($w[$i],7,$header[$i],1,0,'C');
	    
	    $this->Ln();
	 
	    foreach($data as $row) {
	        $this->Cell($w[0],6,$row[0],'LR');
	        $this->Cell($w[2],6,number_format($row[1]),'LR',0,'R');
	        $this->Ln();
	    }
	 
	    $this->Cell(array_sum($w),0,'','T');
	}

	public function price($price) {
		$this->Cell(10, 10, 'Total Price : '.$price, 1, 0, 'C');
	}

}

function generatePayslip($details) {
	$pdf = new PDF();
	$pdf->AddPage();
	$pdf->personal($details['id'], $details['name']);
	$header = array('Document', 'Price');
	$pdf->items($header, $details['data']);
	$pdf->price($details['price']);
	$pdf->Output();
}

?>