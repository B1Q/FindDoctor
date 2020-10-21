{* SMARTY *}

<div class="row justify-content-center">
    <div class="col-md-12">
        <h3>EditProfile</h3>
        <form method="post" class="ajaxForm"
              data-loader="updateLoader"
              data-url="{$siteurl}updateProfile">
            <div class="box_form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{constant("SIGNUP_NAME")}</label>
                            <input type="text" name="firstName" class="form-control"
                                   value="{$userProfile.firstname}"
                                   placeholder="{constant("SIGNUP_NAME")}">
                        </div>
                        <div class="form-group">
                            <label>{constant("SIGNUP_LASTNAME")}</label>
                            <input type="text" name="lastName" class="form-control"
                                   value="{$userProfile.lastname}"
                                   placeholder="{constant("SIGNUP_NAME")}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{constant("SIGNUP_EMAIL")}</label>
                            <input type="email" name="email" class="form-control"
                                   value="{$userProfile.email}"
                                   placeholder="{constant("SIGNUP_NAME")}">
                        </div>
                        <div class="form-group">
                            <label>{constant("SIGNUP_PHONE")}</label>
                            <input type="text" name="phone_number" class="form-control" id="phoneNumber"
                                   value="{$userProfile.phone_number}"
                                   placeholder="{constant("SIGNUP_PHONE")}">
                        </div>
                    </div>
                </div>
                <div class="box_form">
                    <h3>{constant("GENERAL_IDENTITYCHECK")}</h3>
                    <div id="updateLoader" style="display: none">

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
                </div>
                <div id="pass-info" class="clearfix"></div>
                <div class="form-group text-center add_top_30">
                    <button class="btn_1" type="submit">{constant("EDITPROFILE_SUBMIT")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /row -->