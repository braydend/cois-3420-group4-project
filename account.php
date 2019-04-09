<?PHP
    $title = "Create Account";

    include ('header.php');

    include 'add-account.php'; ?>


    <div class="container">
        <h1>Create an account:</h1>
        <form method="post" name="form">
            <div class="form-element">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" />
                <?php if (isset($validUsername) && !$validUsername) {
                  echo "<span class='error'>username is not valid</span>";
                } ?>
                <span class='error' id='usernameError'></span>
            </div>
            <div class="form-element">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" />
                <span class='error' id="nameError"></span>
            </div>
            <div class="form-element">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" />
                <span class='error' id="emailError"></span>
                <?php if (isset($emailFree) && !$emailFree) {
                  echo "<span class='error'>email already in use</span>";
                } ?>
            </div>
            <div class="form-element">
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" />
                <span class='error' id="passwordError"></span>
            </div>
            <div class="form-element">
                <label for="password_confirm">Confirm Password:</label>
                <input type="password" name="password_confirm" id="password_confirm" />
                <?php if (isset($passwordMatchesConfirm) && !$passwordMatchesConfirm) {
                  echo "<span class='error'>Could not confirm password</span>";
                } ?>
            </div>
            <div class="form-buttons">
                <input type="submit" id="submit" value="Create Account!" name="submit" />
                <input type="reset" />
            </div>
        </form>
    </div>
    <script src="js/account.js"></script>
</body>
</html>
