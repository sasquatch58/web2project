<?php
if (!defined('W2P_BASE_DIR')) {
	die('You should not access this file directly.');
}
// @todo    convert to template

global $AppUI, $users, $task_id, $task_project, $task, $projTasksWithEndDates, $tab, $loadFromTab;
global $form;

// Make sure that we can see users that are allocated to the task.

if ($task_id == 0) {
	// Add task creator to assigned users by default
	$assignedUsers = array($AppUI->user_id => array('contact_name' => $users[$AppUI->user_id], 'perc_assignment' => '100'));
} else {
	// Pull users on this task
	$assignedUsers = $task->assignees($task_id);
}

$initPercAsignment = '';
$assigned = array();
foreach ($assignedUsers as $user_id => $data) {
        $displayName = $data['contact_name'];
        if (isset($data['contact_display_name'])) {
            $displayName = $data['contact_display_name'];
        }
	$assigned[$user_id] = $displayName . ' [' . $data['perc_assignment'] . '%]';
	$initPercAsignment .= "$user_id={$data['perc_assignment']};";
}

?>
<script language="javascript" type="text/javascript">
<?php
echo "var projTasksWithEndDates=new Array();\n";
$keys = array_keys($projTasksWithEndDates);
for ($i = 1, $i_cmp = sizeof($keys); $i < $i_cmp; $i++) {
	//array[task_is] = end_date, end_hour, end_minutes
	echo 'projTasksWithEndDates[' . $keys[$i] . "]=new Array(\"" . $projTasksWithEndDates[$keys[$i]][1] . "\", \"" . $projTasksWithEndDates[$keys[$i]][2] . "\", \"" . $projTasksWithEndDates[$keys[$i]][3] . "\");\n";
}
?>
</script>
<form action="?m=tasks&a=addedit&task_project=<?php echo $task_project; ?>" method="post" name="resourceFrm" accept-charset="utf-8">
    <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
    <input type="hidden" name="dosql" value="do_task_aed" />
    <input name="hperc_assign" type="hidden" value="<?php echo $initPercAsignment; ?>"/>
    <input type="hidden" name="hassign" />

    <div class="std addedit tasks-resources">
        <div class="column left">
            <p>
                <label>&nbsp;</label>
                <table cellspacing="0" cellpadding="2" border="0" class="well">
                    <tr>
                        <td><?php echo $AppUI->_('Human Resources'); ?>:</td>
                        <td><?php echo $AppUI->_('Assigned to Task'); ?>:</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo arraySelect($users, 'resources', 'style="width:220px" size="10" class="text" multiple="multiple" ', null); ?>
                        </td>
                        <td>
                            <?php echo arraySelect($assigned, 'assigned', 'style="width:220px" size="10" class="text" multiple="multiple" ', null); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <table>
                                <tr>
                                    <td align="right"><input type="button" class="button btn btn-primary btn-mini" value="&gt;" onclick="addUser(document.resourceFrm)" /></td>
                                    <td>
                                        <select name="percentage_assignment" class="text">
                                            <?php
                                            for ($i = 5; $i <= 100; $i += 5) {
                                                echo '<option ' . (($i == 100) ? 'selected="true"' : '') . ' value="' . $i . '">' . $i . '%</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td align="left"><input type="button" class="button btn btn-primary btn-mini" value="&lt;" onclick="removeUser(document.resourceFrm)" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </p>
        </div>
        <div class="column right">
            <p>
                <?php $form->showLabel('Additional Email Comments'); ?>
                <textarea name="email_comment" class="textarea" cols="60" rows="10"></textarea>
            </p>
            <p>
                <?php $form->showLabel('notifyChange'); ?>
                <input type="checkbox" name="task_notify" id="task_notify" value="1" <?php if ($task->task_notify != '0') echo 'checked="checked"' ?> />
            </p>
            <p>
                <?php $form->showLabel('Allow users to add task logs for others'); ?>
                <input type="checkbox" value="1" name="task_allow_other_user_tasklogs" <?php echo $task->task_allow_other_user_tasklogs ? 'checked="checked"' : ''; ?> />
            </p>
        </div>
    </div>
</form>
<script language="javascript" type="text/javascript">
	subForm.push(new FormDefinition(<?php echo $tab; ?>, document.resourceFrm, checkResource, saveResource));
</script>
