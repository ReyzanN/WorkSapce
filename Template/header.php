<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
    <link rel='icon' href="assets/img/NavLogoFav.png">
    <title>WorkSpace - New Way To Work !</title>
</head>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid mx-auto">
        <a class="navbar-brand" href="#">
            <img src="assets/img/NavLogoFav.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
            WorkSpace - Welcome !</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mx-auto" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 mx-auto justify-content-between">
            </ul>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#connectstatic">
                <i class="bi bi-person"></i>&nbsp;- Déjà Client ? - S'identifer
            </button>
        </div>
    </div>
</nav>

<!-- Modal Connexion -->
<div class="container-fluid">
    <div class="modal fade" id="connectstatic" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Se connecter à son espace</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#">
                        <div class="mb-3">
                            <label for="emailConnect" class="form-label">Adresse Email</label>
                            <input type="email" class="form-control" id="emailConnect">
                        </div>
                        <div class="mb-3">
                            <label for="ConnectPass" class="form-label">Mot De Passe</label>
                            <input type="password" class="form-control" id="ConnectPass">
                        </div>
                        <button type="submit" class="btn btn-outline-success">Me connecter</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
</div>