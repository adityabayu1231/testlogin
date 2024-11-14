<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h3 class="text-center mb-4">Login</h3>
        <form id="loginForm" class="w-50 mx-auto">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username">
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <div id="loginResponse" class="mt-3 text-center"></div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/login',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            // Jika login berhasil, alihkan ke dashboard
                            window.location.href = response.redirect;
                        } else {
                            // Tampilkan pesan error jika login gagal
                            $('#loginResponse').text(response.error);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>