{* SMARTY *}

<footer>
    <div class="container margin_60_35">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <p>
                    <a href="index.html" title="Findoctor">
                        <img src="{$imgPath}logo.png" data-retina="true" alt="" width="163" height="36"
                             class="img-fluid">
                    </a>
                </p>
            </div>
            <div class="col-lg-3 col-md-4">
                <h5>{constant("FOOTER_ABOUT")}</h5>
                <ul class="links">
                    <li><a href="#0">{constant("FOOTER_ABOUTUS")}</a></li>
                    <li><a href="blog.html">{constant("FOOTER_BLOG")}</a></li>
                    <li><a href="#0">{constant("FOOTER_FAQ")}</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h5>{constant("FOOTER_USEFUL_LINKS")}</h5>
                <ul class="links">
                    <li><a href="#0">{constant("FOOTER_DOCTORS")}</a></li>
                    <li><a href="#0">{constant("FOOTER_CLINICS")}</a></li>
                    <li><a href="#0">{constant("FOOTER_SPECIALIZATION")}</a></li>
                    <li><a href="signup">{constant("FOOTER_JOIN_AS_DOCTOR")}</a></li>
                    <li><a href="#0">{constant("FOOTER_DOWNLOADAPP")}</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h5>Contact with Us</h5>
                <ul class="contacts">
                    <li><a href="tel://{$contact.mobile}"><i class="icon_mobile"></i> {$contact.mobile}</a></li>
                    <li><a href="mailto:{$contact.email}"><i class="icon_mail_alt"></i> {$contact.email}</a></li>
                </ul>
                <div class="follow_us">
                    <h5>Follow us</h5>
                    <ul>
                        <li><a target='_blank' href="{$socialmedia.facebook}"target='_blank' ><i class="social_facebook"></i></a></li>
                        <li><a target='_blank' href="{$socialmedia.twitter}"><i class="social_twitter"></i></a></li>
                        <li><a target='_blank' href="{$socialmedia.linkedin}"><i class="social_linkedin"></i></a></li>
                        <li><a target='_blank' href="{$socialmedia.instagram}"><i class="social_instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/row-->
        <hr>
        <div class="row">
            <div class="col-md-8">
                <ul id="additional_links">
                    <li><a href="#0">Terms and conditions</a></li>
                    <li><a href="#0">Privacy</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <div id="copy">© {'Y'|date} {$name}</div>
            </div>
        </div>
    </div>
</footer>
<!--/footer-->

<div id="toTop"></div>
<!-- Back to top button -->

<!-- COMMON SCRIPTS -->
<script src="{$jsPath}jquery-2.2.4.min.js"></script>
<script src="{$jsPath}common_scripts.min.js"></script>
<script src="{$jsPath}functions.js"></script>
<script src="{$jsPath}custom.js"></script>
<script src="{$jsPath}jquery.cookiebar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

<!-- Scripts -->
{include file= "template/jqueryScripts.tpl"}