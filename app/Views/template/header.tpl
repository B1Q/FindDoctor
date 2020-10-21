{* SMARTY *}

<div class="layer"></div>
<!-- Mobile menu overlay mask -->

<div id="preloader">
    <div data-loader="circle-side"></div>
</div>
<!-- End Preload -->

<header class="header_sticky">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div id="logo_home">
                    <h1><a href="/" title="{$title}">{$title}</a></h1>
                </div>
            </div>
            <nav class="col-lg-9 col-6">
                <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="#0"><span>{constant("GENERAL_MOBILEMENU")}</span></a>
                <ul id="top_access">
                    {if $sessionId == 0}
                        <li><a href="/control"><i class="pe-7s-user"></i></a></li>
                        <li><a href="/signup"><i class="pe-7s-add-user"></i></a></li>
                    {else}
                        <li><a href="/logout"><i class="icon-logout-3" data-tooltip="Logout!"></i></a></li>
                    {/if}
                </ul>
                <div class="main-menu">
                    <ul>
                        <li>
                            <a href="/">{constant("UI_HOME")}</a>
                        </li>
                        <li>
                            <a href="/about">{constant("UI_ABOUTUS")}</a>
                        </li>
                        <li>
                            <a href="/tests">{constant("UI_TESTS")}</a>
                        </li>
                        <li><a href="/contact">{constant("UI_CONTACT")}</a></li>
                        {if isset($userProfile.rank)}
                            <li><a href="/control">{constant("UI_CONTROLPANEL")}</a></li>
                            {if $userProfile.rank == 1}
                                <li><a href="/admincp"><b>{constant("GENERAL_ADMIN")}</b></a></li>
                            {/if}
                        {/if}

                        <li class="submenu">
                            <a href="#" onclick="return false;" class="show-submenu">{constant("UI_LANGUAGE")}
                                <i class="icon-down-open-mini"></i></a>
                            <ul>
                                {foreach from=$languages item=$language}
                                    <li>
                                        <a class='languageSwitch' data-key="{$language.key}" href="#">
                                            <i class="{$language.icon}"></i> {$language.name}
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /main-menu -->
            </nav>
        </div>
    </div>
    <!-- /container -->
</header>
<!-- /header -->