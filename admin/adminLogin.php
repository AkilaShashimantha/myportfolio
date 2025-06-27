
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .login-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #ddeffa 0%, #e5eff9 100%);
    }

    .login-card {
      border-radius: 16px;
      box-shadow: 0 0 24px rgba(45, 0, 65, 0.10);
      background: #fff;
      padding: 2.5rem 2rem;
      width: 100%;
      max-width: 400px;
    }

    .password-toggle {
      position: absolute;
      top: 38px;
      right: 16px;
      cursor: pointer;
      width: 14px;
      z-index: 10;
      opacity: 0.7;
    }

    @media (max-width: 576px) {
      .login-card {
        padding: 2rem 1rem;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-card">
      <h2 class="text-center text-primary mb-4">Admin Login</h2>
      <form method="post" action="adminLoginProcess.php" autocomplete="off">
        <div class="mb-3 position-relative">
          <label for="adminEmail" class="form-label">Email address</label>
          <input type="email" class="form-control" id="adminEmail" name="e" required autocomplete="username">
        </div>
        <div class="mb-3 position-relative">
          <label for="adminPassword" class="form-label">Password</label>
          <div class="row">
  <input type="password" class="form-control " id="adminPassword" name="p" required autocomplete="current-password">
        <span class="password-toggle" id="pShow">Show</span>
        <script>
          const pShow = document.getElementById('pShow');
          const adminPassword = document.getElementById('adminPassword');
          pShow.addEventListener('click', function() {
            if (adminPassword.type === "password") {
              adminPassword.type = "text";
              pShow.textContent = "Hide";
            } else {
              adminPassword.type = "password";
              pShow.textContent = "Show";
            }
          });
        </script>  </div>
        
        </div>
        <div class="d-grid">
          <button class="btn btn-primary" type="submit">Sign In</button>
        </div>
        <span class="text-danger text-center d-block mt-3" id="msg"></span>
      </form>
    </div>
  </div>

</body>

</html>
