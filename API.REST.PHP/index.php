<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <div class="card p-4 shadow" style="width: 22rem;">
        <h3 class="text-center">Iniciar Sesión</h3>
        <form id="loginForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
        <div id="loginMessage" class="mt-3 text-center"></div>
    </div>

    <script>
        $("#loginForm").submit(function(e) {
            e.preventDefault(); // Avoid normal form submission
            $.ajax({
                url: "login.php",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response === "success") {
                        window.location.href = "page.php"; // Redirect if successful
                    } else {
                        $("#loginMessage").html('<div class="alert alert-danger">Usuario o contraseña incorrectos</div>');
                    }
                },
                error: function() {
                    $("#loginMessage").html('<div class="alert alert-warning">Error en el servidor</div>');
                }
            });
        });
    </script>

</body>
</html>