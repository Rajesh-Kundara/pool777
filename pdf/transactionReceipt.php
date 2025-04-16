<?php
require 'vendor/autoload.php';
require_once 'autoload.inc.php';
require_once '../config.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Initialize Dompdf options
$options = new Options();
$options->set('defaultFont', 'Helvetica');
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);

$id=0;
if (!empty($_GET['id'])){
    $id=$_GET['id'];
}
$stmt = $connection->prepare("SELECT a.week,a.couponId,a.couponTypeId,a.userId,a.date,a.stackAmount, 
(SELECT GROUP_CONCAT(matchId) FROM stackdetail where parentId=a.id) AS matches,
(SELECT CONCAT(f_name,' ',l_name) from users where id=a.userId) as userName,
(SELECT couponId from coupons where id=a.couponId) as couponId,
(SELECT name from coupontypemaster where id=a.couponTypeId) as couponType FROM stacks a WHERE a.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        $week = $row['balance'];
        $couponId = $row['couponId'];
        $gameType = $row['couponType'];
        $agentId = $row['userName'];

        $datetime = new DateTime('2019-12-22 23:50:00');
        $date = $datetime->format('d-m-Y'); 
        $time = $datetime->format('H:i:s');

        $total = $row['stackAmount'];
        $week = $row['week'];
        $games=explode(',', $row['matches']);;
    }
// Sample Data (replace with dynamic data)

$cashier = 5;

//$games = ["12", "4", "16", "22", "6", "8"];
$amtPerLine = 200;
$NoOfLines = 6;
$bonusCode = "-";
$logoPath = $host . "/assets/images/logo.png";
 $logoData = base64_encode(file_get_contents($logoPath)); 

// HTML Content for PDF
$html = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>PDF Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2px;
            border: 1px solid #cbcbcb;
            width: 100%;
            margin: auto;
        }
        .header {
            text-align: center;
        }
        .info {
            font-size: 12px;
            margin-bottom: 10px;
            margin-top:-10px;
        }
        .games {
            width: 100%;
            margin: 10px auto;
            text-align: center;
        }
     .circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 1px solid #000;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
            line-height: 35px; /* Same as height */
            display: inline-block; /* Important for centering */
        }
        .total {
            font-size: 15px;
            font-weight: bold;
            margin-top: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 2px;
        }
    </style>
    <script src='https://printjs.crabbly.com/js/print.min.js'></script>
</head>
<body>
    <div class='header'>
        <img src='data:image/png;base64,$logoData' height='80' width='80'>
    </div>
    <div class='info'>
        <strong style='font-size: medium;'>Week: $week </strong> 
        <hr>
    </div>
    <div class='info'>
        <table>
            <tbody>
                <tr>
                    <td><strong>Game Type:</strong> $gameType</td>
                    <td><strong>Date :</strong> $date</td>
                </tr>
                <tr>
                    <td><strong>User :</strong> $agentId</td>
                    <td><strong>Time:</strong> $time</td>
                </tr>
                <tr>
                    <td colspan='2'><strong>Ref :</strong> $couponId</td>
                </tr>
                <tr>
                    <td><strong>Cashier:</strong> $cashier</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <hr>
    <strong>Games:</strong>
    <table class='games' align='center' style='margin: 8px auto;'>";
        $i=0;
        foreach ($games as $game) {
            if($i%5==0) $html.="<tr>";
            $circleSvg = "data:image/svg+xml;base64," . base64_encode('
            <svg width="35" height="35" xmlns="http://www.w3.org/2000/svg">
                <circle cx="17.5" cy="17.5" r="17" stroke="black" stroke-width="1" fill="white" />
                <text x="50%" y="65%" font-size="14" dominant-baseline="middle" text-anchor="middle" font-weight="bold">'.$game.'</text>
            </svg>
           ');
            $html .= "<td style='text-align: center; padding: 5px;' ><img src='$circleSvg' width='32' height='32'></td>";
            $i++;
            if($i%5==0) $html.="</tr>";
        }
        if(sizeof($games)%5!=0)$html.="</tr>";
$html .= "
        </tr>
    </table>
    <div class='info'>
        <table>
            <tbody>
                <tr>
                    <td><strong>Amount per line:</strong> $amtPerLine</td>
                    <td><strong>No. of Lines:</strong> $NoOfLines</td>
                </tr>
            </tbody>
        </table>
    </div>
    <hr>
    <div class='total'>
        <strong>TOTAL:</strong> $total
    </div>
    <div class='info' style='margin-top:10px;'>
        <strong>Bonus code:</strong> $bonusCode
    </div>
</body>
</html>";
// Load HTML into Dompdf
$dompdf->loadHtml($html);
// Set custom paper size: width = 80mm (3.15in), height = 297mm (11.7in or more if needed)
//$customPaper = array(0, 0, 226.77, 841.89); // Width: 80mm, Height: 297mm (in points: 1mm = 2.8346pt)
$customPaper = array(0, 0, 280, 841.89); // Width: 80mm, Height: 297mm (in points: 1mm = 2.8346pt)

$dompdf->setPaper($customPaper, 'portrait');

$dompdf->render();

// Encode PDF as Base64
//$pdfOutput = base64_encode($dompdf->output());
$pdfOutput =$dompdf->output();

// Return Base64 JSON response
header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename='document.pdf'");
echo $pdfOutput;
exit;
?>

