{if $navigation}
  <ul>
{foreach from=$navigation key="page_id" item="node"}
    <li{if $node.selected == true} class="current"{/if}>
      <a href="{$node.url}"{if $node.children} rel="{$page_id}"{/if}>{$node.text}</a>
    </li>
{/foreach}
  </ul>
{else}
  &nbsp;
{/if}