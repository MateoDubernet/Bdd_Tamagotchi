<?php require __DIR__ . '/../header.php' ?>

<div class="container ">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
            <h1 class="text-center authentication-title">Créer un compte</h1>
                <form action="/connexion/users.php" method="POST" class="form-signin">
                    <div class="form-section">
                        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus />
                    </div>                    
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
                </form>
            </div>
            <a href="./login.php" class="text-center new-account">Log in</a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../footer.php' ?>