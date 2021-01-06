<h2>Inscription</h2>
<form method="post" action="?action=postInscription">
    <label for="username">Username</label>
    <input type="text" name="username" id="username"/>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" />
    <label for="password1">Confirm password</label>
    <input type="password" name="password1" id="password1" />
    <button type="submit" id="valider" value="">Se connecter</button>
    <?php if (isset($message)) echo $message; ?>
</form>
<script src="js/jquery.min.js"></script>
<script>
    $( document ).ready(function() {
        $('#password, #password1').on('keyup', function () {
            if ($('#password').val() === $('#password1').val()) {
                $('#valider').attr("disabled",false);
            } else
                $('#valider').attr('disabled', true);
        });
    });
</script>