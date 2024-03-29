<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abraham Montes-Humanez</title>
    <link rel="stylesheet" href="/build/css/app.css">
                                        
</head>
<body>
    <header class="<?php echo $inicio ? 'main-header' : 'second-header'; ?>">
        <div class="<?php echo $inicio ? 'contenedor-header' : 'contenedor-header-generico' ?>">
            <h1 class="header-title <?php echo $inicio ? 'pop-in-animation' : 'generic' ?>" >Abraham Montes</h1>
            <h2 class="header-subtitle <?php echo $inicio ? 'pop-in-animation' : 'generic' ?>" >Drilling Automation Researcher</h2>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin <?php echo $inicio ? 'pop-in-animation' : 'generic' ?>" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#d6c97c" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <circle cx="12" cy="11" r="3" />
                <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                </svg>
            <p class="<?php echo $inicio ? 'pop-in-animation' : 'generic' ?> header-location">Austin, TX</p>         
        </div>
        <?php
            if ($inicio)
                echo <<<arrowdown
                    <div class="header-down-arrow">
                    <img src="build/img/chevron.svg" width="50" alt="flecha" id="flecha">
                    </div>
                arrowdown;
        ?>
    </header>   
    