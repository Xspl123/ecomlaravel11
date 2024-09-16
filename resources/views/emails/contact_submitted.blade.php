<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Form Submission</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title">New Contact Form Submission</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>Name: &nbsp;</th>
                            <td>{{ $data['name'] }}</td>
                        </tr>
                        <tr>
                            <th>Email: &nbsp;</th>
                            <td>{{ $data['email'] }}</td>
                        </tr>
                        <tr>
                            <th>Phone: &nbsp;</th>
                            <td>{{ $data['phone'] }}</td>
                        </tr>
                        <tr>
                            <th>Message: &nbsp;</th>
                            <td>{{ $data['comment'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
