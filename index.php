<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
</head>

<body>

    <div class="container mt-5">
        <h1 class="h1 text-center"> Si Admin </h1>
    </div>

    <div class="container">
        <div id="message">
        </div>

        <div class="card mx-5 my-5 px-5 py-5">
            <form id="form-login">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
        </div>
    </div>

<script>
        const Host = window.location.protocol + '//' + window.location.host;
        const UrlLogin = Host + '/api/auth/login.php';
        const UrlUsers = Host + '/views/users/';

        $(document).ready(function() {
            $('#form-login').on('submit', function(event) {
                event.preventDefault();

                var formData = {
                    'email': $('#email').val(),
                    'password': $('#password').val()
                }

                $.ajax({
                    url: UrlLogin,
                    method: "POST",
                    data: JSON.stringify(formData),
                    success: function(data) {
                        $('#action_button').attr('disabled', false);
                        window.location.href = UrlUsers;
                    },
                    error: function(err) {
                        if (err.status === 404) {
                            $('#message').html('<div class="alert alert-danger">' + 'alamat ' + UrlLogin + ' tidak ditemukan ' + '</div>');
                        } else {
                            $('#message').html('<div class="alert alert-danger">' + err.responseJSON + '</div>');
                        }
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
