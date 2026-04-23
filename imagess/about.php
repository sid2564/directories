


<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>About Vapi</title>

    <!-- Important for Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        *{
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            width: 90%;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
        }

        p {
            line-height: 1.8;
            color: #444;
            font-size: 16px;
            margin-bottom: 18px;
            text-align: justify;
        }

        /* Tablet */
        @media (max-width: 768px) {
            .container {
                padding: 25px;
            }

            h1 {
                font-size: 24px;
            }

            p {
                font-size: 15px;
            }
        }

        /* Mobile */
        @media (max-width: 480px) {
            .container {
                margin: 20px auto;
                padding: 20px;
            }

            h1 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
                line-height: 1.6;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>About Vapi</h1>

    <p>
        Vapi is a well-known industrial city in Gujarat, India.
        It is located in the Valsad district and is considered one of the
        largest industrial areas in Asia.
    </p>

    <p>
        The city is famous for chemical industries, textile units,
        plastic manufacturing and pharmaceutical companies.
        Vapi is well connected by road and railway, making it
        an important commercial center.
    </p>

    <p>
        Vapi is a city and municipality in Valsad District in the state of Gujarat.
        It is situated on the banks of the Damanganga River and is the largest
        city in the Valsad district and also the second largest city after Surat
        in South Gujarat.
    </p>

    <p>
        Economic and industrial growth in recent decades has blurred
        the physical boundaries, and a small stretch of roughly 21 km
        of Daman-Vapi-Silvassa has almost become a single urban area.
    </p>

    <p>
        It is the largest industrial area in Asia in terms of small-scale industries,
        dominated by the chemical industry. However, it has also faced
        environmental challenges due to industrial pollution.
    </p>
</div>
   <?php include('includes/footer.php'); ?>

</body>
</html>