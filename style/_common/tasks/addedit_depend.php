<form name="dependFrm" action="?m=tasks&a=addedit&task_project=<?php echo $task_project; ?>" method="post" accept-charset="utf-8">
    <input name="dosql" type="hidden" value="do_task_aed" />
    <input name="task_id" type="hidden" value="<?php echo $task_id; ?>" />
    <input type="hidden" name="hdependencies" />

    <div class="std addedit tasks-depends">
        <div class="column left">
            <p>
                <?php $form->showLabel('Dependency Tracking'); ?>
                <?php echo $AppUI->_('On'); ?><input type="radio" name="task_dynamic" value="31" <?php if ($task_id == 0 || $task->task_dynamic > '20') { echo "checked"; } ?> />
                <?php echo $AppUI->_('Off'); ?><input type="radio" name="task_dynamic" value="0" <?php if ($task_id && ($task->task_dynamic == '0' || $task->task_dynamic == '11')) { echo "checked"; } ?> />
            </p>
            <p>
                <?php $form->showLabel('Set task start date based on dependency'); ?>
                <input type="checkbox" name="set_task_start_date" id="set_task_start_date" <?php if ($task_id == 0 || $task->task_dynamic > '20') { echo "checked"; } ?>  />
            </p>
            <p>
                <?php $form->showLabel('All Tasks'); ?>
                <select name="all_tasks" class="text" style="width:220px" size="10" class="text" multiple="multiple">
                    <?php echo str_replace('selected', '', $task_parent_options); // we need to remove selected added from task_parent options ?>
                </select>
            </p>
            <p><input type="button" class="button btn btn-primary btn-mini" value="&gt;" onclick="addTaskDependency(document.dependFrm, document.datesFrm)" /></p>
        </div>
        <div class="column right">
            <p>
                <?php $form->showLabel('Dynamic Task'); ?>
                <input type="checkbox" name="task_dynamic" id="task_dynamic" value="1" <?php if ($task->task_dynamic == "1") { echo 'checked="checked"'; } ?> />
            </p>
            <p>
                <?php $form->showLabel('Do not track this task'); ?>
                <input type="checkbox" name="task_dynamic_nodelay" id="task_dynamic_nodelay" value="1" <?php if (($task->task_dynamic > '10') && ($task->task_dynamic < 30)) { echo 'checked="checked"'; } ?> />
            </p>
            <p>
                <?php $form->showLabel('Dependencies'); ?>
                <?php echo arraySelect($taskDep, 'task_dependencies', 'style="width:220px" size="10" class="text" multiple="multiple" ', null); ?>
            </p>
            <p><input type="button" class="button btn btn-primary btn-mini" value="&lt;" onclick="removeTaskDependency(document.dependFrm, document.datesFrm)" /></p>
        </div>
    </div>
</form>