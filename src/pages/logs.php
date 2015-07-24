<?php
$panel->setPageTitle('Logs');
$panel->setPageHeader('Logs');
$panel->setPageDescription('Server Logs');

if (!$panel->userHasPermission('access_logs')) {
  $panel->setPageContent('You do not have permission to access this content');
  return;
}

$content = <<<EOF


<textarea class="form-control" rows="15">

</textarea>


      <div id="control">
         <form name="control_filters" id="control_filters">
            <table class="table table-bordered">
               <tr>
                  <td width="33%"><label for="filterChat"><input type="checkbox" id="filterChat" value="chat" checked> Chat / Admin Chat</label></td>
                  <td width="33%"><label for="filterCommands"><input type="checkbox" id="filterCommands" value="commands" checked> Commands</label></td>
                  <td width="33%"><label for="filterWorldEdit"><input type="checkbox" id="filterWorldEdit" value="worldEdit" checked> WorldEdit</label></td>
               </tr>
               <tr>
                  <td width="33%"><label for="filterErrors"><input type="checkbox" id="filterErrors" value="error" checked> Errors</label></td>
                  <td width="33%"><label for="filterKickBans"><input type="checkbox" id="filterKickBans" value="kickBans" checked> Kicks / Bans / Smites</label></td>
                  <td width="33%"><label for="filterLoginLogout"><input type="checkbox" id="filterLoginLogout" value="loginLogout" checked> Login / Logout</label></td>
               </tr>
            </table>
            <p>
            <div class="input-group">
               <span class="input-group-addon">KBytes</span>
               <input type="text" id="kbytes" value="64" class="form-control ">
               <span class="input-group-btn">
               <button class="btn btn-primary" onclick="event.preventDefault(); getLogs();">Update Logs</button>
               </span>
            </div>
            </p>
         </form>
      </div>



EOF;









$panel->setPageContent($content);

?>
