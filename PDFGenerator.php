<?php
class PDFGenerator extends TCPDF 
{
    public function Header() 
    {
        $image_file = 'Images/team2.jpg';
        $this->Image($image_file, 10, 3, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetFont('helvetica', 'B', 20);
        $this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->Cell(0, 15, 'Team 2 Medical Centre', 0, false, 'R', 0, '', 0, false, 'M', 'M');
    }
 
    public function Footer() 
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 15);
        $this->Cell(0, 10, 'Thank you selecting Team 2 as your health care provider!', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
 
    public function printTable($header, $data)
    {
        $this->SetFillColor(0, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B', 9);
 
        $w = array(8,20, 16, 75, 36, 34);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
 
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
 
        // table data
        $fill = 0;
        $total = 0;
 
        foreach($data as $row) {

            // Data
            $this->Cell($w[0], 6, number_format($row[0]), 'LR', 0, 'R', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'R', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'R', $fill);
            $this->Cell($w[4], 6, $row[4], 'LR', 0, 'R', $fill);
            $this->Cell($w[5], 6, $row[5], 'LR', 0, 'R', $fill);
            // Print Boderline
            $this->Ln();
            $fill=!$fill;
        
        }
 
        // $this->Cell($w[0], 6, '', 'LR', 0, 'L', $fill);
        // $this->Cell($w[1], 6, '', 'LR', 0, 'R', $fill);
        // $this->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        // $this->Cell($w[3], 6, '', 'LR', 0, 'R', $fill);
        // $this->Ln();
 
        // $this->Cell($w[0], 6, '', 'LR', 0, 'L', $fill);
        // $this->Cell($w[1], 6, '', 'LR', 0, 'R', $fill);
        // $this->Cell($w[2], 6, 'TOTAL:', 'LR', 0, 'L', $fill);
        // $this->Cell($w[3], 6, $total, 'LR', 0, 'R', $fill);

        // $this->Cell($w[0], 6, $row[0], 'LR', 0, 'R', $fill);
        // $this->Cell($w[1], 6, $row[1], 'LR', 0, 'R', $fill);
        // $this->Cell($w[2], 6, $row[2], 'LR', 0, 'R', $fill);
        // $this->Cell($w[3], 6, $row[3], 'LR', 0, 'R', $fill);
        // $this->Cell($w[4], 6, $row[4], 'LR', 0, 'R', $fill);

        // $this->Ln();
 
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}