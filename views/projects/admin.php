<?php
use function Model\showProjects;
?>
<main>
        <h1>DB Administration</h1>
        <div class="contenedor">
        <?php
            if (isset($ins)) {
                showMsg($ins, "creation");
            }
            if (isset($upd)) {
                showMsg($upd, "update");
            }
            if (isset($dls)) {
                showMsg($dls, "delete");
            }
        ?>
            <div class="enclosed-box menu-admin">
                <div class="admin-panel">
                    <a href="/projects/crear" class="boton" id="boton-crear">Create New</a>

                    <?php
                    foreach ($responses as $idx => $res): ?>
                        <h2><?php echo classList[$idx] . "s"; ?></h2>
                        <table class="table-projects">
                            <?php 
                                showProjects($res);
                            ?>
                        </table>
                        <?php 
                        echo "<div class='bar'></div>";
                    endforeach; ?>
                    
                </div>
                
            </div>

            <div class="goback">
                <a href="/logout" class="boton red-botton", id="logoff">Log Off</a>
            </div>
        </div>
    </main>