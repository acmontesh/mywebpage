
<main>
        <h1>Update</h1>
        <div class="contenedor">

        <?php
            showErrors($errorMessages);
            $pform = "update";
            include __DIR__ . '/form_template.php';
        ?>
        
            <div class="goback">
                    <a href="/admin" class="boton", id="back">Go Back</a>
                </div>
        </div>
    </main>