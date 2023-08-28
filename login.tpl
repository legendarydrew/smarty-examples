<div id="login-form">

  <div id="logo">
    {image path="app/logo_foley.png"}
  </div>

  {foley_form module=$target_module}
    <div class="row">
      <label for="login-username">Username</label>
      <input type="textbox" class="textbox" id="login-username" name="username" {if $smarty.post.username}value="{$smarty.post.username}" {/if}/>
    </div>
    <div class="row">
      <label for="login-password">Password</label>
      <input type="password" class="textbox" id="login-password" name="password" />
    </div>
    <div class="button-submit">
      <input type="hidden" name="target_page" value="{$target_page}" />
      <button type="submit">Login</button>
    </div>
  {/foley_form}

</div>