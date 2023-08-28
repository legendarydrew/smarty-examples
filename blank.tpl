<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$page_title|default:"DrewMaughan.com"}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="{$meta_description}" />
<meta name="keywords" content="{$meta_keywords}" />
<meta name="robots" content="{if $meta_robots.index}index{else}noindex{/if},{if $meta_robots.follow}follow{else}nofollow{/if}" />
<base href="{$base_url}" />
<!-- Stylesheets -->
{$css_tags}
</head>

<body id="{$controller_name}">
<div id="wrapper">

  <!-- Foley messages -->
{if $messages}
  <div id="app-messages">
{foreach from=$messages item="message"}
    <div class="{$message.type}">
      <dfn>{$message.type|capitalize}: </dfn>{$message.text|nl2br}
    </div>
{/foreach}
  </div>
{/if}

{$contents}

</div>

<!-- Scripts -->
<script type="text/javascript" src="//code.jquery.com/jquery-1.9.0.js"></script>
<script type="text/javascript" src="//code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<script type="text/javascript" src="{$base_url}js/admin.js"></script>
{$js_tags}
</body>
</html>