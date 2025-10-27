<?php
session_start();
$errors = [
  'login' => $_SESSION['login_error'] ??'',
  'register'=> $_SESSION['register_error']??''
];
$activeForm = $_SESSION['active_form']?? 'login';
session_unset();
function showError($error){
  return !empty($error) ?"<p class='error-message'>$error</p>" : '';
}
function isActiveForm($formName, $activeForm){
  return $formName === $activeForm ? 'active' : '';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Registration / Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <script src="script_log.js"></script>
  <div class="container">
    
    <div class="form-box <?= isActiveForm('register',$activeForm); ?>" id="register-form">
        <form action="users.php" method="POST">
            <h2>Register New User</h2>
            <?= showError($errors['register']); ?>
            <label for="name">Name</label>
            <input type="text" name="name" required>

            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <label for="role">Role</label>
            <select name="role">
                <option value="employee">Employee</option>
                <option value="it_staff">IT Staff</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" name="register">Register</button>
            <p>Already an account?<a href="#" onclick = "showForm('login-form')">Login</a><p>
        </form>
    </div>

    
    <div class="form-box <?= isActiveForm('login',$activeForm); ?>"id="login-form">
        <form action="users.php" method="POST">
            <h2>Login</h2>
            <?= showError($errors['login']); ?>
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="login">Login</button>
            
            <p>Don't have an account?<a href="#" onclick = "showForm('register-form')">Register</a><p>
        </form>
    </div>
  </div>
</body>
</html>
