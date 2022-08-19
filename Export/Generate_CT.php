<?php
    ob_start ();
    require('../TCPDF-main/tcpdf.php');
    require ('../Connection/Config.php');
 
    //--------------------------------------------------------------------- PDF GLOBAL REULES -----------------------------------------------------------------------//

   // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Admin');
    $pdf->SetTitle('Contrats');
    $pdf->SetSubject('Contrats');
    $pdf->SetKeywords('Contrat Conférence');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language dependent data:
    $lg = Array();
    $lg['a_meta_charset'] = 'UTF-8';
    $lg['a_meta_dir'] = 'rtl';
    $lg['a_meta_language'] = 'fa';
    $lg['w_page'] = 'page';

    // set some language-dependent strings (optional)
    $pdf->setLanguageArray($lg);
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------//

   // Check existence of id parameter before processing further
   if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Get URL parameter
    $id =  trim($_GET["id"]);

    // Set font that support arabic
    $pdf->SetFont('dejavusans', '', 11);

    // Contrat Conférence PDF
    $pdf->AddPage('P', 'A4');

    $query="SELECT * FROM contrat INNER JOIN contractant ON contractant.ID_CTR = contrat.ID_CTR WHERE ID_CT = ".(int)$_GET['id'];

    if($result = mysqli_query($db, $query)){
        if(mysqli_num_rows($result) > 0){

      while($row = mysqli_fetch_array($result)){

        
    /*  Contrat Conférence */
    $html1 = '
    <div style="text-align:left;">
    <p>الرباط، في:' . "$row[DT_AF]" .'</p>
    <p>تحت رقم: ' . "$row[NUM_CT]" .'</p>
    </div>
    <p dir="RTL" style="text-align:center;"><h2>عـقد تـعــاون</h2></p>
    <p dir="RTL"><strong>بين</strong><strong>:</strong></p>
    <p dir="RTL">المعهد الملكي للثقافة الأمازيغية الكائن مقره الاجتماعي بشارع علال الفاسي، مدينة العرفان، رقم صندوق البريد 2055 حي الرياض الرباط، والممثل في شخص عميده،<strong>&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;من جهة؛</strong></p>
    <p dir="RTL"><strong>و:</strong></p>
    <p dir="RTL">الإسم الشخصي والعائلي:  ' . "$row[NOM_CTR]" . ' </p>
    <p dir="RTL">الحاملة للبطاقة الوطنية للتعريف رقم: ' . "$row[CIN_CTR]" . ' </p>
    <p dir="RTL">عنوان السكنى : ' . "$row[ADRES_CTR]" . '</p>
    <p dir="RTL">والمشار إليها بعده بالمتعاقد، &nbsp;<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;من جهة أخرى</strong><strong>.</strong></p>
    <p dir="RTL"><strong>واتفق الطرفان على ما يلي</strong><strong><em>:</em></strong></p>
    <p dir="RTL"><strong>المادة الأولى: موضوع العقد</strong></p>
    <p dir="RTL">يلتزم المتعاقد بتنشيط ' . "$row[OBJ_CT]" . ' التي سينظمها المعهد الملكي للثقافة الأمازيغية، بمناسبة ..' . "$row[AR1_CT]" . '</p>
    <p dir="RTL">يوم ' . "$row[DT_CT]" . '</p>
    <p dir="RTL"><strong>المادة الثانية: التزام المتعاقد</strong></p>
    <p dir="RTL">يتعهد المتعاقد بالوفاء بالالتزامات الواردة في الإجراءات المذكورة في المادة 1 من هذا العقد، كما يلتزم طيلة مدة العقد وما بعدها بالتحفظ التام فيما يتعلق بالوقائع والمعلومات والوثائق التي اطلع عليها أثناء القيام بمهامه. وفي هذا الصدد، فإنه يقر بخضوعه إلى القوانين الجاري بها العمل في مجال السرية المهنية.</p>
    <p dir="RTL"><strong>المادة الثالثة: التزامات المعهد</strong></p>
    <p dir="RTL">يلتزم المعهد بتقديم تعويض خام للمتعاقد قدره ألفان وثمانمائة وسبعة وخمسون درهما وأربعة عشر سنتيما (2.857,14 درهما )، يجبر المبلغ الخام إلى الدرهم الأعلى ليكون ألفان وثمانمائة وثمان وخمسون درهما (2.858,00 درهما)، بعد خصم 30 % من الضريبة على الدخل، ليكون المبلغ الصافي هو ألفي درهم (2.000,00 درهم).</p>
    <p dir="RTL"><strong>المـادة الرابعة:</strong> <strong>بدء سريان العقد</strong><strong> </strong></p>
    <p dir="RTL">يتم العمل بهذا العقد ابتداءا من تاريخ توقيع الطرفين عليه.</p>
    <p dir="RTL"><strong>المـادة الخامسة: واجبات التسجيل</strong></p>
    <p dir="RTL">يتحمل المتعاقد واجبـات التسجيل والرسوم الضريبية الجاري بها العمل بالنسبة للعقـود. </p>
    <p dir="RTL"><strong>المـادة السادسة: تسوية النزاع</strong></p>
    <p dir="RTL">في حالة نزاع حول تنفيذ مقتضيات هذا العقد، يعمل الطرفان على تسويته وديا، وفي حالة تعذر ذلك، يعرض الأمر عند الاقتضاء على محاكم الرباط المختصة.</p>
    <p> &nbsp;</p>
    <p><strong>المعهد الملكي للثقافة الأمازيغية</strong><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    المتعاقد</strong></p>
    <p><strong>السيد العميد</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . "$row[NOM_CTR]" . '</strong></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(مع عبارة قرئ وصودق عليه)</p>
    </div>
    ';
    /*  Contrat Conférence */

    /* Contrat de collecte */
    $html2='
    <div>
    <p dir="RTL">قسم الموارد البشرية والشؤون العامة والقانونية / مصلحة الشؤون العامة والقانونية. </p>
    <div style="text-align:left;">
    <p>الرباط، في:' . "$row[DT_AF]" . '</p>
    <p>تحت رقم: ' . "$row[NUM_CT]" . '</p>
    </div>
    <p dir="RTL" style="text-align:center;"><h2>عـقد تـعــاون</h2><strong>(جمع وتدوين متن أدبي)</strong></p>
    <p dir="RTL"><strong>بين</strong><strong>:</strong></p>
    <p dir="RTL">المعهد الملكي للثقافة الأمازيغية، الكائن مقره بشارع علال الفاسي، مدينة العرفان، رقم صندوق البريد 2055 حي الرياض الرباط، والممثل في شخص عميده، &nbsp;السيد أحمد بوكوس، </p>
    <p dir="RTL"><strong>&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;من جهة؛</strong></p>
    <p dir="RTL"><strong>و: </strong></p>
    <p dir="RTL">الإسم الشخصي والعائلي : ' . "$row[NOM_CTR]" . '</p>
    <p dir="RTL">الحامل للبطاقة الوطنية للتعريف، رقم ' . "$row[CIN_CTR]" . '</p>
    <p dir="RTL">عنوان السكنى : ' . "$row[ADRES_CTR]" . '</p>
    <p dir="RTL">والمشار إليه، بعده، بالمتعاقد، </p>
    <p dir="RTL"> &nbsp; <strong>من</strong><strong>&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; جهة أخرى.</strong> </p>
    <p dir="RTL"><strong>اتفق الطرفان على ما يلي</strong><strong></strong></p>
    <p dir="RTL"><strong>المادة الأولى: موضوع العقد</strong></p>
    <p dir="RTL">موضوع هذا العقد هو جمع وتدوين متن أدبي، وفقا للبنود الواردة في هذا العقد، والشروط والمعايير المحددة في دفتر التحملات.</p>
    <p dir="RTL"><br /><strong>المادة الثانية: إلتزامات المتعاقد</strong></p>
    <p dir="RTL">يتعهد المتعاقد بالوفاء بالالتزامات المذكورة في المادة الأولى من هذا العقد، </p>
    <p dir="RTL">يلتزم طيلة مدة العقد وما بعدها بالتحفظ التام فيما يتعلق بالوقائع والمعلومات والوثائق التي اطلع عليها أثناء القيام بمهامه. وفي هذا الصدد، فإنه يقر بخضوعه للقوانين الجاري بها العمل في مجال السرية المهنية؛</p>
    <p dir="RTL">يصرح أن المتن ، موضوع العقد، هو مؤلفه وواضعه الوحيد، شكلا ومضمونا؛</p>
    <p dir="RTL">يضمن أن تكون المخطوطة المذكورة لم يسبق لها أن نشرت من قبل، لا جزئيا ولا كليا من قبل أي ناشر، وللمعهد أن يعتبرها مؤلفاً جديداً خاضعاً لحقوق النشر العائدة له؛</p>
    <p dir="RTL">يصرح أن العمل الذي سيقدمه خال من أي نوع من أنواع القذف، أو التشهير، ومن أي مادة غير مشروعة، أو التي قد تثير اعتراض ذي حق أو أي احد عليها؛</p>
    <p dir="RTL">يتحمل المسؤولية الجنائية في أي دعوى أو مطالبة أو حقوق قد تنتج عن أي ملاحقة، ويتعهد أن يقوم هو دون المعهد، وعلى نفقته الخاصة، بالدفاع عن أية قضية تتعلق بهذه الأمور؛</p>
    <p dir="RTL">يتحمل المتعاقد مسؤولية ونفقات وتعويضات أي متعاون أو مساهم محتمل .</p>
    <p dir="RTL"><strong>المادة الثالثة: التزامات المعهد</strong></p>
    <p dir="RTL">يلتزم المعهد بمنح تعويض خام للمتعاقد قدره ' . "$row[MNT_BRUT_LTR]" . ' درهما ' . "$row[MNT_BRUT]" . ' يجبر المبلغ الخام إلى الدرهم الأعلى ليصبح ' . "$row[MNT_ARN_LTR]" . ' درهما (2 ' . "$row[MNT_ARN]" . ' درهم)، ليكون المبلغ الصافي هو ' . "$row[MNT_NET_LTR]" . ' درهم ' . "$row[MNT_NET]" . '  درهم)، بعد خصم 30 % من الضريبة على الدخل.</p>
    <p dir="RTL"><strong>المادة الرابعة:</strong><strong>بدء سريان العقد</strong><strong> </strong></p>
    <p dir="RTL">يتم العمل بهـذا العقد ابتداء من تاريخ توقيع الطرفين عليه.</p>
    <p dir="RTL"><strong>المادة الخامسة: فسخ العقد</strong></p>
    <p dir="RTL">يجوز فسخ هذا العقد دون إشعار، ودون تعويض من قبل المعهد، إذا لم يلتزم المتعاقد بالبنود الواردة في هذا العقد.</p>
    <p dir="RTL"><strong>المادة الخامسة: واجبات التسجيل</strong></p>
    <p dir="RTL">يتحمل المتعاقد واجبـات التسجيل والرسوم الضريبية الجاري بها العمل بالنسبة للعقود. </p>
    <p dir="RTL"><strong>المادة السادسة: تسوية النزاع</strong></p>
    <p dir="RTL">في حالة نزاع حول تنفيذ مقتضيات هذا العقد، يعمل الطرفان على تسويته وديا، وفي حالة تعذر ذلك، يعرض الأمر عند الاقتضاء على محاكم الرباط المختصة.</p>
    <p> &nbsp;</p>
    <p><strong>المعهد الملكي للثقافة الأمازيغية</strong><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    المتعاقد</strong></p>
    <p><strong>السيد العميد</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . "$row[NOM_CTR]" . '</strong></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(مع عبارة قرئ وصودق عليه)</p>
    </div>
    ';
    /* Contrat de collecte */

    /* الاحتفاء بأجدير */
    $html3 = '
    <div>
    <p dir="RTL">قسم الموارد البشرية والشؤون العامة والقانونية / مصلحة الشؤون العامة والقانونية. </p>
    <div style="text-align:left;">
    <p>الرباط، في:' . "$row[DT_AF]" . '</p>
    <p>تحت رقم: ' . "$row[NUM_CT]" . '</p>
    </div>
    <p dir="RTL" style="text-align:center;"><h2>عـقد تـعــاون</h2><strong>(احتفال أجدير)</strong></p>
    <p dir="RTL"><strong>بين</strong><strong>:</strong></p>
    <p dir="RTL">المعهد الملكي للثقافة الأمازيغية، الكائن مقره بشارع علال الفاسي، مدينة العرفان، رقم صندوق البريد 2055 حي الرياض الرباط، والممثل في شخص عميده، &nbsp;السيد أحمد بوكوس، </p>
    <p dir="RTL"><strong>من جهة؛</strong></p>
    <p dir="RTL"><strong>و: </strong></p>
    <p dir="RTL">الإسم الشخصي والعائلي : ' . "$row[NOM_CTR]" . '</p>
    <p dir="RTL">الحامل للبطاقة الوطنية للتعريف، رقم ' . "$row[CIN_CTR]" . '</p>
    <p dir="RTL">عنوان السكنى : ' . "$row[ADRES_CTR]" . '</p>
    <p dir="RTL">والمشار إليه، بعده، بالمتعاقد، &nbsp; <strong>من</strong> <strong>جهة أخرى</strong><strong>.</strong><strong> </strong></p>
    <p dir="RTL"><strong>اتفق الطرفان على ما يلي</strong><strong></strong></p>
    <p dir="RTL"><strong>المادة الأولى: موضوع العقد</strong></p>
    <p dir="RTL">يلتزم المتعاقد بالمشاركة مع مجموعته الموسيقية، يوم ' . "$row[OBJ_CT]" . ' في السهرة الفنية التي سينظمها المعهد الملكي للثقافة الأمازيغية بالمسرح الوطني محمد الخامس، بمناسبة الاحتفال بالذكرى الثامنة عشر للخطاب الملكي السامي بأجدير، وتأسيس المعهد الملكي للثقافة الأمازيغية.</p>
    <p dir="RTL"><strong>المادة الثانية: التزامات المتعاقد</strong></p>
    <p dir="RTL">يتعهد المتعاقد بالوفاء بالالتزامات المذكورة في المادة الأولى من هذا العقد، </p>
    <p dir="RTL">يلتزم طيلة مدة العقد وما بعدها بالتحفظ التام فيما يتعلق بالوقائع والمعلومات والوثائق التي اطلع عليها أثناء القيام بمهامه. وفي هذا الصدد، فإنه يقر بخضوعه للقوانين الجاري بها العمل في مجال السرية المهنية؛</p>
    <p dir="RTL">يصرح أن العمل الذي سيقدمه خال من أي نوع من أنواع القذف، أو التشهير، ومن أي مادة غير مشروعة، أو التي قد تثير اعتراض ذي حق أو أي أحد عليها؛</p>
    <p dir="RTL">يعمل على توفير جميع الوسائل الضرورية، ليمر الاحتفال في ظروف عادية، وكذا التعاون مع الفرق المكلفة بالإخراج والإنتاج الفني والتقني والتلفزي؛</p>
    <p dir="RTL">يتنازل للمعهد عن حق البث التلفزي من طرف الشركة الوطنية للإذاعة والتلفزة المغربية؛</p>
    <p dir="RTL">يتحمل المسؤولية الجنائية في أي دعوى أو مطالبة أو حقوق قد تنتج عن أي ملاحقة، ويتعهد أن يقوم هو دون المعهد، وعلى نفقته الخاصة، بالدفاع عن أية قضية تتعلق بهذه الأمور؛</p>
    <p dir="RTL">يتحمل المتعاقد مسؤولية ونفقات وتعويضات أي متعاون أو مساهم محتمل في هذا الاحتفال؛</p>
    <p dir="RTL">يتعهد بعدم تقديم أي شكل من أشكال الدعاية المباشرة في جميع أطوار الأمسية؛</p>
    <p dir="RTL"><strong>المادة الثالثة: التزامات المعهد</strong></p>
    <p dir="RTL">&nbsp;يلتزم المعهد بمنح تعويض خام للمتعاقد قدره ' . "$row[MNT_BRUT_LTR]" . ' درهما، وسبعة وخمسون سنتيما ' . "$row[MNT_BRUT]" . ' درهم)، يجبر المبلغ الخام إلى الدرهم الأعلى ليكون  ' . "$row[MNT_ARN_LTR]" . ' درهما (&nbsp; ' . "$row[MNT_ARN]" . ' درهم)، ليكون المبلغ الصافي هو' . "$row[MNT_NET_LTR]" . 'لف درهم  ' . "$row[MNT_NET]" . 'د 0 درهم)، بعد خصم 30 % من الضريبة على الدخل.</p>
    <p dir="RTL"><strong>المادة الرابعة:</strong> <strong>بدء سريان العقد</strong><strong> </strong></p>
    <p dir="RTL">يتم العمل بهـذا العقد ابتداء من تاريخ توقيع الطرفين عليه.</p>
    <p dir="RTL"><strong>المادة الخامسة: واجبات التسجيل</strong></p>
    <p dir="RTL">يتحمل المتعاقد واجبـات التسجيل والرسوم الضريبية الجاري بها العمل بالنسبة للعقود. </p>
    <p dir="RTL"><strong>المادة السادسة: تسوية النزاع</strong></p>
    <p dir="RTL">في حالة نزاع حول تنفيذ مقتضيات هذا العقد، يعمل الطرفان على تسويته وديا، وفي حالة تعذر ذلك، يعرض الأمر عند الاقتضاء على محاكم الرباط المختصة.</p>
    <p> &nbsp;</p>
    <p><strong>المعهد الملكي للثقافة الأمازيغية</strong><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    المتعاقد</strong></p>
    <p><strong>السيد العميد</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . "$row[NOM_CTR]" . '</strong></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(مع عبارة قرئ وصودق عليه)</p>
    </div>
    ';
    /* الاحتفاء بأجدير */

    /* التنشيط */
    $html4 = '
    <div>
    <p dir="RTL"> </p>
    <div style="text-align:left;">
    <p>الرباط، في:' . "$row[DT_AF]" . '</p>
    <p>تحت رقم: ' . "$row[NUM_CT]" . '</p>
    </div>
    <p dir="RTL" style="text-align:center;"><h2>عـقد تـعــاون</h2></p>
    <p dir="RTL"><strong>بين</strong><strong>:</strong></p>
    <p dir="RTL">المعهد الملكي للثقافة الأمازيغية الكائن مقره الاجتماعي بشارع علال الفاسي، مدينة العرفان، رقم صندوق البريد 2055 حي الرياض الرباط، والممثل في شخص عميده، <strong>من جهة؛</strong></p>
    <p dir="RTL"><strong>و:</strong></p>
    <p dir="RTL">الإسم الشخصي والعائلي: ' . "$row[NOM_CTR]" . '</p>
    <p dir="RTL">الحامل للبطاقة الوطنية للتعريف رقم ' . "$row[CIN_CTR]" . '</p>
    <p dir="RTL">عنوان السكنى : ' . "$row[ADRES_CTR]" . '</p>
    <p dir="RTL">والمشار إليه بعده بالمتعاقد، &nbsp;<strong>من جهة أخرى</strong><strong>.</strong></p>
    <p dir="RTL"><strong>واتفق الطرفان على ما يلي</strong><strong></strong></p>
    <p dir="RTL"><strong>المادة الأولى: موضوع العقد</strong></p>
    <p dir="RTL">يلتزم المتعاقد بتنشيط أمسية شعرية، تخليدا لليوم العالمي للشعر، والتي ينظمها المعهد الملكي للثقافة الأمازيغية، وذلك ' . "$row[OBJ_CT]" . ' </p>
    <p dir="RTL"><strong>المادة الثانية: التزام المتعاقد</strong></p>
    <p dir="RTL">يتعهد المتعاقد بالوفاء بالالتزامات الواردة في الإجراءات المذكورة في المادة 1 من هذا العقد، كما يلتزم طيلة مدة العقد وما بعدها بالتحفظ التام فيما يتعلق بالوقائع والمعلومات والوثائق التي اطلع عليها أثناء القيام بمهامه. وفي هذا الصدد، فإنه يقر بخضوعه إلى القوانين الجاري بها العمل في مجال السرية المهنية.</p>
    <p dir="RTL"><strong>المادة الثالثة: التزامات المعهد</strong></p>
    <p dir="RTL">يلتزم المعهد بتقديم تعويض خام للمتعاقد قدره ' . "$row[MNT_BRUT_LTR]" . ' درهما و &nbsp;' . "$row[MNT_BRUT]" . ' درهما )، يجبر المبلغ الخام إلى الدرهم الأعلى ليكون ' . "$row[MNT_ARN_LTR]" . '  درهما ' . "$row[MNT_ARN]" . '  00 درهما)، بعد خصم 30 % من الضريبة على الدخل، ليكون المبلغ الصافي هو ' . "$row[MNT_NET_LTR]" . '  درهم (.000,00 درهم).</p>
    <p dir="RTL"><strong>المـادة الرابعة:</strong> <strong>بدء سريان العقد</strong><strong> </strong></p>
    <p dir="RTL">يتم العمل بهذا العقد ابتداءا من تاريخ توقيع الطرفين عليه.</p>
    <p dir="RTL"><strong>المـادة الخامسة: واجبات التسجيل</strong></p>
    <p dir="RTL">يتحمل المتعاقد واجبـات التسجيل والرسوم الضريبية الجاري بها العمل بالنسبة للعقـود. </p>
    <p dir="RTL"><strong>المـادة السادسة: تسوية النزاع</strong></p>
    <p dir="RTL">في حالة نزاع حول تنفيذ مقتضيات هذا العقد، يعمل الطرفان على تسويته وديا، وفي حالة تعذر ذلك، يعرض الأمر عند الاقتضاء على محاكم الرباط المختصة.</p>
    <p><strong>المعهد الملكي للثقافة الأمازيغية</strong><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    المتعاقد</strong></p>
    <p><strong>السيد العميد</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . "$row[NOM_CTR]" . '</strong></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(مع عبارة قرئ وصودق عليه)</p>
    </div>
    ';
    /* التنشيط */

    /* جائزة الثقافة الأمازيغية */
    $html5 = '
    <div>
    <p dir="RTL"> </p>
    <div style="text-align:left;">
    <p>الرباط، في:' . "$row[DT_AF]" . '</p>
    <p>تحت رقم: ' . "$row[NUM_CT]" . '</p>
    </div>
    <p dir="RTL" style="text-align:center;"><h2>عـقد تـعــاون</h2><strong>(لجنة جائزة الثقافة الأمازيغية )</strong></p>
    <p dir="RTL"><strong>بين</strong><strong>:</strong></p>
    <p dir="RTL">المعهد الملكي للثقافة الأمازيغية، الكائن مقره الاجتماعي بشارع علال الفاسي، مدينة العرفان، صندوق البريد: 2055، حي الرياض، الرباط؛ والممثل في شخص عميده،</p>
    <p dir="RTL">&nbsp;<strong>من جهة؛</strong></p>
    <p dir="RTL"><strong>و:</strong></p>
    <p dir="RTL">الإسم الشخصي والعائلي: ' . "$row[NOM_CTR]" . ' </p>
    <p dir="RTL">الحامل للبطاقة الوطنية للتعريف رقم ' . "$row[CIN_CTR]" . '</p>
    <p dir="RTL">عنوان السكنى : ' . "$row[ADRES_CTR]" . '</p>
    <p dir="RTL">والمشار إليها، بعده، بالمتعاقد، </p>
    <p dir="RTL"><strong>من</strong> <strong>جهة أخرى</strong><strong>.</strong> </p>
    <p dir="RTL"><strong>اتفق الطرفان على ما يلي</strong><strong>:</strong></p>
    <p dir="RTL"><strong>المادة الأولى: موضوع العقد</strong></p>
    <p dir="RTL">يلتزم المتعاقد برئاسة لجنة جائزة الثقافة الأمازيغية برسم سنة ' . "$row[AR1_CT]" . ' التي ينظمها المعهد الملكي للثقافة الأمازيغية والمشاركة في مداولاتها.</p>
    <p><strong>المادة الثانية: التزامات المتعاقد</strong></p>
    <p dir="RTL">يلتزم المتعاقد بالوفاء بالإلتزامات المذكورة في المادة الأولى في هذا العقد. كما يلتزم طيلة مدة سريان العقد وما بعدها، بالتحفظ التام في ما يتعلق بالوقائع والمعلومات والوثائق التي اطلع عليها أثناء القيام بمهامه. وبهذا، فإنه يقر باحترامه القوانين الجاري بها العمل في مجال السرية المهنية.</p>
    <p dir="RTL"><strong>المادة الثالثة: التزامات المعهد</strong></p>
    <p dir="RTL">يلتزم المعهد بمنح تعويض خام للمتعاقد، قدره أربعة عشر ألف ومائتان وخمسة وثمانون درهما وواحد وسبعون سنتيما (14.285,71 درهم)، ويجبر المبلغ الخام إلى الدرهم الأعلى ليكون أربعة عشر ألف ومائتان وستة وثمانون درهما (14.286,00 درهم)، وليصير المبلغ الصافي هو عشرة آلاف درهم ) 10.000,00 درهم)، بعد خصم 30 % من الضريبة على الدخل.</p>
    <p dir="RTL"><strong>المـادة الرابعة:</strong> <strong>بدء سريان العقد</strong><strong> </strong></p>
    <p dir="RTL">يتم العمل بهذا العقد ابتداء من تاريخ توقيع الطرفين عليه.</p>
    <p dir="RTL"><strong>المـادة الخامسة: واجبات التسجيل</strong></p>
    <p dir="RTL">يتحمل المتعاقد واجبـات التسجيل والرسوم الضريبية الجاري بها العمل بالنسبة للعقـود. </p>
    <p dir="RTL"><strong>المـادة السادسة: تسوية النزاع</strong></p>
    <p dir="RTL">في حالة نزاع حول تنفيذ مقتضيات هذا العقد، يعمل الطرفان على تسويته وديا، وفي حالة تعذر ذلك، يعرض الأمر، عند الاقتضاء، على محاكم الرباط المختصة.</p>
    <p><strong>المعهد الملكي للثقافة الأمازيغية</strong><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    المتعاقد</strong></p>
    <p><strong>السيد العميد</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . "$row[NOM_CTR]" . '</strong></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(مع عبارة قرئ وصودق عليه)</p>
    </div>
    ';
    /* جائزة الثقافة الأمازيغية */

    /* تسجيل مادة أدبية وفنية */
    $html6 = ' 
    <div>
    <p dir="RTL">قسم الموارد البشرية والشؤون العامة والقانونية / مصلحة الشؤون العامة والقانونية. </p>
    <div style="text-align:left;">
    <p>الرباط، في:' . "$row[DT_AF]" . '</p>
    <p>تحت رقم: ' . "$row[NUM_CT]" . '</p>
    </div>
    <p dir="RTL" style="text-align:center;"><h2>عـقد تـعــاون</h2><strong>(تسجيل مادة أدبية وفنية)</strong></p>
    <p dir="RTL"><strong>بين</strong><strong>:</strong></p>
    <p dir="RTL">المعهد الملكي للثقافة الأمازيغية، الكائن مقره بشارع علال الفاسي، مدينة العرفان، رقم صندوق البريد 2055 حي الرياض الرباط، والممثل في شخص عميده، السيد أحمد بوكوس، والمشار إليه، بعده، بالمعهد.</p>
    <p dir="RTL"><strong>من جهة؛</strong></p>
    <p dir="RTL"><strong>و: </strong></p>
    <p dir="RTL">الإسم الشخصي والعائلي: ' . "$row[NOM_CTR]" . ' </p>
    <p dir="RTL">الحامل للبطاقة الوطنية للتعريف رقم ' . "$row[CIN_CTR]" . ' </p>
    <p dir="RTL">عنوان السكنى : ' . "$row[ADRES_CTR]" . ' </p>
    <p dir="RTL">والمشار إليه، بعده، بالمتعاقد، </p>
    <p dir="RTL"> &nbsp; <strong>من</strong><strong> جهة أخرى.</strong> </p>
    <p dir="RTL"><strong>اتفق الطرفان على ما يلي</strong><strong></strong></p>
    <p dir="RTL"><strong>المادة الأولى: موضوع العقد</strong></p>
    <p dir="RTL">موضوع هذا العقد هو تسجيل مادة أدبية وفنية حول ذاكرة الموسيقى الأمازيغية، وفقا للبنود الواردة في هذا العقد، والشروط والمعايير المحددة في دفتر التحملات.</p>
    <p dir="RTL"><br /><strong>المادة الثانية: إلتزامات المتعاقد</strong></p>
    <p dir="RTL">يتعهد المتعاقد بـأن يمكن الباحثين اللذين سيعينهم مركز التعابير الأدبية والفنية، والإنتاج السمعي البصري من جمع وتدوين المعطيات والمعلومات المتعلقة بالموسيقى الأمازيغية ؛ </p>
    <p dir="RTL">يلتزم طيلة مدة العقد وما بعدها بالتحفظ التام فيما يتعلق بالوقائع والمعلومات والوثائق التي اطلع عليها أثناء القيام بمهامه. وفي هذا الصدد، فإنه يقر بخضوعه للقوانين الجاري بها العمل في مجال السرية المهنية؛</p>
    <p dir="RTL">يضمن صحة وصدق المادة موضوع العقد؛</p>
    <p dir="RTL">يصرح أن العمل الذي سيقدمه خال من أي نوع من أنواع القذف، أو التشهير، ومن أي مادة غير مشروعة، أو التي قد تثير اعتراض ذي حق أو أي احد عليها؛</p>
    <p dir="RTL">يتحمل المسؤولية الجنائية في أي دعوى أو مطالبة أو حقوق قد تنتج عن أي ملاحقة، ويتعهد أن يقوم هو دون المعهد، وعلى نفقته الخاصة، بالدفاع عن أية قضية تتعلق بهذه الأمور؛</p>
    <p dir="RTL">يتحمل مسؤولية ونفقات وتعويضات أي متعاون أومساهم، وخاصة في حالة إدراج الاستشهادات، والاقتباسات، والصور، والرسوم، وما إلى ذلك مما هو في ذمة الملكية الفكرية للغير؛</p>
    <p dir="RTL"> </p>
    <p dir="RTL"><strong>المادة الثالثة: التزامات المعهد</strong></p>
    <p dir="RTL">يلتزم المعهد بمنح تعويض خام للمتعاقد قدره  ' . "$row[MNT_BRUT_LTR]" . '  (' . "$row[MNT_BRUT]" . '  درهم)، يجبر المبلغ الخام إلى الدرهم الأعلى ' . "$row[MNT_ARN_LTR]" . '  ألفاً .................. درهماً &nbsp;' . "$row[MNT_ARN]" . '  00 درهم)، ليكون المبلغ الصافي هو ' . "$row[MNT_NET_LTR]" . '  .آلاف درهم (10.000,00 درهم)، بعد خصم 30 % من الضريبة على الدخل.</p>
    <p dir="RTL"><strong>المادة الرابعة:</strong><strong>بدء سريان العقد</strong><strong> </strong></p>
    <p dir="RTL">يتم العمل بهـذا العقد ابتداء من تاريخ توقيع الطرفين عليه.</p>
    <p dir="RTL"><strong>المادة الخامسة: فسخ العقد</strong></p>
    <p dir="RTL">يجوز فسخ هذا العقد دون إشعار، ودون تعويض من قبل المعهد، إذا لم يلتزم المتعاقد بالبنود الواردة في هذا العقد.</p>
    <p dir="RTL"><strong>المادة الخامسة: واجبات التسجيل</strong></p>
    <p dir="RTL">يتحمل المتعاقد واجبـات التسجيل والرسوم الضريبية الجاري بها العمل بالنسبة للعقود. </p>
    <p dir="RTL"><strong>المادة السادسة: تسوية النزاع</strong></p>
    <p dir="RTL">في حالة نزاع حول تنفيذ مقتضيات هذا العقد، يعمل الطرفان على تسويته وديا، وفي حالة تعذر ذلك، يعرض الأمر عند الاقتضاء على محاكم الرباط المختصة.</p>
    <p><strong>المعهد الملكي للثقافة الأمازيغية</strong><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    المتعاقد</strong></p>
    <p><strong>السيد العميد</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . "$row[NOM_CTR]" . '</strong></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(مع عبارة قرئ وصودق عليه)</p>
    </div>
    ';
    /* تسجيل مادة أدبية وفنية */

    /* Contrat Concours Jury */
    $html7 = ' 
    <div>
    <p dir="RTL"> </p>
    <div style="text-align:left;">
    <p>الرباط، في:' . "$row[DT_AF]" . '</p>
    <p>تحت رقم: ' . "$row[NUM_CT]" . '</p>
    </div>
    <p dir="RTL" style="text-align:center;"><h2>عـقد تـعــاون</h2><strong>(تحكيم)</strong></p>
    <p dir="RTL"><strong>بين</strong><strong>:</strong></p>
    <p dir="RTL">المعهد الملكي للثقافة الأمازيغية، الكائن مقره الاجتماعي بشارع علال الفاسي، مدينة العرفان، صندوق البريد: 2055، حي الرياض، الرباط؛ والممثل في شخص عميده،</p>
    <p dir="RTL">&nbsp;<strong>من جهة؛</strong></p>
    <p dir="RTL">و: </p>
    <p dir="RTL">الإسم الشخصي والعائلي: ' . "$row[NOM_CTR]" . ' </p>
    <p dir="RTL">الحامل للبطاقة الوطنية للتعريف رقم ' . "$row[CIN_CTR]" . '</p>
    <p dir="RTL">عنوان السكنى : ' . "$row[ADRES_CTR]" . '</p>
    <p dir="RTL">&nbsp;والمشار إليه، بعده، بالمتعاقد، </p>
    <p dir="RTL"> <strong>من</strong><strong>جهة أخرى</strong><strong>.</strong> </p>
    <p dir="RTL"><strong>اتفق الطرفان على ما يلي</strong><strong></strong></p>
    <p dir="RTL"><strong>المادة الأولى: موضوع العقد</strong></p>
    <p dir="RTL">المشاركة في اللجنة العلمية للتحكيم، الخاصة بمباراة ولوج إطار ' . "$row[AR1_CT]" . '</p>
    <p dir="RTL"><strong>المادة الثانية: التزامات المتعاقد</strong></p>
    <p dir="RTL">يلتزم المتعاقد بالمشاركة في أشغال لجنة التحكيم المتعلقة بمباراة ولوج xxxx، برسم سنة ' . "$row[AR2_CT]" . ' كما يلتزم طيلة مدة سريان العقد وما بعدها، بالتحفظ التام في ما يتعلق بالوقائع والمعلومات والوثائق التي اطلع عليها أثناء القيام بمهامه. وبهذا، فإنه يقر باحترامه القوانين الجاري بها العمل في مجال السرية المهنية.</p>
    <p dir="RTL"><strong>المادة الثالثة: التزامات المعهد</strong></p>
    <p dir="RTL">يلتزم المعهد بمنح تعويض خام للمتعاقد، قدره ' . "$row[MNT_BRUT_LTR]" . ' درهما وخمسة وثمانون سنتيما ' . "$row[MNT_BRUT]" . '  درهم)، ويجبر المبلغ الخام إلى الدرهم الأعلى ليكون ' . "$row[MNT_ARN_LTR]" . ' درهما ' . "$row[MNT_ARN]" . '  درهم)، وليصير المبلغ الصافي هو ' . "$row[MNT_NET_LTR]" . ' آلاف درهم )' . "$row[MNT_NET]" . ' د رهم)، بعد خصم 30 % من الضريبة على الدخل.</p>
    <p dir="RTL"><strong>المـادة الرابعة:</strong><strong>بدء سريان العقد</strong></p>
    <p dir="RTL">يتم العمل بهذا العقد ابتداء من تاريخ توقيع الطرفين عليه.</p>
    <p dir="RTL"><strong>المـادة الخامسة: واجبات التسجيل</strong></p>
    <p dir="RTL">يتحمل المتعاقد واجبـات التسجيل والرسوم الضريبية الجاري بها العمل بالنسبة للعقـود. </p>
    <p dir="RTL"><strong>المـادة السادسة: تسوية النزاع</strong></p>
    <p dir="RTL">في حالة نزاع حول تنفيذ مقتضيات هذا العقد، يعمل الطرفان على تسويته وديا، وفي حالة تعذر ذلك، يعرض الأمر، عند الاقتضاء، على محاكم الرباط المختصة.</p>
    <p dir="RTL"><strong> &nbsp;</strong><strong>المعهد الملكي للثقافة الأمازيغية </strong><strong> </strong><strong> المتعاقد </strong></p>
    <p><strong>المعهد الملكي للثقافة الأمازيغية</strong><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    المتعاقد</strong></p>
    <p><strong>السيد العميد</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . "$row[NOM_CTR]" . '</strong></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(مع عبارة قرئ وصودق عليه)</p>
    </div>
    ';
    /* Contrat Concours Jury */

    /* عقد بحث */
    $html8 ='
    <div>
    <div>
    <div style="text-align:left;">
    <p>الرباط، في:' . "$row[DT_AF]" . '</p>
    <p>تحت رقم: ' . "$row[NUM_CT]" . '</p>
    </div>
    <p dir="RTL" style="text-align:center;"><h2>عقد إنجاز بحث </h2></p>
    <p dir="RTL"><strong>بين </strong></p>
    <p dir="RTL">المعهد الملكي للثقافة الأمازيغية الكائن مقره الاجتماعي بشارع علال الفاسي، مدينة العرفان، حي الرياض، صندوق البريد 2055، الرباط، المشار إليه بعده بالمعهد، والممثل في شخص عميده من جهة ؛</p>
    <p dir="RTL"><strong>وبين</strong></p>
    <p dir="RTL">السيد N' . "$row[NOM_CTR]" . '، رقم بـطاقته الوطـنية ' . "$row[CIN_CTR]" . ' ،عنوان سكناه : ' . "$row[ADRES_CTR]" . '، &nbsp;والمشار إليه بالمتعاقد من جهة أخرى؛ </p>
    <p dir="RTL"><strong>الديباجة</strong></p>
    <p dir="RTL">بناء على الظهير الشريف رقم 1-01-299 بتاريخ 29 من رجب 1422 (17 أكتوبر 2001) بإحداث المعهد الملكي للثقافة الأمازيغية ولاسيما المادة الثالثة منه؛</p>
    <p dir="RTL">واعتبارا للمكانة المتميزة للثقافة الأمازيغية في تكوين هويتنا؛</p>
    <p dir="RTL">واعتبارا للدور الذي يقوم به المعهد في مجال التعريف بالتراث المغربي الأمازيغي؛ </p>
    <p dir="RTL">وبناء على برنامج عمل مركز الدراسات التاريخية والبيئية برسم سنة 2021؛</p>
    <p dir="RTL">وبناء على طلب العروض الخاص بإنجاز مشروع بحث تعاقدي في موضوع: " الدليل الجذاذي للمخطوطات والوثائق الأمازيغية، المصادر المكتوبة بالحرف العربي في منطقة سوس " لسنة 2021؛</p>
    <p dir="RTL">وبناء على محضر لجنة تتبع ملف إنجاز المشروع، لمركز ' . "$row[PRM_CT]" . '؛</p>
    <p dir="RTL">;وبناء على دفتر التحملات الخاص بالمشروع والمرفق مع العقد.</p>
    <p dir="RTL"><strong>اتفق الطرفان على ما يلي:</strong></p>
    <p dir="RTL"><strong>المادة الأولى: موضوع العقد </strong></p>
    <p dir="RTL">موضوع العقد هو انجاز مشروع بحث في موضوع :" ' . "$row[OBJ_CT]" . '"</p>
    <p dir="RTL"><strong>المادة الثانية: التزامات المتعاقد</strong></p>
    <p dir="RTL">يلتزم المتعاقد بموجب هذا العقد بما يلي:</p>
    <p dir="RTL"> ينجز البحث وفق المواصفات و الشروط المنصوص عليها في دفتر التحملات؛</p>
    <p dir="RTL">أن يسلم العمل في شكل جاهز للطبع؛</p>
    <p dir="RTL">أن تكون المخطوطة التي يسلمها للناشر، بموجب هذا العقد، خالية من أي نوع من أنواع القذف، أو التشهير، ومن أي مادة غير مشروعة، أو التي قد تثير اعتراض ذي حق أو أي احد عليها؛</p>
    <p dir="RTL">أن يتحمل هو دون الناشر مسؤولية ونفقات وتعويضات أي متعاون أومساهم محتمل في تأليف الكتاب موضوع العقد، وخاصة في حالة إدراج الاستشهادات والاقتباسات والصور والرسوم وما إلى ذلك مما هو في ذمة الملكية الفكرية للغير؛</p>
    <p dir="RTL">أن يتحمل هو دون الناشر، مسؤولية أي دعوى أو مطالبة أو حقوق قد تنتج عن أي ملاحقة بشأن حقوق التأليف، أو الاشتمال على مادة غير شرعية، أو إشارة غير شٍرعية، أو إشارة قذف أو تشهير بأحد. ويتعهد أن يقوم هو، وعلى نفقته الخاصة، بالدفاع عن أية قضية تتعلق بهذه الأمور؛</p>
    <p dir="RTL"><strong>المادة الثالثة: مدة الإنجاز</strong></p>
    <p dir="RTL">ينجز العمل المتعاقد بشأنه في مدة سنة واحدة من تاريخ إمضاء هذا العقد. </p>
    <p dir="RTL"><strong>المادة الرابعة: التتبع والتسليم</strong></p>
    <p dir="RTL">يتم تتبع مراحل إنجاز البحث المتعاقد بشأنه من قبل اللجنة العلمية لمركز الدراسات التاريخية والبيئية، التي تنجز تقاريرها حول الموضوع، حسب دفتر التحولات؛</p>
    <p dir="RTL">يعرض البحث المنجز على اللجنة العلمية لمركز الدراسات التاريخية والبيئية، من أجل الدراسة والتقويم؛</p>
    <p dir="RTL">يسلم المتعاقد البحث المنجز في نسخة واحدة على الورق، مع نسخة على حامل رقمي (قرص مضغوط) إلى مكتب الضبط بالمعهد، الذي يتولى تسجيله؛</p>
    <p dir="RTL">;يعرض العمل المنجز، والتقرير النهائي للجنة العلمية للمركز المذكور على العمادة من أجل المصادقة عليه.</p>
    <p dir="RTL"><strong>المادة الخامسة: التزامات المعهد </strong></p>
    <p dir="RTL">يلتزم المعهد بتقديم تعويض خام للمتعاقد قدره &nbsp;' . "$row[MNT_BRUT_LTR]" . '  درهما (' . "$row[MNT_BRUT]" . '  درهم)، يجبر المبلغ الخام إلى الدرهم الأعلى ليكون ' . "$row[MNT_ARN_LTR]" . '  درهما (' . "$row[MNT_ARN]" . ' درهم)، بعد خصم 30 % من الضريبة على الدخل، ليكون المبلغ الصافي أ ' . "$row[MNT_NET_LTR]" . '  &nbsp;رهم &nbsp;( &nbsp; ' . "$row[MNT_NET]" . ' درهم).</p>
    <p dir="RTL"><strong>المادة السادسة: حق الاستغلال</strong></p>
    <p dir="RTL">يحتفظ المعهد بحق استغلال البحث المنجز من قبل المتعاقد، بما في ذلك حق الطبع والنشر وكل أوجه الاستغلال الأخرى. ولا يجوز للمتعاقد، خلال مدة العقد أو مستقبلا، إبرام أي عقد آخر أو اتفاق مماثل مع الغير يتعلق بنفس الموضوع. كما لا يجوز له نشر البحث المنجز في إطار هذا العقد، كليا أو جزئيا. في حالة طبع البحث تمنح للمتعاقد خمسون نسخة.</p>
    <p dir="RTL"><strong>المادة السابعة: فسخ العقد </strong></p>
    <p dir="RTL">يجوز للمعهد في حالة عدم التزام المتعاقد بإنجاز البحث موضوع العقد وفق المواصفات والشروط المحددة في دفتر التحملات، رفقته، وخلال الآجال المحددة، حق فسخ هذا العقد من جانب واحد، ولا يترتب على هذا الإجراء أي تعويض أو مطالبة كيفما كان نوعها من قبل المتعاقد.</p>
    <p dir="RTL"><strong>المادة الثامنة: تسوية النزاع</strong></p>
    <p dir="RTL">في حالة نزاع حول تنفيذ مقتضيات هذا العقد، يعمل الطرفان على تسويته وديا، وفي حالة تعذر ذلك، يعرض الأمر عند الاقتضاء على محاكم الرباط المختصة.</p>
    <br>
    <div>
    <p><strong>المعهد الملكي للثقافة الأمازيغية</strong><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    المتعاقد</strong></p>
    <p><strong>السيد العميد</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . "$row[NOM_CTR]" . '</strong></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(مع عبارة قرئ وصودق عليه)</p>
    </div>
    ';
    /* عقد بحث*/

    /* Contrat traduction */
    $html9 = ' 
    <div>
    <div style="text-align:left;">
    <p>الرباط، في:' . "$row[DT_AF]" . '</p>
    <p>تحت رقم: ' . "$row[NUM_CT]" . '</p>
    </div>
    <p dir="RTL" style="text-align:center;"><h2>عـقد تـرجمـة</h2></p>
    <p><strong>بي</strong><strong>ن:</strong></p>
    <p>المعهد الملكي للثقافة الأمازيغية الكائن مقره الاجتماعي بشارع علال الفاسي، مدينة العرفان، رقم صندوق البريد 2055 حي الرياض الرباط، والممثل في شخص عميده،  </p>
    <strong>من جهة</strong>؛
    <p dir="RTL"><strong>و:</strong></p>
    <p dir="RTL">الإسم الشخصي والعائلي: ' . "$row[NOM_CTR]" . ' </p>
    <p dir="RTL">الحامل للبطاقة الوطنية للتعريف رقم ' . "$row[CIN_CTR]" . ' </p>
    <p dir="RTL">عنوان السكنى : ' . "$row[ADRES_CTR]" . ' </p>
    <p dir="RTL">والمشار إليه بعده بالمتعاقد، <strong>من جهة أخرى.</strong></p>
    <p><strong>الـديـبـاجة</strong></p>
    <p dir="RTL">بناء على الظهير الشريف رقم1-01-299 &nbsp;بتاريخ 29 من رجب 1422 (17 أكتوبر 2001) القاضي بإحداث المعهد الملكي للثقافة الأمازيغية ولاسيما المادة الثالثة منه؛</p>
    <p dir="RTL">واعتبارا للمكانة المتميزة للثقافة الأمازيغية في تكوين هويتنا الثقافية؛</p>
    <p dir="RTL">واعتبارا للدور الذي يقوم به المعهد المتمثل في التعريف بالثقافة الأمازيغية، والنهوض بها ونشرها؛ </p>
    <p dir="RTL">ونظرا لأهمية الترجمة في إثراء اللغة والثقافة الأمازيغيتين؛</p>
    <p dir="RTL">وبناء على طلب إبداء الرغبة، لإنجاز ترجمة بالتعاقد إلى الأمازيغية، برسم سنة 2020؛</p>
    <p dir="RTL">;وبناء على محضر اجتماع اللجنة الخاصة بدراسة وانتقاء ملفات المترشحين، بتاريخ ' . "$row[DT_AF]" . '</p>
    <p><strong>اتفق الطرفان على مايلي:</strong></p>
    <p dir="RTL"><strong>المادة الأولى: موضوع العقد</strong></p>
    <p dir="RTL">موضوع هذا العقد هو ترجمة ' . "$row[OBJ_CT]" . '</p>
    <p dir="RTL">والتي سيتم نشرها من قبل المعهد الملكي للثقافة الأمازيغية وذلك وفق الشروط المحدّدة في دفتر التحملات.</p>
    <p dir="RTL"><strong>المادة الثانية: التزامات المتعاقد</strong></p>
    <p dir="RTL">يلتزم المتعاقد بما يلي:</p>
    <ul type="disc">
    <li dir="RTL">ترجمة الحكايات المشار إليها أعلاه كاملا؛</li>
    </ul>
    <p dir="RTL">ضمان تطابق النص المترجم مع النص الأصلي؛</p>
    <p dir="RTL">ترجمة النص وكذا الهوامش والمراجع؛</p>
    <p dir="RTL">كتابة النص بلغة معيارية، محترما في ذلك قواعد اللغة المترجم إليها؛</p>
    <p dir="RTL">احترام ضوابط التحرير والبيبليوغرافيا المعمول بها في مجال النشر في اللغة المترجم إليها؛</p>
    <p dir="RTL">إدماج الشروحات اللازمة لجعل النص أكثر وضوحا؛</p>
    <p dir="RTL">إدخال الهوامش بأسفل النص المترجم؛</p>
    <p dir="RTL">تقديم الصيغة الأولى للعمل في غضون ستة (06) أشهر من تاريخ توقيع هذا العقد.&nbsp;بصورة استثنائية يمكن تمديد المدة خمسة عشر (15) يوما.</p>
    <p dir="RTL">إدخال التعديلات اللازمة بعد مراجعة خبير يعين من طرف مركز الترجمة والتوثيق والنشر والتواصل؛ </p>
    <p dir="RTL">الالتزام بقراءة وتصحيح العمل حتى يكون جاهزا للطبع بدون إعادة صياغته؛</p>
    <p dir="RTL">تقديم العمل النهائي مراجعا ومصححا على الورق وعلى قرص مدمج؛ في أجل أقصاه شهرا بعد التوصل بملاحظات الخبير أو الخبراء؛</p>
    <p dir="RTL"><strong>المادة الثالثة: التزامات المعهد</strong></p>
    <ul type="disc">
    <li dir="RTL">يلتزم المعهد بتقديم تعويض خام للمتعاقد قدره،' . "$row[MNT_BRUT_LTR]" . '  درهم، و واحد وسبعون سنتيما ' . "$row[MNT_BRUT]" . '  يجبر المبلغ الخام إلى الدرهم الأعلى ليكون 
    ' . "$row[MNT_ARN_LTR]" . '  درهم ' . "$row[MNT_ARN]" . '  00درهم، بعد خصم 30 % من الضريبة على الدخل، ليكون المبلغ الصافي هو ' . "$row[MNT_NET_LTR]" . '  درهم،' . "$row[MNT_NET]" . ' درهم(، على أساس ' . "$row[MNT_NET]" . ' ' . "$row[PRM_CT]" . 'صفحة &nbsp;، وهذا بعد تسلم العمل النهائي المترجم والموافقة عليه من طرف عميد المعهد الملكي للثقافة الأمازيغية.</li>
    <li dir="RTL">يلتزم المعهد بتسليم المتعاقد خمس (05) نسخ من المؤلف المترجم بعد طبعه.</li>
    </ul>
    <p dir="RTL"><strong>المادة الرابعة: شروط استثنائية</strong></p>
    <p dir="RTL">الحقوق التي يتمتع بها المعهد في إطار هذا العقد هي حصرية، &nbsp;لذا يلتزم المتعاقد أن لا يبرم أية عقود أو اتفاقيات أخرى مشابهة تحت أي تسمية كانت مع أطراف أخرى تتعلق بنفس الموضوع، بما في ذلك الاستنساخ أو استغلال هذه الترجمة.</p>
    <p dir="RTL"><strong>المادة الخامسة: فسخ العقد</strong></p>
    <p dir="RTL">يتمتع المعهد بصفة حصرية بحق فسخ العقد في حالة لم يتم احترام مادة أو مجموعة من المواد من طرف المتعاقد.</p>
    <p dir="RTL"><strong>المادة السادسة:</strong><strong>بدء سريان العقد</strong> </p>
    <p dir="RTL">يتم العمل بهذا العقد ابتداءا من تاريخ توقيع الطرفين عليه.</p>
    <p dir="RTL"><strong>المادة السابعة</strong>: <strong>واجبات التسجيل</strong></p>
    <p dir="RTL">يتحمل المؤلف واجبـات التسجيل والرسوم الضريبية الجاري بها العمل بالنسبة للعقود. </p>
    <p dir="RTL"><strong>المادة الثامنة: تسوية النزاع</strong></p>
    <p dir="RTL">في حالة نزاع حول تنفيذ مقتضيات هذا العقد، يعمل الطرفان على تسويته وديا، وفي حالة تعذر ذلك، يعرض الأمر عند الاقتضاء على محاكم الرباط المختصة.</p>
    <p><strong>المعهد الملكي للثقافة الأمازيغية</strong><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    المتعاقد</strong></p>
    <p><strong>السيد العميد</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . "$row[NOM_CTR]" . '</strong></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(مع عبارة قرئ وصودق عليه)</p>
    </div>
    ';
    /* Contrat traduction */
    
    /* Contrat دعائم رقمية */
    $html10 = '
    <div>
    <p dir="RTL" style="text-align:center;"><h2>عقد إنجاز دعائم رقمية</h2></p>
    <p dir="RTL"><strong>بين: </strong></p>
    <p dir="RTL">المعهد الملكي للثقافة الأمازيغية الكائن مقره الاجتماعي بشارع علال الفاسي، مدينة العرفان، رقم صندوق البريد 2055 حي الرياض الرباط، والممثل في شخص عميده،</p>
    <strong>من جهة</strong>؛ 
    <p dir="RTL"><strong>و:</strong></p>
    <p dir="RTL">الإسم الشخصي والعائلي: ' . "$row[NOM_CTR]" . ' </p>
    <p dir="RTL">الحامل للبطاقة الوطنية للتعريف رقم ' . "$row[CIN_CTR]" . ' </p>
    <p dir="RTL">عنوان السكنى : ' . "$row[ADRES_CTR]" . ' </p>
    <p dir="RTL">والمشار إليه بعده بالمتعاقد،<strong> من جهة أخرى.</strong></p>
    <p dir="RTL"><strong>الديباجة</strong></p>
    <p dir="RTL">بناء على الظهير الشريف رقم1-01-299 &nbsp;بتاريخ 29 من رجب 1422 (17 أكتوبر 2001) القاضي بإحداث المعهد الملكي للثقافة الأمازيغية ولاسيما المادة الثالثة منه؛</p>
    <p dir="RTL">وبناء على القرار رقم 4258 بتاريخ 18 دجنبر 2018، خاصة المادة 12 منه؛</p>
    <p dir="RTL">وبناء على المذكرة الداخلية رقم 2250 بتاريخ 20 يونيو 2018 المتعلقة بالوثائق المطلوبة لإنجاز العقود؛</p>
    <p dir="RTL">واعتبارا للمكانة المتميزة للثقافة الأمازيغية في تكوين هويتنا الثقافية؛</p>
    <p dir="RTL">واعتبارا للدور الذي يقوم به المعهد المتمثل في التعريف بالثقافة الأمازيغية، والنهوض بها ونشرها؛ </p>
    <p dir="RTL">وبناء على طلب إبداء الرغبة، لإنجاز مشروع صور بالتعاقد ، برسم سنة 2020؛</p>
    <p dir="RTL">;وبناء على محضر اجتماع اللجنة الخاصة بدراسة وانتقاء ملفات المترشحين، بتاريخ  ' . "$row[PRM_CT]" . ' </p>
    <p dir="RTL"><strong>اتفق الطرفان على ما يلي:</strong></p>
    <p dir="RTL"><strong>المادة الأولى: موضوع العقد </strong></p>
    <p dir="RTL">إنجاز صور توضيحية رقمية لدروس اللغة الأمازيغية عن بعد الخاصة بالكبار:</p>
    <p dir="RTL">;100 صورة توضيحية من الحجم الكبير (grandes illustrations)</p>
    <p dir="RTL">;210 صورة توضيحية من الحجم الصغير (figurines)</p>
    <p dir="RTL">وذلك في إطار تنفيذ البرنامج العلمي للمعهد.</p>
    <p dir="RTL"><strong>المادة الثانية: التزامات المتعاقد</strong></p>
    <p dir="RTL">يلتزم المتعاقد بموجب هذا العقد بمايلي:</p>
    <p dir="RTL">إنجاز الصور التوضيحية الرقمية وفق الشروط المنصوص عليها في دفتر التحملات؛</p>
    <p dir="RTL">;احترام الشروط المحددة في دفتر التحملات.</p>
    <p dir="RTL"><strong>المادة الثالثة: مدة الإنجاز</strong></p>
    <p dir="RTL">تحدد مدة إنجاز الرسوم المتعاقد بشأنها في ثلاثة (3) أشهر ابتداء من تاريخ إمضاء هذا العقد. </p>
    <p dir="RTL"><strong>المادة الرابعة: التتبع والتسليم</strong></p>
    <p dir="RTL">يتم تتبع مراحل الصور التوضيحية الرقمية المتعاقد بشأنها من قبل المسؤولين عن المشروع بكل من مركز البحث الديداكتيكي والبرامج البيداغوجية ومركز الدراسات المعلوماتية وأنظمة الإعلام والاتصال الذين ينجزون تقاريرهم ويعرضوها على عميد المعهد للمصادقة عليها؛</p>
    <p dir="RTL">يتم تسليم الصور التوضيحية الرقمية المنجزة إلى الكتابة العامة للمعهد، التي تتولى تسجيلها؛</p>
    <p dir="RTL">;تسلم الصور التوضيحية الرقمية على حامل رقمي (cl&eacute; USB) بالمواصفات المذكورة في دفتر التحملات؛</p>
    <p dir="RTL">يعرض العمل المنجز وتقرير اللجنة على عميد المعهد من أجل المصادقة عليه؛</p>
    <p dir="RTL"><strong> المادة الخامسة: التزامات المعهد </strong></p>
    <p dir="RTL">يلتزم المعهد بتقديم تعويض خام للمتعاقد قدره  ' . "$row[MNT_BRUT_LTR]" . '  درهما ' . "$row[MNT_BRUT]" . '  درهما)، يجبر المبلغ الخام إلى الدرهم الأعلى ليصبح ' . "$row[MNT_ARN_LTR]" . ' درهما &nbsp; ' . "$row[MNT_ARN]" . '  درهما)، &nbsp;بعد خصم 30 % من الضريبة على الدخل، ليكون المبلغ الصافي هو &nbsp; ' . "$row[MNT_NET_LTR]" . '  ألف درهم ( ' . "$row[MNT_NET]" . '  00 درهم(</p>
    <p dir="RTL"><strong>المادة السادسة: حق الاستغلال</strong></p>
    <p dir="RTL">يحتفظ المعهد بحق استغلال الصور التوضيحية الرقمية المنجزة من قبل المتعاقد، بما في ذلك حق الطبع والنشر وكل أوجه الاستغلال الأخرى. ولا يجوز للمتعاقد، خلال مدة العقد أو مستقبلا، إبرام أي عقد آخر أو اتفاق مماثل مع الغير يتعلق بنفس الصور المنجزة. كما لا يجوز له نشر الصور المنجزة في إطار هذا العقد، كليا أو جزئيا.</p>
    <p dir="RTL"><strong>المادة السابعة: فسخ العقد </strong></p>
    <p dir="RTL">يجوز للمعهد في حالة عدم التزام المتعاقد بإنجاز الصور موضوع العقد وفق المواصفات والشروط المحددة في دفتر التحملات رفقته، وخلال الآجال المحددة، حق فسخ هذا العقد من جانب واحد، ولا يترتب على هذا الإجراء أي تعويض أو مطالبة كيفما كان نوعها من قبل المتعاقد.</p>
    <p dir="RTL">&nbsp;<strong>المادة الثامنة: تسوية النزاع</strong></p>
    <p dir="RTL">في حالة نزاع حول تنفيذ مقتضيات هذا العقد، يعمل الطرفان على تسويته وديا، وفي حالة تعذر ذلك، يعرض الأمر عند الاقتضاء على محاكم الرباط المختصة.                                                               </p>
    <p><strong>المعهد الملكي للثقافة الأمازيغية</strong><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    المتعاقد</strong></p>
    <p><strong>السيد العميد</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . "$row[NOM_CTR]" . '</strong></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(مع عبارة قرئ وصودق عليه)</p>
    </div>
    ';
    /* Contrat دعائم رقمية */

     /* Contrat d'édition */
     $html11 = ' 
     <div>
     <p></p>
     <p dir="RTL" style="text-align:center;"><h2>عــقد نـشــر</h2></p>
     <p dir="RTL"><strong>بين: </strong></p>
     <p dir="RTL">المعهد الملكي للثقافة الأمازيغية الكائن مقره الاجتماعي بشارع علال الفاسي، مدينة العرفان، رقم صندوق البريد 2055 حي الرياض الرباط، والممثل في شخص عميده، المشار إليه بعده <strong>بالناشر</strong>، من جهة؛ </p>
     <p dir="RTL"><strong>و:</strong></p>
     <p dir="RTL">مؤلِّف كتاب : <strong>' . "$row[NOM_CTR]" . '</strong></p>
     <p dir="RTL">الإسم الشخصي والعائلي: ' . "$row[NOM_CTR]" . ' </p>
     <p dir="RTL">الحامل للبطاقة الوطنية للتعريف رقم ' . "$row[CIN_CTR]" . ' </p>
     <p dir="RTL">عنوان السكنى : ' . "$row[ADRES_CTR]" . ' </p>
     <p dir="RTL">والمشار إليه بعده بالمؤلف من جهة أخرى؛</p>
     <p dir="RTL"><strong>الـديباجــة</strong></p>
     <p dir="RTL">بناء على الظهير الشريف رقم 1-01-299 بتاريخ 29 من رجب 1422 (17 أكتوبر 2001) القاضي بإحداث المعهد الملكي للثقافة الأمازيغية ولاسيما المادة الثالثة منه؛</p>
     <p dir="RTL">واعتبارا للمكانة المتميزة للثقافة الأمازيغية في تكوين هويتنا الثقافية؛</p>
     <p dir="RTL">واعتبارا للدور الذي يقوم به المعهد المتمثل في التعريف بالثقافة الأمازيغية، والنهوض بها ونشرها؛ </p>
     <p dir="RTL">وحيث إن مؤلَف " ' . "$row[PRM_CT]" . ' <strong></strong><strong>" </strong>يعد ثمرة بحث أكاديمي، ونظرا لأهميته في إبراز البعد الأمازيغي في تاريخ المغرب وحضارته، والتعريف بها.</p>
     <p dir="RTL">وبناءا على التقارير المنجزة من قبل لجنة القراءة.</p>
     <p dir="RTL"><strong>اتفق الطرفان على ما</strong><strong> يلي:</strong></p>
     <p dir="RTL"><strong>المادة الأولى: موضوع العقد</strong></p>
     <p dir="RTL">يتنازل المؤلف عن حقوق نشر الكتاب الموسوم : ' . "$row[AR1_CT]" . ' لفائدة الناشر، وذلك وفق الشروط والمقتضيات المبينة بعده. </p>
     <p dir="RTL">تفاصيل هذا التنازل ومدته وامتداده، وكذا حقوق والتزامات الطرفين محددة حسب ما هو وارد بعده.</p>
     <p dir="RTL"><strong>المادة الثانية: مدة العقد وامتداد حق النشر </strong></p>
     <p dir="RTL">مدة سريان هذا العقد خمس سنوات، ويشمل طبع ونشر الكتاب موضوع العقد على سائر الحوامل الممكنة (نسخة ورقية، نسخة شمسية، نسخة رقمية، قرص مدمج، مكروفيلم وغيرها)؛ </p>
     <p dir="RTL">لا يشمل هذا العقد ترجمة الكتاب إلى لغات أخرى. ويتعين إخضاع أي مشروع ترجمة إلى أية لغة كانت إلى دراسة توافقية بين الناشر والمؤلف، وتكون موضوع عقد موقع لهذا الغرض من الطرفين؛ </p>
     <p dir="RTL">يتم الاتفاق كتابة بين الناشر والكاتب على استغلال الكتاب موضوع العقد في منتجات أخرى كيفما كانت (مسرحية وإذاعية، وسينمائية، ورسوم ثابتة أو متحركة وغيرها)؛ </p>
     <p dir="RTL">يتعهد المؤلف بإشعار الناشر كتابة بكل مقترح ذي صلة بالعمليات المذكورة أعلاه؛</p>
     <p dir="RTL">يحتفظ المعهد بحق نشر النسخة موضوع العقد على موقعه الالكتروني.</p>
     <p dir="RTL"><strong>المادة الثالثة: التزامات المؤلف</strong></p>
     <p dir="RTL">يلتزم المؤلف بما يلي:</p>
     <p dir="RTL">بأن تكون المخطوطة التي يسلمها للناشر، بموجب هذا العقد، كاملة وجاهزة للطبع، وأنه هو واضعها الوحيد المخوّل له عقد مثل هذا الاتفاق؛</p>
     <p dir="RTL">أن تكون المخطوطة التي يسلمها للناشر، بموجب هذا العقد، خالية من أي نوع من أنواع القذف، أو التشهير، ومن أي مادة غير مشروعة، أو التي قد تثير اعتراض ذي حق أو أي احد عليها؛</p>
     <p dir="RTL">أن يتحمل هو دون الناشر مسؤولية ونفقات وتعويضات أي متعاون أومساهم محتمل في تأليف الكتاب موضوع العقد، وخاصة في حالة إدراج الاستشهادات والاقتباسات والصور والرسوم وما إلى ذلك مما هو في ذمة الملكية الفكرية للغير؛</p>
     <p dir="RTL">أن يتحمل هو دون الناشر، مسؤولية أي دعوى أو مطالبة أو حقوق قد تنتج عن أي ملاحقة بشأن حقوق التأليف، أو الاشتمال على مادة غير شرعية، أو إشارة غير شٍرعية، أو إشارة قذف أو تشهير بأحد. ويتعهد أن يقوم هو، وعلى نفقته الخاصة، بالدفاع عن أية قضية تتعلق بهذه الأمور؛</p>
     <p dir="RTL">أن تكون المخطوطة المذكورة لم يسبق لها أن نشرت من قبل، لا جزئيا ولا كليا من قبل أي ناشر، وللناشر أن يعتبرها مؤلفاً جديداً خاضعاً لحقوق النشر العائدة له كأي كتاب ينشر الآن لأول مرة ضمن إصداراته؛</p>
     <p dir="RTL">أن يسلّم للناشر مخطوطة الكتاب جاهزةً للطبع وفي حالة ترضي الناشر؛</p>
     <p dir="RTL">أن يقدّم على نفقته الخاصة الرسوم والأشكال التي يقتضيها الكتاب المتعاقَد بشأنه، وأن يقدّم إشهاداً مكتوبا وموقعاً عليه ومصادقاً عليه من ذوي الحقوق المتعلقة بكل الرسوم والصور والبيانات وغيرها المتضمّنة في الكتاب موضوع العقد؛</p>
     <p dir="RTL">أن يعيد للناشر، ضمن مدة لا تتعدى 15 (خمسة عشر) يوما، النسخة الموجهة إليه للمراجعة وللتصحيح النهائي، والمصادقة على الطبع، موقعة ومؤرّخة ومشفوعة بعبارة "صالح للطبع".</p>
     <p dir="RTL"><strong>&nbsp;المادة الرابعة: التزامات الناشر</strong></p>
     <p dir="RTL">يلتزم الناشر بنشر العمل في الدفعة الأولى في 500 نسخة؛</p>
     <p dir="RTL">يلتزم الناشر بتسليم المؤلف خمس (05) نسخة من العمل.</p>
     <p dir="RTL">يلتزم الناشر بتسليم المؤلف عشرة في المائة (10%) من ثمن البيع الاجمالي للكتاب، كما يمكن تسليم المؤلف، إذا رغب في ذلك، خمسين(50) نسخة من الكتاب بدلا من التعويض المادي.</p>
     <p dir="RTL"><strong>المادة الخامسة: التزام الطرفين</strong></p>
     <p dir="RTL">باتفاق متبادل بين الناشر والمؤلف، يلتزم كلاهما بما يلي:</p>
     <p dir="RTL">أن يكون عنوان المخطوطة التي ستنشر بموجب هذا العقد هو المشار إليه في المادة الأولى أعلاه، وأن هذا العنوان سيتغير فقط بالاتفاق المتبادل بين الطرفين؛</p>
     <p dir="RTL">أن يقوم الناشر بإجراء التغييرات التي يرتئيها في نص المخطوطة التي يقدّمها المؤلف، كما تقتضيها الأساليب والأعراف والمبادئ المعتمدة لدى الناشر؛</p>
     <p dir="RTL">أن يحتفظ الناشر بحق تحديد مقاس وحجم الكتاب موضوع العقد؛</p>
     <p dir="RTL">أن يحتفظ الناشر بحق تحديد الثمن العمومي لبيع الكتاب موضوع العقد؛</p>
     <p dir="RTL">أن يكون غلاف الكتاب من النوع المقوى ويحمل الصورة أو الزخرفة التي يختارها المتعاقد.</p>
     <p dir="RTL"><strong>المـادة السادسة : مقتضيات متعلقة بالخزن</strong></p>
     <p dir="RTL">عنـد استنفاذ نسخ السحب الأول، يمكن للناشر والمؤلف أن يتفقا بشأن التدابير اللاحقة عند الاقتضاء والخاصة بإعادة السحب أو النشر أو عدمهما.</p>
     <p dir="RTL"><strong>المادة السابعة: مقتضيات حصرية</strong></p>
     <p dir="RTL">إن الحقوق التي يتمتع بها الناشر، والمنصوص عليها في هذا العقد هي حقوق كاملة وحصـرية طيلة مدة سريـان هذا العقد؛ ويلتزم المؤلف بعدم إبرام عقود أو اتفاقيات مشابهة مع أطراف أخرى متعلقة بالكتاب موضوع هذا العقد، ويشمل ذلك حالات إعادة الإصدار والنشر والاقتباس وتحويل مضمون الكتاب إلى أي عمل أدبي أو فني أو إلى أي شكل من أشكال الإصدار الحالية والممكنة.</p>
     <p dir="RTL">&nbsp;<strong>المادة الثامنة: المسؤولية في حالة القوة القاهرة</strong></p>
     <p dir="RTL">في حالة الحريق أو الفيضان أو الحرب أو السرقة أو أي حادث أو كارثة من أي نوع كانت، فلا يتحمل الناشر أي مسؤولية عن النسخ المتلفة أو المفقودة.</p>
     <p dir="RTL"><strong>المـادة التاسعة</strong>: <strong>واجبات التسجيل</strong></p>
     <p dir="RTL">يتحمل المؤلف واجبـات التسجيل والرسوم الضريبية الجاري بها العمل بالنسبة للعقود. </p>
     <p dir="RTL"><strong>المـادة العاشرة: تسوية النزاع</strong></p>
     <p dir="RTL">في حالة نزاع حول تنفيذ مقتضيات هذا العقد، يعمل الطرفان على تسويته وديا، وفي حالة تعذر ذلك، يعرض الأمر عند الاقتضاء على محاكم الرباط المختصة.</p>
     <p><strong>المعهد الملكي للثقافة الأمازيغية</strong><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     المؤلف</strong></p>
     <p><strong>الناشر</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . "$row[NOM_CTR]" . '</strong></p>
     <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(مع عبارة قرئ وصودق عليه)</p>
     </div>
     ';
     /* Contrat d'édition */

    /* Contrat Consultant  */
    $html12 ='
    <div>
    <div style="text-align:left;">
    <p>الرباط، في:' . "$row[DT_AF]" . '</p>
    <p>تحت رقم: ' . "$row[NUM_CT]" . '</p>
    </div>
    <h1 dir="RTL" style="text-align:center;"><strong>عـقـد لخبرة إستشارية</strong></h1>
    <h2 dir="RTL"><strong>بيــن:</strong></h2>
    <p dir="RTL">المعهد الملكي للثقافة الأمازيغية، الكائن مقره الاجتماعي بشارع علال الفاسي، مدينة العرفان، صندوق البريد رقم 2055، حي الرياض، الرباط، والممثل في شخص عميده السيد أحمد بوكوس</p>
    <p dir="RTL"><strong>من جهة، </strong></p>
    <h3 dir="RTL"><strong>وبيــن: </strong></h3>
    <p dir="RTL">السيد ' . "$row[NOM_CTR]" . ' رقم بطاقته الوطنية ' . "$row[CIN_CTR]" . ' والمشار إليه أسفله، بصفة المتعاقد؛</p>
    <p dir="RTL"><strong>من جهة أخرى.</strong></p>
    <h4 dir="RTL"><strong>الديبــــاجة</strong></h4>
    <p dir="RTL">بناء على الظهير الشريف رقم 299-01-1 بتاريخ 29 من رجب1422 (17 أكتوبر 2001) المتعلق بإحداث المعهد الملكي للثقافة الأمازيغية ولاسيما المادة الثالثة منه؛</p>
    <p dir="RTL">وعلى أحكام النظام الداخلي المعهد الملكي للثقافة الأمازيغية ؛ </p>
    <p dir="RTL">وعلى النظام الأساسي لمستخدمي المعهد الملكي للثقافة الأمازيغية؛</p>
    <p dir="RTL">;وعلى ترخيص السيد رئيس الحكومة بتمديد التعاقد مع المتعاقد، والمسجل تحت رقم:' . "$row[PRM_CT]" . '</p>
    <p dir="RTL"> </p>
    <p dir="RTL"><strong>اتفق الطرفـان على مــا يلـــي </strong></p>
    <h5 dir="RTL">المادة الأولى: موضوع العقد</h5>
    <p dir="RTL">إنجاز خدمات الخبرة والاستشارة لفائدة المعهد الملكي للثقافة الأمازيغية.</p>
    <p dir="RTL"> </p>
    <h5 dir="RTL">المادة الثانية: التزامات المتعاقد </h5>
    <p dir="RTL">من أجل تنفيذ موضوع هذا العقد يلتزم المتعاقد من جهته بما يلي:</p>
    <p dir="RTL">القيام بالمهام المسندة إليه من طرف العمادة ؛</p>
    <p dir="RTL">الاستشارة في الميدانين الإداري والمالي؛</p>
    <p dir="RTL">مواكبة المعهد في تحضير دفاتر التحملات المتعلقة بالصفقات ذات الطبيعة الخاصة؛</p>
    <p dir="RTL">المشاركة في لجن تتبع الإنجاز الخاصة بالصفقات الموجودة في طور الإنجاز؛</p>
    <p dir="RTL">المشاركة في لجن مباريات توظيف الإداريين والتقنيين؛</p>
    <p dir="RTL">إنجاز التقرير المتعلق بمشروع ميزانية المعهد برسم سنة 2022؛</p>
    <p dir="RTL">تقديم تقارير دورية للعمادة عن المهام المنجزة ؛</p>
    <p dir="RTL">التقيد بالمقتضيات المنصوص عليها في النظام الأساسي لمستخدمي المؤسسة، على مستوى الواجبات، وخاصة المادة 14 التي تنص على التقيد بواجب التحفظ والحفاظ على السر المهني ؛</p>
    <p dir="RTL">التقيد بمقتضيات المادة 16 المتعلقة بمواقيت العمل، والمادة 17 المتعلقة بالعطل؛</p>
    <p dir="RTL">التقيد بالمقتضيات المنصوص عليها في المواد 41، 42 و 50 المنظمة للرخص؛</p>
    <p dir="RTL">التقيد بمقتضيات القرارات والمساطر الإدارية المعمول بها داخل المؤسسة. </p>
    <h5 dir="RTL">المادة الثالثة: التزامات المعهد</h5>
    <p dir="RTL">يلتزم المعهد بتقديم تعويض خام شهري للمتعاقد مقداره سبعة عشر ألفا ومائة واثنان وأربعون درهما، وستة وثمانون سنتيما ( 17.142,86 درهما)، و يجبر المبلغ الخام إلى الدرهم الأعلى ليصبح سبعة عشر ألفا ومائة وثلاث وأربعين درهما (17.143,00 درهما) ، بعد خصم 30 % من الضريبة على الدخل، ليكون المبلغ الصافي هو اثنا عشر ألف درهم ( 12.000,00درهم(،</p>
    <p dir="RTL">تضمن المؤسسة للمتعاقد حق الاستفادة من مقتضيات المادة 52، المنظمة لكيفيات الاستفادة من التأمين عن حوادث الشغل والأمراض المهنية؛</p>
    <p dir="RTL">يستفيد المتعاقد من ما يستفيد منه المتصرفون من الدرجة الأولى، بمناسبة سفرياته داخل المملكة،</p>
    <p dir="RTL">لأغراض المصلحة، من التعويضات عن التنقل والإقامة.</p>
    <p><strong>المادة الرابعة: مدة العقد</strong></p>
    <p dir="RTL">يبرم هذا العقد لمدة سنة واحدة، و يدخل حيز التنفيذ ابتداء من فاتح يناير 2120.</p>
    <p><strong>المعهد الملكي للثقافة الأمازيغية</strong><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    المتعاقد</strong></p>
    <p><strong>السيد العميد</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>' . "$row[NOM_CTR]" . '</strong></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(مع عبارة قرئ وصودق عليه)</p>
    </div>
    ';
    /* Contrat Consultant*/


        $ID_TYPE_CT = $row['ID_TYPE_CT'];
        if ($ID_TYPE_CT == 1)
        {
          $pdf->writeHTML($html1, true, false, true, false,'');
        }
        else if ($ID_TYPE_CT == 2)
        {
          $pdf->writeHTML($html2, true, false, true, false,'');
        }
        else if ($ID_TYPE_CT == 3)
        {
          $pdf->writeHTML($html3, true, false, true, false,'');
        }
        else if ($ID_TYPE_CT == 4)
        {
          $pdf->writeHTML($html4, true, false, true, false,'');
        }
        else if ($ID_TYPE_CT == 5)
        {
          $pdf->writeHTML($html5, true, false, true, false,'');
        }
        else if ($ID_TYPE_CT == 6)
        {
          $pdf->writeHTML($html6, true, false, true, false,'');
        }
        else if ($ID_TYPE_CT == 7)
        {
          $pdf->writeHTML($html7, true, false, true, false,'');
        }
        else if ($ID_TYPE_CT == 8)
        {
          $pdf->writeHTML($html8, true, false, true, false,'');
        }
        else if ($ID_TYPE_CT == 9)
        {
          $pdf->writeHTML($html9, true, false, true, false,'');
        }
        else if ($ID_TYPE_CT == 10)
        {
          $pdf->writeHTML($html10, true, false, true, false,'');
        }
        else if ($ID_TYPE_CT == 11)
        {
          $pdf->writeHTML($html11, true, false, true, false,'');
        }
        else if ($ID_TYPE_CT == 12)
        {
          $pdf->writeHTML($html12, true, false, true, false,'');
        }

      //Close and output PDF document
      $pdf->Output('Contrats.pdf', 'I');
          }
        }
      }

    }
    ob_end_flush();
?>