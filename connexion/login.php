<?php require '../header.php' ?>

<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
            <h1 class="text-center login-title">Connexion</h1>
                <form action="/connexion/users.php" method="GET" class="form-signin">
                    <div class="form-section">
                        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus />
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                </form>
            </div>
            <a href="./register.php" class="text-center new-account">Register</a>
        </div>
    </div>
</div>

<?php require '../footer.php' ?>