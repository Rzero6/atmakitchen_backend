<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .card-container {
            display: flex;
            justify-content: center;
        }

        .card {
            min-width: 50vh;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div>
        <div class="card-container">
            <div class="card p-5 justify-content-center">
                <div id=contentWrapper>

                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script>
    var message = '{{ $message }}';
    if (isNaN(message)) {
        document.getElementById("contentWrapper").innerHTML = `
                <h1>{{ $message }}</h1>`;
    } else {
        document.getElementById("contentWrapper").innerHTML = `
        <form action="{{ route('update.password') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $message }}">
            <div class="input-group">
                <input name="password" oninput="checkPasswords()" type="password" class="form-control mb-2" id="inputPassword1"
                    placeholder="Password">
                <span class="input-group-text mb-2" onclick="togglePasswordVisibility('inputPassword1')">
                    <i id="eyeIcon1" class="fa fa-eye-slash"></i>
                </span>
            </div>
            <div class="input-group">
                <input type="password" oninput="checkPasswords()" class="form-control mb-3" id="inputPassword2"
                    placeholder="Konfirmasi Password">
                <span class="input-group-text mb-3" onclick="togglePasswordVisibility('inputPassword2')">
                    <i id="eyeIcon2" class="fa fa-eye-slash"></i>
                </span>
            </div>
            <div class="d-grid">
                <div class="alert alert-warning " role="alert" style="text-align: left;">
                    Pastikan <strong>Password</strong> sesuai!
                </div>
                <button id="resetButton" class="btn btn-primary" type="submit" disabled>Reset</button>
            </div>
        </form>
        `
    }

    function togglePasswordVisibility(inputId) {
        var input = document.getElementById(inputId);
        var eyeIcon = document.getElementById("eyeIcon" + inputId.substr(-1));

        if (input.type === "password") {
            input.type = "text";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        } else {
            input.type = "password";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        }
    }

    function checkPasswords() {
        var password1 = document.getElementById("inputPassword1").value;
        var password2 = document.getElementById("inputPassword2").value;
        var resetButton = document.getElementById("resetButton");

        if (password1 === "" || password2 === "" || password1 !== password2) {
            resetButton.disabled = true;
        } else {
            resetButton.disabled = false;
        }
    }
</script>

</html>
