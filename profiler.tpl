
<!-- Foley Engine Profiler -->

<script type="text/javascript" src="{URL::base(true)}global/js/profiler.js"></script>
<link type="text/css" rel="stylesheet" href="{URL::base(true)}global/css/profiler.css" />
<div id="fep-container" class="pQp hideDetails" style="display: none;">
  <div id="pQp" class="console">
    <table id="fep-metrics">
      <tr>
        <td id="console" class="tab" style="color: #588E13;">
          <var>{$logCount}</var>
          <h4>Console</h4>
        </td>
        <td id="speed" class="tab">
          <var>{$speedTotal}</var>
          <h4>Time</h4>
        </td>
        <td id="benchmark" class="tab">
          <var>{$benchCount}x</var>
          <h4>Benchmark</h4>
        </td>
        <td id="memory" class="tab">
          <var>{$memoryUsed}</var>
          <h4>Memory</h4>
        </td>
        <td id="files" class="tab" style="color: #B72F09;">
          <var>{$fileCount}</var>
          <h4>Files</h4>
        </td>
      </tr>
    </table>

    <!--// Start Console tab -->
    <div id="pqp-console" class="pqp-box">

    {if $logCount == 0}
      <h3>This panel has no log items.</h3>
    {else}
      <table class="side">
        <tr>
          <td class="alt1"><var>{$output.logs.logCount}</var><h4>Logs</h4></td>
          <td class="alt2"><var>{$output.logs.errorCount}</var><h4>Errors</h4></td>
        </tr>
        <tr>
          <td class="alt3"><var>{$output.logs.memoryCount}</var><h4>Memory</h4></td>
          <td class="alt4"><var>{$output.logs.speedCount}</var><h4>Speed</h4></td>
        </tr>
      </table>

      <table class="main">
      {foreach from=$output.logs.console item="log"}
        {if isset($log.type) && $log.type != 'query'}
        <tr class="log-{$log.type}">
          <td class="type">{$log.type}</td>
          <td class="{cycle values=",alt"}">
          {if $log.type == 'log'}
            <div><pre>{$log.data}</pre></div>
          {elseif $log.type == 'memory'}
            <div><pre>{$log.data}</pre> <em>{$log.dataType}</em>: {$log.name} </div>
          {elseif $log.type == 'speed'}
            <div><pre>{$log.data}</pre> <em>{$log.name}</em></div>
          {elseif $log.type == 'error'}
            <div><em>Line {$log.line}</em> : {$log.data} <pre>{$log.file}</pre></div>
          {elseif $log.type == 'benchmark'}
            <div>{$log.name} <pre>{$log.data}</pre></div>
          {/if}
          </td>
        </tr>
        {/if}
      {/foreach}
      </table>
    {/if}
    </div>

    <!--// Start Load Time tab -->
    <div id="pqp-speed" class="pqp-box">
    {if $output.logs.speedCount == 0}
      <h3>This panel has no log items.</h3>
    {else}
      {capture name="side_load_time"}
      <table class="side">
        <tr>
          <td><var>{$output.speedTotals.total}</var><h4>Load Time</h4></td>
        </tr>
        <tr>
          <td class="alt"><var>{$output.speedTotals.allowed}</var> <h4>Max Execution Time</h4></td>
        </tr>
      </table>
      {/capture}
      {$smarty.capture.side_load_time}
      <table class="main">
      {foreach from=$output.logs.console item="log"}
        {if isset($log.type) && $log.type == 'speed'}
        <tr class="log-{$log.type}">
          <td class="{cycle values=",alt"}">
            <div><pre>{$log.data}</pre> <em>{$log.name}</em></div>
          </td>
        </tr>
        {/if}
      {/foreach}
      </table>
    {/if}
    </div>

    <!--// Start Benchmark tab -->
    <div id="pqp-benchmark" class="pqp-box">
    {if $output.logs.benchCount == 0}
      <h3>This panel has no log items.</h3>
    {else}
      {$smarty.capture.side_load_time}
      <table class="main">
      {foreach from=$output.logs.console item="log"}
        {if isset($log.type) && $log.type == 'benchmark'}
        <tr class="log-{$log.type}">
          <td class="{cycle values=",alt"}">
          <div><pre>{$log.data}</pre> <em>{$log.name}</em></div>
          </td>
        </tr>
        {/if}
      {/foreach}
      </table>
    {/if}
    </div>

    <!--// Start Memory tab -->
    <div id="pqp-memory" class="pqp-box">
    {if $output.logs.memoryCount == 0}
      <h3>This panel has no log items.</h3>
    {else}
      <table class="side">
        <tr><td><var>' . $output.memoryTotals.used . '</var><h4>Used Memory</h4></td></tr>
        <tr><td class="alt"><var>' . $output.memoryTotals.total . '</var> <h4>Total Available</h4></td></tr>
      </table>
      <table class="main">
      {foreach from=$output.logs.console item="log"}
        {if (isset($log.type) && $log.type == 'memory')}
        <tr class="log-{$log.type}">
          <td class="{cycle values=",alt"}">
            <b>{$log.data}</b> <em>{$log.dataType}</em>: {$log.name}
          </td>
        </tr>
        {/if}
      {/foreach}
      </table>
    {/if}
    </div>

    <!--// Start Files tab -->
    <div id="pqp-files" class="pqp-box">
    {if $output.fileTotals.count == 0}
      <h3>This panel has no log items.</h3>
    {else}
      <table class="side">
        <tr>
          <td><var>{$output.fileTotals.count}</var><h4>Total Files</h4></td>
        </tr>
        <tr>
          <td class="alt"><var>{$output.fileTotals.size}</var> <h4>Total Size</h4></td>
        </tr>
        <tr>
          <td><var>{$output.fileTotals.largest}</var> <h4>Largest</h4></td>
        </tr>
      </table>

      <table class="main">
      {foreach from=$output.files item="file"}
        <tr>
          <td class="{cycle values=",alt"}"><b>{$file.size}</b> {$file.name}</td>
        </tr>
      {/foreach}
      </table>
    {/if}
    </div>

    <!--// Start Footer -->
    <footer>
      <div class="credit">
        <strong>Foley Engine</strong>&nbsp;Profiler
      </div>
      <div class="actions">
        <a class="detailsToggle" href="#">Details</a>
        <a class="removeProfiler" href="#">Remove</a>
        <a class="heightToggle" href="#">Toggle Height</a>
      </div>
    </footer>

  </div>
</div>
