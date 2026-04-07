<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="min-vh-100 d-flex align-items-center justify-content-center px-3" style="background-color: #f5eee6;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 24px;">
                    <div class="row g-0">

                        <div class="col-md-6 d-flex align-items-center justify-content-center text-center p-5" style="background-color: #8b5e3c; min-height: 500px;">
                            <div>
                                <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png"
                                    alt="Logo Velora"
                                    class="img-fluid mb-4"
                                    style="max-width: 190px;">
                                <h1 class="text-white fw-bold mb-0 display-5">Velora</h1>
                            </div>
                        </div>

                        <div class="col-md-6 p-4 p-md-5" style="background-color: #fffaf5;">
                            <h2 class="text-center fw-bold mb-4" style="color: #5c3d2e;">Login</h2>

                            <form method="POST" action="/login">
                                @csrf

                                <div class="mb-4">
                                    <label for="username" class="form-label" style="color: #6f4e37;">Username</label>
                                    <input
                                        type="text"
                                        id="username"
                                        name="username"
                                        class="form-control form-control-lg"
                                        placeholder="Masukkan username"
                                        style="border-color: #d8c7b8;">
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label" style="color: #6f4e37;">Password</label>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="form-control form-control-lg"
                                        placeholder="Masukkan password"
                                        style="border-color: #d8c7b8;">
                                </div>

                                <button type="submit" class="btn w-100 py-3 text-white" style="background-color: #8b5e3c;">
                                    Login
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>