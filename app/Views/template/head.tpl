{* SMARTY *}

<head>
    {block name="head"}
        <title>{$title}</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Find easily a doctor and book online an appointment">
        <meta name="author" content="Ansonika">
        <base href="/"/>
        <!-- Favicons-->
        <link rel="shortcut icon" href="{$imgPath}favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" type="image/x-icon" href="{$imgPath}apple-touch-icon-57x57-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"
              href="{$imgPath}apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
              href="{$imgPath}apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
              href="{$imgPath}apple-touch-icon-144x144-precomposed.png">
        <!-- BASE CSS -->
        <link href="{$cssPath}bootstrap.min.css" rel="stylesheet">
        {*<link href="{$cssPath}style.css" rel="stylesheet">*}
        {*<link href="{$cssPath}menu.css" rel="stylesheet">*}
        {combine input=array("/{$cssPath}style.css","/{$cssPath}menu.css", "/{$cssPath}vendors.css")
                output='/cache/big.css' use_true_path=false age='3600' debug=false}
        {*<link href="{$cssPath}vendors.css" rel="stylesheet">*}
        <link href="{$cssPath}icon_fonts/css/all_icons_min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css"
              integrity="sha256-NkXMfPcpoih3/xWDcrJcAX78pHpfwxkhNj0bAf8AMTs=" crossorigin="anonymous"/>
        <!-- YOUR CUSTOM CSS -->
        <link href="{$cssPath}custom.css" rel="stylesheet">
    {/block}
</head>
