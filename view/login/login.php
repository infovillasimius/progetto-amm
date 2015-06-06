<div class="login">
    <h2>
        Login Operatore
    </h2>
    
    <form class="login" method="post" action="index.php?page=login">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" />
        <br/>
        <br/>
        <label for="password">Password</label>
        <input type="password" id="password" name="password"/>
        <br/>
        <br/>
        <button type="submit" id="invioLogin">Login</button>
    </form>
    <p><?php echo $pagina->getMsg(); ?></p>
</div>


