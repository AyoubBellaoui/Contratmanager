<?php

    require('../TCPDF-main/tcpdf.php');
    require ('../Connection/Config.php');
    

    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Admin');
    $pdf->SetTitle('tous Contractants');
    $pdf->SetSubject('tous Contractants');
    $pdf->SetKeywords('tous Contractants');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

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
 

    /* display table on pdf */
    $pdf -> AddPage('L','A1');

    $pdf->SetFont('aealarabiya', '', 12);

        // set some text to print
        $html ='
        <h1> لائحة المتعاقدين  </h1>
        <br>
        ';

        $pdf->writeHTML($html, true, false, true, false,'C');
      
        $query = 'SELECT * FROM contractant';

        $result = mysqli_query($db, $query);

         # Table head
         $pdf->Cell(80, 10, 'الاسم', 1, 0, 'C');
         $pdf->Cell(80, 10, 'رقم البطاقة الوطنية', 1, 0, 'C');
         $pdf->Cell(80, 10, 'الصنف المتعاقد', 1, 0, 'C');
         $pdf->Cell(80, 10, 'الجنس', 1, 0, 'C');
         $pdf->Cell(80, 10, 'المهنة', 1, 0, 'C');
         $pdf->Cell(80, 10, 'تاريخ الازدياد', 1, 0, 'C');
         $pdf->Cell(80, 10, 'ديبلوم', 1, 0, 'C');
         $pdf->Cell(110, 10, 'عنوان السكني', 1, 0, 'C');
         $pdf->Cell(70, 10, 'البريد الالكتروني', 1, 0, 'C');
         $pdf->Cell(80, 10, 'الهاتف', 1, 1, 'C');

        while($row = mysqli_fetch_array($result)) {

        # Table body
        $pdf->Cell(80, 10, $row['NOM_CTR'], 1, 0, 'C');
        $pdf->Cell(80, 10, $row['CIN_CTR'], 1, 0, 'C');
        $pdf->Cell(80, 10, $row['TYPE_CTR'], 1, 0, 'C');
        $pdf->Cell(80, 10, $row['SEXE_CTR'], 1, 0, 'C');
        $pdf->Cell(80, 10, $row['PROF_CTR'], 1, 0, 'C');
        $pdf->Cell(80, 10, $row['DT_CTR'], 1, 0, 'C');
        $pdf->Cell(80, 10, $row['DPL_CTR'], 1, 0, 'C');
        $pdf->Cell(110, 10, $row['ADRES_CTR'], 1, 0, 'C');
        $pdf->Cell(70, 10, $row['EMAIL_CTR'], 1, 0, 'C');
        $pdf->Cell(80, 10, $row['TEL_CTR'], 1, 1, 'C');
        
    }

    //Close and output PDF document
    $pdf->Output('Contractants.pdf', 'I');
    
    ?>