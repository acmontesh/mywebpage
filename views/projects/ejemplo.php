<!-- project -->
<?php if ($pform === "create" || ($pform === "update" && $tname === "research_projects")) { ?>
<div class="enclosed-box menu-admin">
    <div class="headline-expandable-box">
        <h2><?php echo $pform === 'create' ? 'Create Project' : 'Update Project' ?></h2>
        <div class="expand-info mas"></div>
    </div>
    <div class="<?php echo $pform === 'create' ? 'contenido-expandable-box' : '' ?>">
        <form class="formulario" method="POST" enctype="multipart/form-data">
            <label for="title_project">Project Title</label>
            <input type="text" name="title_project" placeholder="Project Title" id="title_project"
                value="<?php echo isset($instance->valuesArray['title_project']) ? s($instance->valuesArray['title_project']) : '' ?>"/>

            <label for="headline_project">Headline</label>
            <textarea name="headline_project" id="headline_project" cols="30" rows="5"><?php echo isset($instance->valuesArray['headline_project']) ? s($instance->valuesArray['headline_project']) : '' ?></textarea>
            
            <label for="abstract_project">Abstract</label>
            <textarea name="abstract_project" id="abstract_project" cols="30" rows="10"><?php echo isset($instance->valuesArray['abstract_project']) ? s($instance->valuesArray['abstract_project']) : '' ?></textarea>

            <label for="imagen_project">Image</label>
            <input type="file" id="imagen_project" name="imagen_project" accept="image/jpeg, image/png, image/webp"/>

            <!-- In case it is an update form, must load the image from the database. -->
            <?php
            if ($pform === "update") {
                $img = $instance->valuesArray['imagen_project'];
                echo "<img src='/images/$img' alt='image project' class='imagen-small'>";
            } ?>
            
            <label>Related Publications</label>
            <select name="publications_project" id="publications_project">
                <option value="">--Select--</option>
                
            </select>

            <input type="hidden" name="form_name" value="project">

            <input type="submit" value="<?php echo $pform === 'create' ? 'Create Project' : 'Update Record' ?>"/>                        
        </form> 
    </div>               
</div> <?php } ?>