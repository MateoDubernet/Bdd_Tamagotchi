<?php require __DIR__ . '/../views/layouts/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
                <h1 class="text-center authentication-title">Créer un compte</h1>
                <form action="/connexion/authentification.php" method="POST" class="form-signin">
                    <div class="form-section">
                        <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" required autofocus>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">S'inscrire</button>
                </form>
            </div>
            <a href="./login.php" class="text-center new-account">Déjà inscrit ? Se connecter</a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../views/layouts/footer.php'; ?>
