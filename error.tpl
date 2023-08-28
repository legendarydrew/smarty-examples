<style type="text/css">
#FE-error { background: #ddd; font-size: 80%; font-family:sans-serif; text-align: left; color: #111; }
#FE-error h1,
#FE-error h2 { margin: 0; padding: 1em; font-size: 1em; font-weight: normal; background: #888; color: #fff; }
#FE-error h1 a,
#FE-error h2 a { color: #fff; }
#FE-error h2 { background: #222; }
#FE-error h3 { margin: 0; padding: 0.4em 0 0; font-size: 1em; font-weight: normal; }
#FE-error p { margin: 0; padding: 0.2em 0; }
#FE-error a { color: #1b323b; }
#FE-error pre { overflow: auto; white-space: pre-wrap; }
#FE-error table { width: 100%; display: block; margin: 0 0 0.4em; padding: 0; border-collapse: collapse; background: #fff; }
#FE-error table td { border: solid 1px #ddd; text-align: left; vertical-align: top; padding: 0.4em; }
#FE-error div.content { padding: 0.4em 1em 1em; overflow: hidden; }
#FE-error pre.source { margin: 0 0 1em; padding: 0.4em; background: #fff; border: dotted 1px #b7c680; line-height: 1.2em; }
#FE-error pre.source span.line { display: block; }
#FE-error pre.source span.highlight { background: #f0eb96; }
#FE-error pre.source span.line span.number { color: #666; }
#FE-error ol.trace { display: block; margin: 0 0 0 2em; padding: 0; list-style: decimal; }
#FE-error ol.trace li { margin: 0; padding: 0; }
.js .collapsed { display: none; }
</style>
<script type="text/javascript">
document.documentElement.className = 'js';
function koggle(elem)
{
  elem = document.getElementById(elem);

  if (elem.style && elem.style['display'])
    // Only works with the "style" attr
    var disp = elem.style['display'];
  else if (elem.currentStyle)
    // For MSIE, naturally
    var disp = elem.currentStyle['display'];
  else if (window.getComputedStyle)
    // For most other browsers
    var disp = document.defaultView.getComputedStyle(elem, null).getPropertyValue('display');

  // Toggle the state of the "display" style
  elem.style.display = disp == 'block' ? 'none' : 'block';
  return false;
}
</script>
<div id="FE-error">
  <h1><span class="type">{$type} [ {$error_code} ]:</span> <span class="message">{$error_message}</span></h1>
  <div id="{$error_id}" class="content">
    <p><span class="file">{$debug_path} [ {$line} ]</span></p>
    {$debug_source}

    <ol class="trace">
    {foreach $trace as $i => $step}
      <li>
        <p>
          <span class="file">
            {if $step.file}
              {$source_id = $error_id|cat:"source"|cat:$i}
              <a href="#{$source_id}" onclick="return koggle('{$source_id}')">{$step.file} [ {$step.line} ]</a>
            {else}
              {ldelim}PHP internal call{rdelim}
            {/if}
          </span>
          &raquo;
          {$step.function}({if $step.args}{$args_id = $error_id|cat:"args"|cat:$i}<a href="#{$args_id}" onclick="return koggle('{$args_id}')">arguments</a>{/if})
        </p>
        {if $args_id}
        <div id="{$args_id}" class="collapsed">
          <table cellspacing="0">
          {foreach from=$step.args key="name" item="arg"}
            <tr>
              <td><code>{$name}</code></td>
              <td><pre>{dump var=$arg}</pre></td>
            </tr>
          {/foreach}
          </table>
        </div>
        {/if}
        {if $source_id}
          <pre id="{$source_id}" class="source collapsed"><code>{$step.source}</code></pre>
        {/if}
      </li>
    {/foreach}
    </ol>

  </div>


  {assign var="env_id" value=$error_id|cat:"environment"}
  <h2><a href="#{$env_id}" onclick="return koggle('{$env_id}')">Environment</a></h2>
  <div id="{$env_id}" class="content collapsed">

  {assign var="env_id" value=$error_id|cat:"environment_included"}
    <h3><a href="#{$env_id}" onclick="return koggle('{$env_id}')">Included files</a> ({$included_files|@count})</h3>
    <div id="{$env_id}" class="collapsed">
      <table cellspacing="0">
        {foreach from=$included_files item="file"}
        <tr>
          <td><code>{$file}</code></td>
        </tr>
        {/foreach}
      </table>
    </div>

  {assign var="env_id" value=$error_id|cat:"environment_loaded"}
    <h3><a href="#{$env_id}" onclick="return koggle('{$env_id}')">Loaded extensions</a> ({$included_extensions|@count})</h3>
    <div id="{$env_id}" class="collapsed">
      <table cellspacing="0">
        {foreach from=$included_extensions item="file"}
        <tr>
          <td><code>{$file}</code></td>
        </tr>
        {/foreach}
      </table>
    </div>

{$env_id = $error_id|cat:"environment_post"}
    <h3><a href="#{$env_id}" onclick="return koggle('{$env_id}')">$_POST</a> ({$included_extensions|@count})</h3>
    <div id="{$env_id}" class="collapsed">
      <table cellspacing="0">
        {foreach $smarty.post as $key => $value}
        <tr>
          <td><code>{$key}</code></td>
          <td><pre>{var_dump($value)}</pre></td>
        </tr>
        {/foreach}
      </table>
    </div>

{$env_id = $error_id|cat:"environment_get"}
    <h3><a href="#{$env_id}" onclick="return koggle('{$env_id}')">$_GET</a> ({$included_extensions|@count})</h3>
    <div id="{$env_id}" class="collapsed">
      <table cellspacing="0">
        {foreach $smarty.get as $key => $value}
        <tr>
          <td><code>{$key}</code></td>
          <td><pre>{var_dump($value)}</pre></td>
        </tr>
        {/foreach}
      </table>
    </div>

  </div>
</div>