<main>
    <h2><?php echo $instance->valuesArray["title_blog"] ?></h2>
    <div class="blog-head">
        <img src="/images/<?php echo $instance->valuesArray["imagen_blog"] ?>">
        <div class="blog-info">
            <p><span>Author: </span>Abraham Montes</p>
            <p><span>Date: </span><?php echo $instance->valuesArray["date_blog"] ?></p>
            <p><span>Time to Read: </span><?php echo $instance->valuesArray["ttr_blog"] ?> min</p>
            <form id="formArticle" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="title_blog" value="<?php echo $instance->valuesArray["title_blog"] ?>" >
                <input type="hidden" name="headline_blog" value="<?php echo $instance->valuesArray["headline_blog"] ?>">
                <input type="hidden" name="coauthors_blog" value="<?php echo $instance->valuesArray["coauthors_blog"] ?>">
                <input type="hidden" name="date_blog" value="<?php echo $instance->valuesArray["date_blog"] ?>">
                <input type="hidden" name="imagen_blog" value="<?php echo $instance->valuesArray["imagen_blog"] ?>">
                <input type="hidden" name="article_blog" value="<?php echo $instance->valuesArray["article_blog"] ?>">
                <input type="hidden" name="ttr_blog" value=<?php echo $instance->valuesArray["ttr_blog"] ?>>
                <input type="hidden" id="likes_blog" name="likes_blog" value=<?php echo $instance->valuesArray["likes_blog"]?>>
            </form>
            <div class="likes-count <?php echo $heart ?>">
                <div id="likes-count-child">
                    <p><?php echo $instance->valuesArray["likes_blog"] ?></p>
                </div>
            </div>
        </div>
        
    </div>
    <div class="enclosed-box">
        <?php
        $fn = $instance->valuesArray["article_blog"];
        $mapFile = fopen("../public/texts/$fn", 'r'); 
        while ($line = fread($mapFile, filesize("../public/texts/$fn")))
        {
            echo $line;
        }
        ?>
    </div>
    <div class="goback">
        <a href="/" class="boton", id="back">Go Back</a>
    </div>
</main>