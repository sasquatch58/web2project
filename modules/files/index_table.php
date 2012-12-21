<?php /* $Id$ $URL$ */
if (!defined('W2P_BASE_DIR')) {
	die('You should not access this file directly.');
}

/* FILES $Id$ */
// modified later by Pablo Roca (proca) in 18 August 2003 - added page support
// Files modules: index page re-usable sub-table
global $AppUI, $company_id, $project_id, $task_id;
global $currentTabId, $m;

$tab = ($m == 'files') ? $currentTabId-1 : -1;
$page = w2PgetParam($_GET, 'page', 1);
if (!isset($project_id)) {
	$project_id = w2PgetParam($_REQUEST, 'project_id', 0);
}

$xpg_pagesize = w2PgetConfig('page_size', 50);
$xpg_min = $xpg_pagesize * ($page - 1); // This is where we start our record set from

$df = $AppUI->getPref('SHDATEFORMAT');
$tf = $AppUI->getPref('TIMEFORMAT');

$category_id = 0;
if (($company_id || $project_id || $task_id) && !($m == 'files')) {
	$category_id = 0;
} else {
	// TODO: the filtering is not working as expected in the flat view
    $category_id = ($tab < 0) ? 0 : $tab + 1;
}


// counts total recs from selection
$fileList = CFile::getFileList($AppUI, $company_id, $project_id, $task_id, $tab);
$xpg_totalrecs = count($fileList);
$pageNav = buildPaginationNav($AppUI, $m, $tab, $xpg_totalrecs, $xpg_pagesize, $page);
echo $pageNav;
?>
<script language="javascript" type="text/javascript">
function expand(id){
  var element = document.getElementById(id);
  element.style.display = (element.style.display == '' || element.style.display == 'none') ? 'block' : 'none';
}
</script>
<table class="tbl list">
    <?php 
    global $showProject;
    $showProject = true;
    echo displayFiles($AppUI, 0, $task_id, $project_id, $company_id);
    ?>
</table>
<?php
echo $pageNav;