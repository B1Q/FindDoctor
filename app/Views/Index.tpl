{extends "template/maintemplate.tpl"}

{block name=content}
<main>

    {* Include Templates here Instead of having a lot of elements in 1 file *}
    <div class="hero_home version_1">
        <div class="content">
            <h3>Find a Doctor!</h3>
            <p>
                Ridiculus sociosqu cursus neque cursus curae ante scelerisque vehicula.
            </p>
        </div>
    </div>
    <!-- /Hero -->

    <div class="container margin_120_95">
        <div class="main_title">
            <h2>Discover the <strong>online</strong> appointment!</h2>
            <p>Usu habeo equidem sanctus no. Suas summo id sed, erat erant oporteat cu pri. In eum omnes molestie. Sed
                ad debet scaevola, ne mel.</p>
        </div>
        <div class="row add_bottom_30">
            <div class="col-lg-4">
                <div class="box_feat" id="icon_1">
                    <span></span>
                    <h3>Find a Doctor</h3>
                    <p>Usu habeo equidem sanctus no. Suas summo id sed, erat erant oporteat cu pri. In eum omnes
                        molestie.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="box_feat" id="icon_2">
                    <span></span>
                    <h3>View profile</h3>
                    <p>Usu habeo equidem sanctus no. Suas summo id sed, erat erant oporteat cu pri. In eum omnes
                        molestie.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="box_feat" id="icon_3">
                    <h3>Book a visit</h3>
                    <p>Usu habeo equidem sanctus no. Suas summo id sed, erat erant oporteat cu pri. In eum omnes
                        molestie.</p>
                </div>
            </div>
        </div>
        <!-- /row -->
        <p class="text-center"><a href="list.html" class="btn_1 medium">Find Doctor</a></p>

    </div>
    <!-- /container -->

    <div class="bg_color_1">
        <div class="container margin_120_95">
            <div class="main_title">
                <h2>Most Viewed doctors</h2>
                <p>Usu habeo equidem sanctus no. Suas summo id sed, erat erant oporteat cu pri.</p>
            </div>
            <div id="reccomended" class="owl-carousel owl-theme">
                <div class="item">
                    <a href="detail-page.html">
                        <div class="views"><i class="icon-eye-7"></i>140</div>
                        <div class="title">
                            <h4>Dr. Julia Holmes<em>Pediatrician - Cardiologist</em></h4>
                        </div>
                        <img src="http://via.placeholder.com/350x500.jpg" alt="">
                    </a>
                </div>
                <div class="item">
                    <a href="detail-page.html">
                        <div class="views"><i class="icon-eye-7"></i>120</div>
                        <div class="title">
                            <h4>Dr. Julia Holmes<em>Pediatrician</em></h4>
                        </div>
                        <img src="http://via.placeholder.com/350x500.jpg" alt="">
                    </a>
                </div>
                <div class="item">
                    <a href="detail-page.html">
                        <div class="views"><i class="icon-eye-7"></i>115</div>
                        <div class="title">
                            <h4>Dr. Julia Holmes<em>Pediatrician</em></h4>
                        </div>
                        <img src="http://via.placeholder.com/350x500.jpg" alt="">
                    </a>
                </div>
                <div class="item">
                    <a href="detail-page.html">
                        <div class="views"><i class="icon-eye-7"></i>98</div>
                        <div class="title">
                            <h4>Dr. Julia Holmes<em>Pediatrician</em></h4>
                        </div>
                        <img src="http://via.placeholder.com/350x500.jpg" alt="">
                    </a>
                </div>
                <div class="item">
                    <a href="detail-page.html">
                        <div class="views"><i class="icon-eye-7"></i>98</div>
                        <div class="title">
                            <h4>Dr. Julia Holmes<em>Pediatrician</em></h4>
                        </div>
                        <img src="http://via.placeholder.com/350x500.jpg" alt="">
                    </a>
                </div>
            </div>
            <!-- /carousel -->
        </div>
        <!-- /container -->
    </div>
    <!-- /white_bg -->


    <div id="app_section">
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-md-5">
                    <p><img src="{$imgPath}app_img.svg" alt="" class="img-fluid" width="500" height="433"></p>
                </div>
                <div class="col-md-6">
                    <small>Application</small>
                    <h3>Download <strong>Findoctor App</strong> Now!</h3>
                    <p class="lead">Tota omittantur necessitatibus mei ei. Quo paulo perfecto eu, errem percipit
                        ponderum no eos. Has eu mazim sensibus. Ad nonumes dissentiunt qui, ei menandri electram eos.
                        Nam iisque consequuntur cu.</p>
                    <div class="app_buttons wow" data-wow-offset="100">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             x="0px" y="0px" viewBox="0 0 43.1 85.9" style="enable-background:new 0 0 43.1 85.9;"
                             xml:space="preserve">
							<path stroke-linecap="round" stroke-linejoin="round" class="st0 draw-arrow"
                                  d="M11.3,2.5c-5.8,5-8.7,12.7-9,20.3s2,15.1,5.3,22c6.7,14,18,25.8,31.7,33.1"/>
                            <path stroke-linecap="round" stroke-linejoin="round" class="draw-arrow tail-1"
                                  d="M40.6,78.1C39,71.3,37.2,64.6,35.2,58"/>
                            <path stroke-linecap="round" stroke-linejoin="round" class="draw-arrow tail-2"
                                  d="M39.8,78.5c-7.2,1.7-14.3,3.3-21.5,4.9"/>
						</svg>
                        <a href="#0" class="fadeIn"><img src="{$imgPath}apple_app.png" alt="" width="150" height="50"
                                                         data-retina="true"></a>
                        <a href="#0" class="fadeIn"><img src="{$imgPath}google_play_app.png" alt="" width="150"
                                                         height="50" data-retina="true"></a>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /app_section -->
</main>
<!-- /main content -->
{/block}