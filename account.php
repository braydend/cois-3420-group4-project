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
                } elseif (isset($usernameFree) && !$usernameFree) {
                  echo "<span class='error'>username already in use</span>";
                } ?>
            </div>
            <div class="form-element">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" />
                <?php if (isset($validName) && !$validName) {
                  echo "<span class='error'>name is not valid</span>";
                } ?>
            </div>
            <div class="form-element">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" />
                <?php if (isset($validEmail) && !$validEmail) {
                  echo "<span class='error'>email is not valid</span>";
                } elseif (isset($emailFree) && !$emailFree) {
                  echo "<span class='error'>email already in use</span>";
                } ?>
            </div>
            <div class="form-element">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" />
                <?php if (isset($validPassword) && !$validPassword) {
                  echo "<span class='error'>" . $passErr . "</span>";
                } ?>
            </div>
            <div class="form-element">
                <label for="password_confirm">Confirm Password:</label>
                <input type="password" name="password_confirm" id="password_confirm" />
                <?php if (isset($passwordMatchesConfirm) && !$passwordMatchesConfirm) {
                  echo "<span class='error'>Could not confirm password</span>";
                } ?>
            </div>
            <div class="form-buttons">
                <input type="submit" value="Create Account!" name="submit" />
                <input type="reset" />
            </div>
        </form>
    </div>
</body>
</html>
