<?php
use function Model\s;
use function Model\debugChunk;
?>

<!-- project -->
<?php if($pform==="create" || ($pform==="update" && $tname==="research_projects")) { ?>
<div class="enclosed-box menu-admin">
    <div class="headline-expandable-box">
        <h2><?php echo $pform==='create' ? 'Create Project' : 'Update Project'?></h2>
        <div class="expand-info mas"></div>
    </div>
    <div class="<?php echo $pform==='create' ? 'contenido-expandable-box' : ''?>">
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
            }                   ?>
            
            <label>Related Publications</label>
            <select name="publications_project" id="publications_project">
                <option value="">--Select--</option>
                <?php
                foreach($publications as $publ) {
                    $nameBuffer = $publ->valuesArray['title_publication'];
                    $idBuffer = $publ->valuesArray['id'];
                    $idPost = $instance->valuesArray['publications_project'];
                    echo "<option value=$idBuffer" ?> <?php echo $idBuffer==$idPost ? 'selected' : ''?>
                    <?php echo ">$nameBuffer</option>";
                }
                
                ?>
            </select>

            <input type="hidden" name="form_name" value="project">

            <input type="submit" value="<?php echo $pform==='create' ? 'Create Project' : 'Update Record'?>"/>                        
        </form> 
    </div>               
</div>

