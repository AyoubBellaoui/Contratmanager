<?php 
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=Tous les contractants.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    require '../Connection/Config.php';

    $output = "";

    $output .="
    <table>
        <thead>
            <tr>
                <th>NOM_CTR</th>
                <th>CIN_CTR</th>
                <th>EMAIL_CTR</th>
                <th>TEL_CTR</th>
            </tr>
        </thead>
    <tbody>
    ";

    $query = $db->query("SELECT * FROM `contractant`");
    while($fetch = $query->fetch_array()) {

        $output .= "
        <tr>
            <td>".$fetch['NOM_CTR']."</td>
            <td>".$fetch['CIN_CTR']."</td>
            <td>".$fetch['EMAIL_CTR']."</td>
            <td>".$fetch['TEL_CTR']."</td>
        </tr>
        ";
    }

    $output .="
        </tbody>
			
    </table>
	";

    echo $output;

?>

