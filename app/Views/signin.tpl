{* SMARTY *}

{extends "template/maintemplate.tpl"}

{block name=content}
    <main>
        <div class="bg_color_2">
            <div class="container margin_60_35">
                <div id="login-2">
                    <h1>{constant("SIGNIN_PLACEHOLDER")}</h1>
                    <form method="post" class="ajaxForm" data-loader="loginLoader" data-url="{$siteurl}signinConfirm">
                        <div class="box_form clearfix">
                            <div class="box_login">
                                <a onclick="alert('not available!'); return false;" href="#0"
                                   class="social_bt facebook">Login
                                    with Facebook</a>
                                <a onclick="alert('not available!'); return false;" href="#0" class="social_bt google">Login
                                    with Google</a>
                                <a onclick="alert('not available!'); return false;" href="#0"
                                   class="social_bt linkedin">Login
                                    with Linkedin</a>
                            </div>
                            <div class="box_login last">
                                <div id="loginLoader"></div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control"
                                           placeholder="{constant("SIGNIN_EMAIL")}">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control"
                                           placeholder="{constant("SIGNIN_PASSWORD")}">
                                    <a href="#0" class="forgot">
                                        <small>{constant("SIGNIN_FORGOT")}</small>
                                    </a>
                                </div>
                                <div class="form-group">
                                    <button class="btn_1" type="submit">{constant("SIGNIN_SUBMIT")}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p class="text-center link_bright">{constant("SIGNIN_NOACCOUNT")}
                        <a href="/signup"><strong>{constant("SIGNUP_SUBMIT")}!</strong></a>
                    </p>
                </div>
                <!-- /login -->
            </div>
        </div>
    </main>
    <!-- /main -->
{/block}