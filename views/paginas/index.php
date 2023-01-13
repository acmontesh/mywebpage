<?php
use function Model\includeInfoMain;
?>

<main>
        
        <section class="about-me contenedor">
            
            <h1 class="titulo-about-me show-on-scroll menu-target">About Me</h1>
            <div class="about-me-intro">
                <picture class="about-me-photo">
                    <source srcset="build/img/fotofinal.webp" type="image/webp">
                    <source srcset="build/img/fotofinal.png" type="image/png">
                    <img src="build/img/fotofinal.png" alt="fotofinal">
                </picture>
                <p>
                    <span>Welcome!</span><br> I am Abraham. Engineering researcher, Ph.D. 
                    student and statistics and web development enthusiast. Please find below some highlights from my CV.              
                </p>
            </div> 

            <div class="navegacion show-on-click">    
                <a class="menu-item" id="menu-about-me">About Me</a>
                <a class="menu-item" id="menu-research">My Research</a>
                <a class="menu-item" id="menu-blog">Blog</a>
                <a class="menu-item" id="menu-quotes">Quotes I Like</a>
                <a class="menu-item" id="menu-contact">Contact</a>        
            </div>

            <div class="hamburguesa show-on-scroll">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="44" height="44" viewBox="0 0 24 24" stroke-width="3" stroke="#d6c97c" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <line x1="4" y1="6" x2="20" y2="6" />
                    <line x1="4" y1="12" x2="20" y2="12" />
                    <line x1="4" y1="18" x2="20" y2="18" />
                    </svg>
            </div>
            
            <div class="contenedor-about-me">
                <div class="about-me-education seccion-about-me">
                    <h2>Education</h2>
                    <?php includeInfoMain("education", $degrees); ?>
                </div>
                
                <div class="about-me-experience seccion-about-me">
                    <h2>Experience</h2>
                    <?php includeInfoMain( "experience", $jobs ); ?>    
                </div>

                <div class="about-me-awards seccion-about-me">
                    <h2>Awards</h2>
                    <?php includeInfoMain( "awards", $awards ); ?>    
                </div>

                <div class="about-me-publications seccion-about-me">
                    <h2>Publications</h2>
                    <?php includeInfoMain( "publications", $publications ); ?>    
                </div>

                
            </div>

            <div class="contenedor-about-me">
                <h3>Would you like more information? Please visit my complete CV:</h3>
                <a href="/curriculum" class="boton">My Complete CV</a>
            </div>
     
        </section>

        


        <section class="marquee">
            <div class="marquee-image second-marquee">
                <img src="build/img/quotemark.svg" alt="comma" class="comma">
                <div class="marquee-text show-on-scroll">
                
                    <p>There is no delight in <br> owning anything unshared.
                        <br><br><span> - Lucius Seneca</span>
                    </p>
                </div>
            </div>
        </section>

        
        <section class="research contenedor">
            <h1 class="titulo-research show-on-scroll  menu-target">My Research</h1>
            <div class="research-projects-container">
            <?php includeInfoMain( "research_projects", $projects ); ?> 
            </div>
        </section>

        <section class="marquee">
            <div class="marquee-image first-marquee">
                <img src="build/img/quotemark.svg" alt="comma" class="comma">
                <div class="marquee-text show-on-scroll">
                    <p>Scientific research is one of the most <br> exciting and rewarding of occupations. <br>
                        It should appeal to those with <br> a good sense of adventure.
                        <br><br><span> - Frederick Sanger</span>
                    </p>
                </div>
            </div>
        </section>

        <section class="blog">
            <h1 class="titulo-blog show-on-scroll  menu-target">Blog</h1>
            <div class="container-blog contenedor">
                <div class="blog-entries">      
                <?php includeInfoMain( "blog", $blogs ); ?> 
                </div>
    
                <div class="blog-quotes enclosed-box">
                    <h2 class="menu-target">Quotes I Like</h2>
                    <div class="quotes-container">
                    <?php includeInfoMain( "quotes", $quotes ); ?> 
                    </div>
                    <div class="quotes-pips">
                        <ul>
                        </ul>
                    </div>
                </div>
            </div>
            
        </section>

        <section class="animated-marquee">
            <div class="animacion">
                <div class="fondo"></div>
                <div class="sun"></div>
                <div class="rig"></div>
                <div class="nubes"></div>
                <!-- <div class="marquee-quote"><p>The common man is not concerned
                about the passage of time, the man of
                talent is driven by it.<br><br>
                <span>- A. Shoppenhauer</span></p></div> -->
            </div>
        </section>

        <section class="contact">
            <h1 class="titulo-contacto show-on-scroll menu-target">Contact Me</h1>
            <div class="contenedor enclosed-box contenedor-form">
                <h2>Please Fill the Contact Form:</h2>    
                <form class="formulario" method="POST" action="/">
                        <label for="name">Name</label>
                        <input type="text" placeholder="Your Name" id="name" name="name" required/>

                        <label for="email">Email adress</label>
                        <input type="email" placeholder="Your Email Address" id="email" name="email" required/>
                        
                        <label for="message">Message</label>
                        <textarea name="message" id="message" cols="30" rows="10" placeholder="Your Message"></textarea>
                        
                        <input type="submit" value="Send"/>
                </form>
            </div>
        </section>
    </main>