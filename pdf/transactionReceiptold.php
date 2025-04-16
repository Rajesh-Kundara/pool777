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

// Sample Data (replace with dynamic data)
$week = 13;
$gameType = "PERM3";
$ref = "6789765433221";
$cashier = 5;
$agentId = "Lorem Ipsum";
$date = "02-17-2025";
$time = "8:00";
$games = ['12', '4', '16', '22', '6', '8'];
$amtPerLine = 200;
$NoOfLines = 6;
$total = 1200;
$bonusCode = "uyntty8o90";
$logoPath = $_SERVER['DOCUMENT_ROOT'] . "/pool777/assets/images/logo.png";
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
            padding: 20px;
            border: 2px solid #000;
            width: 300px;
            margin: auto;
        }
        .header {
            text-align: center;
        }
        .info {
            font-size: 12px;
            margin-bottom: 10px;
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
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class='header'>
        <img src='data:image/png;base64,$logoData' height='100' width='100'>
    </div>
    <div class='info'>
        <strong style='font-size: large;'>Week:</strong> $week 
        <hr>
    </div>
    <div class='info'>
        <table>
            <tbody>
                <tr>
                    <td><strong>Game Type:</strong> $gameType</td>
                    <td><strong>Agent ID:</strong> $agentId</td>
                </tr>
                <tr>
                    <td><strong>Ref:</strong> $ref</td>
                    <td><strong>Date:</strong> $date</td>
                </tr>
                <tr>
                    <td><strong>Cashier:</strong> $cashier</td>
                    <td><strong>Time:</strong> $time</td>
                </tr>
            </tbody>
        </table>
    </div>
    <hr>
    <strong>Games:</strong>
    <table class='games' align='center' style='margin: 10px auto;'>
        <tr>";
        foreach ($games as $game) {
            $circleSvg = "data:image/svg+xml;base64," . base64_encode('
            <svg width="35" height="35" xmlns="http://www.w3.org/2000/svg">
                <circle cx="17.5" cy="17.5" r="17" stroke="black" stroke-width="1" fill="white" />
                <text x="50%" y="65%" font-size="14" dominant-baseline="middle" text-anchor="middle" font-weight="bold">'.$game.'</text>
            </svg>
           ');
            $html .= "<td style='text-align: center; padding: 5px;' ><img src='$circleSvg' width='35' height='35'></td>";
        }
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

// echo $html;die;
// Load HTML into Dompdf
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output the generated PDF
$dompdf->stream("ticket.pdf", ["Attachment" => false]);
?>
