{* SMARTY *}
{extends "template/maintemplate.tpl"}

{block name=content}
    <main>
        <div class="bg_color_2">
            <div class="container margin_60_35">
                <div id="register">
                    <h1>Please register to Findoctor!</h1>
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <form method="post" class="ajaxForm"
                                  data-loader="signUploader"
                                  data-url="{$siteurl}signupConfirm">
                                <div class="box_form">
                                    <div id="signUploader" style="display: none">

                                    </div>
                                    <div class="form-group">
                                        <label>{constant("SIGNUP_NAME")}</label>
                                        <input type="text" name="firstName" class="form-control"
                                               placeholder="{constant("SIGNUP_NAME")}">
                                    </div>
                                    <div class="form-group">
                                        <label>{constant("SIGNUP_LASTNAME")}</label>
                                        <input type="text" name="lastName" class="form-control"
                                               placeholder="{constant("SIGNUP_NAME")}">
                                    </div>
                                    <div class="form-group">
                                        <label>{constant("SIGNUP_EMAIL")}</label>
                                        <input type="email" name="email" class="form-control"
                                               placeholder="{constant("SIGNUP_NAME")}">
                                    </div>
                                    <div class="form-group">
                                        <label>{constant("SIGNUP_PASSWORD")}</label>
                                        <input type="password" name="password" class="form-control" id="password1"
                                               placeholder="{constant("SIGNUP_PASSWORD")}">
                                    </div>
                                    <div class="form-group">
                                        <label>{constant("SIGNUP_PASSWORD_CONFIRM")}</label>
                                        <input type="password" name="password_confirm" class="form-control"
                                               id="password2"
                                               placeholder="{constant("SIGNUP_PASSWORD_CONFIRM")}">
                                    </div>
                                    <div class="form-group">
                                        <label>{constant("SIGNUP_PHONE")}</label>
                                        <input type="text" name="phone_number" class="form-control" id="phoneNumber"
                                               placeholder="{constant("SIGNUP_PHONE")}">
                                    </div>
                                    <div id="pass-info" class="clearfix"></div>
                                    <div class="form-group text-center add_top_30">
                                        <button class="btn_1" type="submit">{constant("SIGNUP_SUBMIT")}</button>
                                    </div>
                                </div>
                                {*<p class="text-center">*}
                                {*<small>Has voluptua vivendum accusamus cu. Ut per assueverit temporibus dissentiet. Eum*}
                                {*no atqui putant democritum, velit nusquam sententiae vis no.*}
                                {*</small>*}
                                {*</p>*}
                            </form>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
                <!-- /register -->
            </div>
        </div>
    </main>
    <!-- /main -->
{/block}