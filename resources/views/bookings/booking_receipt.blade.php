<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>

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

        .receipt-title {
            border: 3px solid #2a82c4;
            background-color: #2a82c4;
            color: white;
            padding: 10px;
            width: 96%;
            text-align: center;
            box-sizing: border-box;
        }
    </style>
</head>

<body style="font-size: 15px">
    <div>
        <table width="100%">
            <tr>
                <td> <!-- Images Section (Left) -->
                    <div style="text-align: left;">
                        <?php
                        $logo = base_path('public/images/MaqamTravels_Logo.svg');
                        ?>
                        <img src="{{ $logo }}" width="100px" alt="maqam" style="margin-right: 20px;">
                    </div>
                </td>
                <td><!-- Address Section (Right) -->
                    <div style="text-align: right;">
                        <p style="font-weight: bold;">
                            1st floor, AAA Complex,<br>
                            Bukoto Kisasi Road,<br>
                            P.O. Box 101776, Kampala, Uganda<br>
                            Call / Whatsapp: +256709741486<br>
                            Email: info@maqamtravels.com
                        </p>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Receipt Title Section -->
        <div class="receipt-title">
            <h2>PAYMENT RECEIPT</h2>
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
                    <td>Booking Type</td>
                    <td>{{ $bookingType }}</td>
                </tr>
                <tr>
                    <td>Package</td>
                    <td>{{ $package }}</td>
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
                    <td>Currency</td>
                    <td>{{ $currency }}</td>
                </tr>
                <tr>
                    <td>Rate</td>
                    <td>{{ $rate }}</td>
                </tr>
                <tr>
                    <td>Amount Deposited Uptodate</td>
                    <td>{{ number_format($amountDepositedUptodate) }}</td>
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
