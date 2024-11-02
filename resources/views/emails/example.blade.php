<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h2>{{ $subject }}</h2>
<p>{{ $content }}</p>

<h3>Exceptions Summary:</h3>
{!! $tableHtml !!}  <!-- Use {!! !!} to render HTML safely -->

@if (!empty($attachments))
    <h4>Attached Documents:</h4>
    <ul>
        @foreach ($attachments as $attachment)
            <li>{{ $attachment['file_name'] }}</li>
        @endforeach
    </ul>
@endif

<p>Regards,<br>USISHIP</p>
</body>
</html>
