<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>End of Training Certificate</title>
    <style>
        @page {
            size: A4 landscape; /* Set the page size to A4 landscape */
            margin: 0;
        }
        body {
            font-family: 'Georgia', serif;
            margin: 0;
            padding: 40px; /* Adjust padding as needed */
            background: #fff; /* Background color for the certificate */
            width: 90%; /* A4 width in landscape */
            height: 210mm; /* A4 height in landscape */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #333;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .container {
            background-color: #fff;
            border: 10px solid #007BFF;
            padding: 40px;
            max-width: 900px;
            margin: 5px auto;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        h1 {
            color: #007BFF;
            font-size: 28px;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            margin: 20px 0;
        }

        .info {
            margin-top: 20px;
            background-color: #e7f1ff;
            padding: 15px;
            border-left: 5px solid #007BFF;
        }

        .info ul {
            list-style: none;
            padding: 0;
        }

        .info li {
            margin-bottom: 8px;
        }

        .signature {
            margin-top: 50px;
            font-style: italic;
        }

        .uuid {
            font-size: 14px;
            color: #666;
            margin-top: 15px;
        }

        .uuid strong {
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Certificate of Training Completion</h1>
        This certificate is proudly presented to <strong>{{ $trainee->first_name }} {{ $trainee->last_name }}</strong>

        <div class="info">
            <p><strong>Training Details:</strong></p>
            <ul>
                <li>In recognition of successfully completing the {{ $trainee->position->name }} training program. This
                    rigorous program included comprehensive skills training and assessments which {{ $trainee->first_name }}
                    completed with commendable performance.</li>
                <li>Start Date: <strong>{{ $trainee->start_date }}</strong></li>
                <li>Completion Date: <strong>{{ now()->toDateString() }}</strong></li>
            </ul>
        </div>

        <div class="signature">
            <p>Authorized Signature: ______________________</p>
            <p>Date: <strong>{{ now()->toDateString() }}</strong></p>
        </div>

        <div class="uuid">
            <p>UUID: <strong>{{ $trainee->uuid }}</strong></p>
        </div>
    </div>
</body>

</html>
