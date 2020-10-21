{* SMARTY *}
{extends "template/maintemplate.tpl"}
{block name="head" append}
    <link href="{$cssPath}blog.css" rel="stylesheet">
{/block}

{block name="content"}
    <main>
        <div class="main_title">
            <h1>{constant("CONTROL_TITLE")}</h1>
        </div>

        <div class="container margin_60">

            <div class="row">
                <div class="col-lg-9">
                    <article class="blog wow fadeIn">
                        <div class="row no-gutters">
                            <div class="col-lg-12 goodtab" id="tabOrders">
                                {include file="userpanel/orders.tpl" nocache}
                            </div>
                            <div class="col-lg-12 goodtab" style="display: none" id="tabProfile">
                                {include file="userpanel/editprofile.tpl" nocache}
                            </div>
                        </div>
                    </article>
                    <!-- /article -->
                </div>
                <!-- /col -->

                <div class="widget">
                    <div class="widget-title">
                        <h4>{constant("CONTROL_CONTROLS")}</h4>
                    </div>
                    <div class="switch-field">
                        <input type="radio" id="all" name="type_patient" value="all" checked="">
                        <label class='createiveLabel' style='width: 120px;' for="all"
                               data-tab="tabOrders">{constant("CONTROL_ORDERSBTN")}</label><br>
                        <input type="radio" id="doctors" name="type_patient" value="doctors">
                        <label class='createiveLabel' style="width: 120px;" for="doctors"
                               data-tab="tabProfile">{constant("CONTROL_EDITPROFILE")}</label><br>
                    </div>
                </div>
                <!-- /widget -->


                </aside>
                <!-- /aside -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </main>
    <!-- /main -->
{/block}

{block name="footer" append}
    <script>
        $('.createiveLabel').on('click', function (e) {
            $('.goodtab').hide();
            $('#' + $(this).data("tab")).show();
        });

        $('.btnAbort').on('click', function (e) {
            let name = $(this).data("killname");
            let testid = $(this).data("killid");

            {literal}
            let data = {id: testid};
            {/literal}

            if (confirm("are you sure you want to abort the test '" + name + "'?"))
                AjaxPost('{$siteurl}abortTest', data, function (data) {
                    alert(data['message']);
                });
        });
    </script>
{/block}