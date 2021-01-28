<h2>Connexion</h2>
<form method="post" action="?action=postConnection">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" id="username"/>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" id="password" />
    </div>
    <input type="submit" value="Se connecter" />
    <?php if (isset($message)) echo $message; ?>
</form>