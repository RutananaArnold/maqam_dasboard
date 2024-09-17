<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sonda Mpola Receipt</title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .details,
        .assured {
            width: 100%;
            border-collapse: collapse;
        }

        .details td,
        .assured td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .details tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        h2 {
            margin: 0;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .header-section div {
            width: 100%;
        }

        .receipt-title {
            border: 3px solid #2a82c4;
            background-color: #2a82c4;
            color: white;
            padding: 10px;
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }
    </style>
</head>

<body style="font-size: 15px">
    <div>

        <!-- Header Section with Address and Images -->
        <div class="header-section">
            <!-- Images Section (Left) -->
            <div style="text-align: left;">
                <?php
                $logo = base_path('public/images/MaqamTravels_Logo.svg');
                $sondaMpola = base_path('public/images/SondaMpola_Logo.svg');
                ?>
                <img src="{{ $logo }}" width="100px" alt="maqam" style="margin-right: 20px;">
                <img src="{{ $sondaMpola }}" width="100px" alt="sondaMpola">
            </div>

            <!-- Address Section (Right) -->
            <div style="text-align: right;">
                <p style="font-weight: bold;">
                    1st floor, AAA Complex,<br>
                    Bukoto Kisasi Road,<br>
                    P.O. Box 101776, Kampala, Uganda<br>
                    Tel / Whatsapp: +256709741486<br>
                    Email: info@maqamtravels.com
                </p>
            </div>
        </div>

        <!-- Receipt Title Section -->
        <div class="receipt-title">
            <h2>SONDA MPOLA RECEIPT</h2>
        </div>

        <div style="margin-top: 10px"></div>

        <!-- Details Table -->
        <div class="section">
            <table class="details">
                <tr>
                    <td>Received from</td>
                    <td>{{ $name }}</td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>{{ $currentDate }}</td>
                </tr>
                <tr>
                    <td>Reference</td>
                    <td>{{ $reference }}</td>
                </tr>
                <tr>
                    <td>Sonda Mpola Target</td>
                    <td>{{ $sondaMpolaTarget }}</td>
                </tr>
                <tr>
                    <td>Mode of Payment</td>
                    <td>{{ $modeOfPayment }}</td>
                </tr>
                <tr>
                    <td>Amount Deposited</td>
                    <td>{{ number_format($amountDeposited) }}</td>
                </tr>
                <tr>
                    <td>Balance</td>
                    <td>{{ number_format($balance) }}</td>
                </tr>
                <tr>
                    <td>Issued By</td>
                    <td>{{ $issuedBy }}</td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
