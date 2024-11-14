<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h3 class="text-center mb-4">Register</h3>
        <form id="registerForm" class="w-50 mx-auto">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username">
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-secondary w-100">Register</button>
            <div id="registerResponse" class="mt-3 text-center"></div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/register',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            // Jika register berhasil, alihkan ke dashboard
                            window.location.href = response.redirect;
                        } else {
                            // Tampilkan pesan error jika register gagal
                            $('#registerResponse').text(response.errors || response.error);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>