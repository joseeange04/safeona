<?php
    if (isset($_POST['Email']) && isset($_POST['Mdp'])) {
        $user = new App\Table\User();
        $result = App\Table\User::findByUsername($_POST['Email']);
        if (isset($result)) {
            $user->setUsername($result->Email);
            $user->setPassword($result->MdpHash);

            if (password_verify($_POST['Mdp'], $user->getPassword())) {
                $_SESSION['user'] = [
                    'id' => $result->Id,
                    'username' => $user->getUsername()
                ];
        
                header("location:Index.php?p=home");
            } else {
                $errors = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        }
    }
?>

<div class="text-center bg-full-image">
    <div class="pt-5">
        <div class="form-signin bg-light w-100 m-auto mt-5 rounded-2">
            <img id="logo-login" src="../public/images/logo.png" class="mb-4" alt="logo" />
            <form class="mt-2" method="POST" action="">
                <h1 class="h3 mb-3 fw-normal"><?= $lang['Lbl_LoginTitre']; ?></h1>

                <div class="form-floating mb-2">
                    <input type="email" id="Email" name="Email" class="form-control" placeholder="name@example.com">
                    <label for="Email"><?= $lang['Tbx_Identifiant'] ?></label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" id="Mdp" name="Mdp" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="Mdp"><?= $lang['Tbx_Mdp'] ?></label>
                </div>

                <?php if(!empty($errors)): ?>
                    <div class="text-danger">
                        <?= $errors; ?>
                    </div>
                <?php endif; ?>

                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="remember-me"> <?= $lang['Chkbx_ConditionUtilisation'] ?>
                    </label>
                </div>

                <div class="form-floating mb-3 pb-4">
                    <a href="#" class="nav-link"><?= $lang['Lnk_MdpOublie'] ?></a>
                </div>
                <button class="w-100 btn btn-lg btn-bs-primary" type="submit"><?= $lang['Btn_Connecter'] ?></button>
            </form>
        </div>
    </div>
</div>