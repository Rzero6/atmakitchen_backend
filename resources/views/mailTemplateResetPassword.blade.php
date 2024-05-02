<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>

<body>
    <p>
        Halo <b>{{ $details['username'] }}</b>!
    </p>

    <p>
        Anda telah melakukan permintaan untuk reset password akun pada email ini pada <strong>
            <?php echo date('d M Y', strtotime($details['datetime'])); ?>
        </strong>
    </p>

    <center>
        <h3>Buka link dibawah untuk melakukan reset password.</h3>
        <b style="color: blue">{{ $details['url'] }}</b></a>
    </center>
</body>

</html>