<!-- blog -->
<?php }; if($pform==="create" || ($pform==="update" && $tname==="blog")) { ?>
<div class="enclosed-box menu-admin">
    <div class="headline-expandable-box">
        <h2><?php echo $pform==='create' ? 'Create Blog Entry' : 'Update Blog Entry'?></h2>
        <div class="expand-info mas"></div>
    </div>
    <div class="<?php echo $pform==='create' ? 'contenido-expandable-box' : ''?>">
        <form class="formulario" method="POST" enctype="multipart/form-data">
            <label for="title_blog">Article Title</label>
            <input type="text" name="title_blog" placeholder="Article Title" id="title_blog"
                value="<?php echo isset($instance->valuesArray['title_blog']) ? s($instance->valuesArray['title_blog']) : '' ?>"/>

            <label for="headline_blog">Headline</label>
            <textarea name="headline_blog" id="headline_blog" cols="30" rows="5"><?php echo isset($instance->valuesArray['headline_blog']) ? s($instance->valuesArray['headline_blog']) : '' ?></textarea>
            
            <label for="article_blog">Article</label>
            <input type="file" id="article_blog" name="article_blog" accept=".txt"/>

            <!-- In case it is an update form, must load the preview of the article. -->
            <?php 
            if ($pform === "update") {
                $txt = $instance->valuesArray['article_blog'];
                echo "<h3>Article Preview</h3>";
                echo "<textarea class='article-preview' readonly>";
                $lines = file("../public/texts/$txt"); 
                foreach ($lines as $line_num => $line) {
                    echo htmlspecialchars($line) . "\n";
                }
                echo "</textarea>";
            }                   ?>

            <label for="imagen_blog">Image</label>
            <input type="file" id="imagen_blog" name="imagen_blog" accept="image/jpeg, image/png, image/webp"/>

            <!-- In case it is an update form, must load the image from the database. -->
            <?php 
            if ($pform === "update") {
                $img = $instance->valuesArray['imagen_blog'];
                echo "<img src='/images/$img' alt='image project' class='imagen-small'>";
            }                   ?>
            
            <label>Coauthor</label>
            <select name="coauthors_blog" id="coauthors_blog">
                <option value="">--Select--</option>
                <?php                    
                    foreach($contributors as $contributor) {
                        $nameBuffer = $contributor->valuesArray['name_contributor'];
                        $idBuffer = $contributor->valuesArray['id'];
                        $idPost = $instance->valuesArray['coauthors_blog'];
                        echo "<option value=$idBuffer" ?> <?php echo $idBuffer==$idPost ? 'selected' : ''?>
                        <?php echo ">$nameBuffer</option>";
                    }
                
                ?>
            </select>

            <label for="ttr_blog">Time to Read</label>
            <input type="number" name="ttr_blog" id="ttr_blog" placeholder="Time to read in minutes"
                value="<?php echo isset($instance->valuesArray['ttr_blog']) ? s($instance->valuesArray['ttr_blog']) : '' ?>"/>
            <input type="hidden" name="date_blog" value="<?php echo $instance->valuesArray["date_blog"] ?>">
            <input type="hidden" id="likes_blog" name="likes_blog" value=<?php echo $instance->valuesArray["likes_blog"]?>>
            <input type="hidden" name="form_name" value="blog">

            <input type="submit" value="<?php echo $pform==='create' ? 'Create Blog Entry' : 'Update Record'?>"/>                        
        </form> 
    </div>               
</div>

<!-- quote -->
<?php };
    if($pform==="create" || ($pform==="update" && $tname==="quotes")) { ?>
<div class="enclosed-box menu-admin">
    <div class="headline-expandable-box">
        <h2><?php echo $pform==='create' ? 'Create Quote' : 'Update Quote'?></h2>
        <div class="expand-info mas"></div>
    </div>
    <div class="<?php echo $pform==='create' ? 'contenido-expandable-box' : ''?>">
        <form class="formulario" method="POST" enctype="multipart/form-data">

            <label for="text_quote">Quote</label>
            <textarea name="text_quote" id="text_quote" cols="30" rows="5"><?php echo isset($instance->valuesArray['text_quote']) ? s($instance->valuesArray['text_quote']) : '' ?></textarea>
            
            <label for="author_quote">Author</label>
            <input type="text" name="author_quote" placeholder="Author Name" id="author_quote"
                value="<?php echo isset($instance->valuesArray['author_quote']) ? s($instance->valuesArray['author_quote']) : '' ?>"/>

            <label for="imagen_quote">Author Picture</label>
            <input type="file" id="imagen_quote" name="imagen_quote" accept="image/jpeg, image/png, image/webp"/>

            <!-- In case it is an update form, must load the image from the database. -->
            <?php 
            if ($pform === "update") {
                $img = $instance->valuesArray['imagen_quote'];
                echo "<img src='/images/$img' alt='image project' class='imagen-small'>";
            }                   ?>

            <input type="hidden" name="form_name" value="quote">

            <input type="submit" value="<?php echo $pform==='create' ? 'Create Quote' : 'Update Record'?>"/>                        
        </form> 
    </div>               
</div>

<!-- publication -->
<?php };
    if($pform==="create" || ($pform==="update" && $tname==="publications")) { ?>
<div class="enclosed-box menu-admin">
    <div class="headline-expandable-box">
        <h2><?php echo $pform==='create' ? 'Create Publication' : 'Update Publication'?></h2>
        <div class="expand-info mas"></div>
    </div>
    <div class="<?php echo $pform==='create' ? 'contenido-expandable-box' : ''?>">
        <form class="formulario" method="POST">

            <label for="title_publication">Publication Title</label>
            <input type="text" name="title_publication" placeholder="Project Title" id="title_publication"
                value="<?php echo isset($instance->valuesArray['title_publication']) ? s($instance->valuesArray['title_publication']) : '' ?>"/>

            <label for="comment_publication">Publication Comment</label>
            <textarea name="comment_publication" id="comment_publication" cols="30" rows="5"><?php echo isset($instance->valuesArray['comment_publication']) ? s($instance->valuesArray['comment_publication']) : '' ?></textarea>

            <label for="journal_publication">Publication Journal or Conference</label>
            <input type="text" name="journal_publication" placeholder="Journal or Conference" id="journal_publication"
                value="<?php echo isset($instance->valuesArray['journal_publication']) ? s($instance->valuesArray['journal_publication']) : '' ?>"/>

            <input type="hidden" name="form_name" value="publication">

            <input type="submit" value="<?php echo $pform==='create' ? 'Create Publication' : 'Update Record'?>"/>                        
        </form> 
    </div>               
</div>

<!-- degree -->
<?php };
if($pform==="create" || ($pform==="update" && $tname==="education")) { ?>
<div class="enclosed-box menu-admin">
    <div class="headline-expandable-box">
        <h2><?php echo $pform==='create' ? 'Create Education Entry' : 'Update Education Entry'?></h2>
        <div class="expand-info mas"></div>
    </div>
    <div class="<?php echo $pform==='create' ? 'contenido-expandable-box' : ''?>">
        <form class="formulario" method="POST">

            <label for="title_degree">Title</label>
            <input type="text" name="title_degree" placeholder="Degree Title" id="title_degree"
                value="<?php echo isset($instance->valuesArray['title_degree']) ? s($instance->valuesArray['title_degree']) : '' ?>"/>

            <label for="institution_degree">Institution</label>
            <input type="text" name="institution_degree" placeholder="Institution Name" id="institution_degree"
                value="<?php echo isset($instance->valuesArray['institution_degree']) ? s($instance->valuesArray['institution_degree'] ): '' ?>"/>

            <label for="city_degree">City</label>
            <input type="text" name="city_degree" placeholder="City" id="city_degree"
                value="<?php echo isset($instance->valuesArray['city_degree']) ? s($instance->valuesArray['city_degree']) : '' ?>"/>

            <label for="date_degree">Date of awardness</label>
            <input type="date" name="date_degree" id="date_degree" value="<?php echo isset($instance->valuesArray['date_degree']) ? date($instance->valuesArray['date_degree']) : '' ?>"/>

            <input type="hidden" name="form_name" value="degree">

            <input type="submit" value="<?php echo $pform==='create' ? 'Create Education Entry' : 'Update Record'?>"/>                        
        </form> 
    </div>               
</div>

<!-- contributor -->
<?php };
if($pform==="create" || ($pform==="update" && $tname==="blog_contributors")) { ?>
<div class="enclosed-box menu-admin">
    <div class="headline-expandable-box">
        <h2><?php echo $pform==='create' ? 'Create Blog Contributor' : 'Update Blog Contributor'?></h2>
        <div class="expand-info mas"></div>
    </div>
    <div class="<?php echo $pform==='create' ? 'contenido-expandable-box' : ''?>">
        <form class="formulario" method="POST">

            <label for="name_contributor">Contributor Name</label>
            <input type="text" name="name_contributor" placeholder="Contributor Name" id="name_contributor"
                value="<?php echo isset($instance->valuesArray['name_contributor']) ? s($instance->valuesArray['name_contributor'] ): '' ?>"/>

            <input type="hidden" name="form_name" value="contributor">

            <input type="submit" value="<?php echo $pform==='create' ? 'Create Contributor' : 'Update Record'?>"/>                        
        </form> 
    </div>               
</div>

<!-- job -->
<?php };
    if($pform==="create" || ($pform==="update" && $tname==="experience")) { ?>
<div class="enclosed-box menu-admin">
    <div class="headline-expandable-box">
        <h2><?php echo $pform==='create' ? 'Create Experience' : 'Update Experience'?></h2>
        <div class="expand-info mas"></div>
    </div>
    <div class="<?php echo $pform==='create' ? 'contenido-expandable-box' : ''?>">
        <form class="formulario" method="POST">

            <label for="position_job">Position Name</label>
            <input type="text" name="position_job" placeholder="Position Title" id="position_job" 
                value="<?php echo isset($instance->valuesArray['position_job']) ? s($instance->valuesArray['position_job'] ): '' ?>"/>
                
            <label class="radio-current">
                <label>Current</label>
                <input type="radio" name="current_job" value="T" />   
                <label>Previous</label>                     
                <input type="radio" name="current_job" value="F" />
            </label>

            <label for="duration_job">Years Duration</label>
            <input type="number" step="0.1" name="duration_job" placeholder="Duration in Years" id="duration_job" value="<?php echo isset($instance->valuesArray['duration_job']) ? $instance->valuesArray['duration_job'] : '' ?>"/>                        
            <label for="company_job">Company</label>
            <input type="text" name="company_job" placeholder="Company Name" id="company_job" value="<?php echo isset($instance->valuesArray['company_job']) ? s( $instance->valuesArray['company_job'] ) : '' ?>"/>
            <label for="description_job">Job Description</label>
            <textarea name="description_job" id="description_job" cols="30" rows="5"><?php echo isset($instance->valuesArray['description_job']) ? s( $instance->valuesArray['description_job'] ) : '' ?></textarea>

            <input type="hidden" name="form_name" value="job">

            <input type="submit" value="<?php echo $pform==='create' ? 'Create Job' : 'Update Record'?>"/>                        
        </form> 
    </div>               
</div>

<!-- award -->
<?php };
    if($pform==="create" || ($pform==="update" && $tname==="awards")) { ?>
<div class="enclosed-box menu-admin">
    <div class="headline-expandable-box">
        <h2><?php echo $pform==='create' ? 'Create Award' : 'Update Award'?></h2>
        <div class="expand-info mas"></div>
    </div>
    <div class="<?php echo $pform==='create' ? 'contenido-expandable-box' : ''?>">
        <form class="formulario" method="POST">

            <label for="name_award">Award Name</label>
            <input type="text" name="name_award" placeholder="Award Name" id="name_award"
                value="<?php echo isset($instance->valuesArray['name_award']) ? $instance->valuesArray['name_award'] : '' ?>"/>
            <label for="granter_award">Award Granter</label>
            <input type="text" name="granter_award" placeholder="Granter Name" id="granter_award"
                value="<?php echo isset($instance->valuesArray['granter_award']) ? $instance->valuesArray['granter_award'] : '' ?>"/>
            <label for="date_award">Date of awardness</label>
            <input type="date" name="date_award" id="date_award" value="<?php echo isset($instance->valuesArray['date_award']) ? date($instance->valuesArray['date_award']) : '' ?>"/>

            <input type="hidden" name="form_name" value="award">

            <input type="submit" value="<?php echo $pform==='create' ? 'Create Award' : 'Update Record'?>"/>                        
        </form> 
    </div>               
</div>

<?php }  ?>