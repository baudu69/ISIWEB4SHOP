<h2>Inscription</h2>
<form method="post" action="?action=postInscription">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" id="username"/>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" id="password" />
    </div>
    <div class="form-group">
        <label for="password1">Confirm password</label>
        <input type="password" class="form-control" name="password1" id="password1" />
    </div>

    <button type="submit" id="valider" value="">S'inscrire</button>
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