<main>
    <h1>Log In</h1>

    <div class="contenedor">
        <?php foreach($errores as $error): ?>
        <div class="alert errormsg"><?php echo $error; ?></div>
        <?php endforeach; ?>

        <div class="enclosed-box">

            <form method="POST" class="formulario" action="/login">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email"> 

                <label for="password">Password:</label>
                <input type="password" name="password" id="password"> 

                <input type="submit" value="login" class="boton">                   

            </form>
        </div>
    </div>
</main>