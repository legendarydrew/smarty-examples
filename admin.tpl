<!DOCTYPE html>
<html>
<head>
<title>{$page_title}</title>
{$meta_tags}
<!-- Stylesheets -->
{$css_tags}
</head>

<body>
<div id="wrapper">
  <div id="header">
    <div id="header-logo-foley">
      {image path="app/logo_foley.png" alt="Foley Engine"}
    </div>
    <div id="header-logo-custom">
      {image path="app/logo.png"}
    </div>
    <div id="header-user">
      logged in as <strong>{$user.username}</strong>&nbsp;
      [ <a href="{foley_link page="login" action="logout"}">log out</a> ]
    </div>
  </div>

{$navigation}

  <div id="content">

{if $messages}
    <!-- Foley Engine system messages. -->
    <ul id="fe-messages">
{foreach from=$messages item="message"}
      <li class="msg{if $message.type} {$message.type}{/if}"><dfn>{$message.type|capitalize}: </dfn>{$message.text|nl2br}</li>
{/foreach}
    </ul>
{/if}

    <div id="{$controller_name}">
      {$contents}
    </div>

  </div>

  <div id="footer">
    <div id="footer-copy">
      {FE->getAppName} is copyright &copy; 2008-{$smarty.now|date_format:'%Y'} Drew Maughan, all rights reserved.
    </div>
    <div class="clear"></div>
  </div>
</div>

<!-- Scripts -->
<script type="text/javascript" src="/global/js/ui.js"></script>
<script type="text/javascript" src="/global/js/admin.js"></script>
{$js_tags}
</body>
</html>