<?php
/**
 * The bug view file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: bug.html.php 5107 2013-07-12 01:46:12Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php js::set('mode', $mode);?>
<?php js::set('total', $pager->recTotal);?>
<?php js::set('rawMethod', $app->rawMethod);?>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolbar pull-left">
    <?php
    $recTotalLabel = " <span class='label label-light label-badge'>{$pager->recTotal}</span>";
    if($app->rawMethod == 'contribute')
    {
        echo html::a(inlink($app->rawMethod, "mode=$mode&type=openedBy"),   "<span class='text'>{$lang->bug->openedByMe}</span>" . ($type == 'openedBy'   ? $recTotalLabel : ''),   '', "class='btn btn-link" . ($type == 'openedBy'   ? ' btn-active-text' : '') . "'");
        echo html::a(inlink($app->rawMethod, "mode=$mode&type=resolvedBy"), "<span class='text'>{$lang->bug->resolvedByMe}</span>" . ($type == 'resolvedBy' ? $recTotalLabel : ''), '', "class='btn btn-link" . ($type == 'resolvedBy' ? ' btn-active-text' : '') . "'");
        echo html::a(inlink($app->rawMethod, "mode=$mode&type=closedBy"),   "<span class='text'>{$lang->bug->closedByMe}</span>" . ($type == 'closedBy'   ? $recTotalLabel : ''),   '', "class='btn btn-link" . ($type == 'closedBy'   ? ' btn-active-text' : '') . "'");
    }
    ?>
  </div>
</div>
<div id="mainContent">
  <?php if(empty($bugs)):?>
  <div class="table-empty-tip">
    <p><span class="text-muted"><?php echo $lang->bug->noBug;?></span></p>
  </div>
  <?php else:?>
  <form id='myBugForm' class="main-table table-bug" data-ride="table" method="post" action='<?php echo $this->createLink('bug', 'batchEdit', "productID=0");?>'>
    <?php
    $canBatchEdit     = common::hasPriv('bug', 'batchEdit');
    $canBatchConfirm  = common::hasPriv('bug', 'batchConfirm');
    $canBatchClose    = (common::hasPriv('bug', 'batchClose') and strtolower($type) != 'closedby');
    $canBatchAssignTo = common::hasPriv('bug', 'batchAssignTo');
    $canBatchAction   = ($canBatchEdit or $canBatchConfirm or $canBatchClose or $canBatchAssignTo);
    ?>
    <table class="table has-sort-head table-fixed" id='bugList'>
      <?php $vars = "mode=$mode&type=$type&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
      <thead>
        <tr>
          <th class="w-100px">
            <?php if($canBatchAction):?>
            <div class="checkbox-primary check-all" title="<?php echo $lang->selectAll?>">
              <label></label>
            </div>
            <?php endif;?>
            <?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?>
          </th>
          <th class='w-50px' title='<?php echo $lang->bug->severity;?>'> <?php common::printOrderLink('severity', $orderBy, $vars, $lang->bug->severityAB);?></th>
          <th class='w-50px' title='<?php echo $lang->bug->pri;?>'>      <?php common::printOrderLink('pri',      $orderBy, $vars, $lang->priAB);?></th>
          <th>                <?php common::printOrderLink('title',       $orderBy, $vars, $lang->bug->title);?></th>
          <th class='w-150px'><?php common::printOrderLink('productName', $orderBy, $vars, $lang->bug->product);?></th>
          <th class='w-type'> <?php common::printOrderLink('type',        $orderBy, $vars, $lang->typeAB);?></th>
          <?php if($type != 'openedBy'): ?>
          <th class='w-90px'> <?php common::printOrderLink('openedBy',    $orderBy, $vars, $lang->openedByAB);?></th>
          <?php endif;?>
          <?php if($type != 'assignedTo'): ?>
          <th class='w-110px c-assignedTo'><?php common::printOrderLink('assignedTo',  $orderBy, $vars, $lang->bug->assignedTo);?></th>
          <?php endif;?>
          <?php if($type != 'resolvedBy'): ?>
          <th class='w-100px'><?php common::printOrderLink('resolvedBy',  $orderBy, $vars, $lang->bug->resolvedByAB);?></th>
          <?php endif;?>
          <th class='w-100px'><?php common::printOrderLink('resolution',  $orderBy, $vars, $lang->bug->resolutionAB);?></th>
          <th class='c-actions-5'> <?php echo $lang->actions;?></th>
        </tr>
      </thead>
      <?php
      $hasCustomSeverity = false;
      foreach($lang->bug->severityList as $severityKey => $severityValue)
      {
          if(!empty($severityKey) and (string)$severityKey != (string)$severityValue)
          {
              $hasCustomSeverity = true;
              break;
          }
      }
      ?>
      <tbody>
        <?php foreach($bugs as $bug):?>
        <?php $canBeChanged = common::canBeChanged('bug', $bug);?>
        <tr>
          <td class="c-id">
            <?php if($canBatchAction):?>
            <div class="checkbox-primary">
              <input type='checkbox' name='bugIDList[]' value='<?php echo $bug->id;?>' <?php if(!$canBeChanged) echo 'disabled';?> />
              <label></label>
            </div>
            <?php endif;?>
            <?php printf('%03d', $bug->id);?>
          </td>
          <td>
            <?php if($hasCustomSeverity):?>
            <span class='<?php echo 'label-severity-custom';?>' title='<?php echo zget($lang->bug->severityList, $bug->severity);?>' data-severity='<?php echo $bug->severity;?>'><?php echo zget($lang->bug->severityList, $bug->severity, $bug->severity);?></span>
            <?php else:?>
            <span class='<?php echo 'label-severity';?>' data-severity='<?php echo $bug->severity;?>' title='<?php echo zget($lang->bug->severityList, $bug->severity);?>'></span>
            <?php endif;?>
          </td>
          <td><span class='label-pri <?php echo 'label-pri-' . $bug->pri?>' title='<?php echo zget($lang->bug->priList, $bug->pri);?>'><?php echo zget($lang->bug->priList, $bug->pri)?></span></td>
          <td class='text-left nobr'><?php echo html::a($this->createLink('bug', 'view', "bugID=$bug->id", '', '', $bug->project), $bug->title, null, "style='color: $bug->color' title={$bug->title} data-group='project'");?></td>
          <td class='text-left nobr'><?php echo html::a($this->createLink('product', 'view', "productID=$bug->product", '', '', $bug->project), $bug->productName, null, "title={$bug->productName} data-group='product'");?></td>
          <td title="<?php echo zget($lang->bug->typeList, $bug->type, '');?>"><?php echo zget($lang->bug->typeList, $bug->type, '');?></td>
          <?php if($type != 'openedBy'): ?>
          <td><?php echo zget($users, $bug->openedBy);?></td>
          <?php endif;?>
          <?php if($type != 'assignedTo'): ?>
          <td class='c-assignedTo has-btn'><?php $this->bug->printAssignedHtml($bug, $users);?></td>
          <?php endif;?>
          <?php if($type != 'resolvedBy'): ?>
          <td><?php echo zget($users, $bug->resolvedBy);?></td>
          <?php endif;?>
          <td><?php echo zget($lang->bug->resolutionList, $bug->resolution);?></td>
          <td class='c-actions'>
            <?php
            if($canBeChanged)
            {
                $params = "bugID=$bug->id";
                common::printIcon('bug', 'confirmBug', $params, $bug, 'list', 'ok',      '', 'iframe', true, '', '', $bug->project);
                common::printIcon('bug', 'resolve',    $params, $bug, 'list', 'checked', '', 'iframe', true, '', '', $bug->project);
                common::printIcon('bug', 'close',      $params, $bug, 'list', '',        '', 'iframe', true, '', '', $bug->project);
                common::printIcon('bug', 'edit',       $params, $bug, 'list', '',        '', '',       '',   '', '', $bug->project);
                common::printIcon('bug', 'create',     "product=$bug->product&branch=$bug->branch&extra=$params", $bug, 'list', 'copy', '', '', '', '', '', $bug->project);
            }
            ?>
          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <div class="table-footer">
      <?php if($canBatchAction):?>
      <div class="checkbox-primary check-all"><label><?php echo $lang->selectAll?></label></div>
      <?php endif;?>
      <div class="table-actions btn-toolbar">
        <?php
        if($canBatchEdit)
        {
            $actionLink = $this->createLink('bug', 'batchEdit');
            $misc       = "data-form-action='$actionLink'";
            echo html::commonButton($lang->edit, $misc);
        }
        if($canBatchConfirm)
        {
          $actionLink = $this->createLink('bug', 'batchConfirm', '', '', '', $bug->project);
          $misc = "onclick=\"setFormAction('$actionLink', 'hiddenwin')\"";
          echo html::commonButton($lang->bug->confirmBug, $misc);
        }
        if($canBatchClose)
        {
          $actionLink = $this->createLink('bug', 'batchClose', '', '', '', $bug->project);
          $misc = "onclick=\"setFormAction('$actionLink', 'hiddenwin')\"";
          echo html::commonButton($lang->bug->close, $misc);
        }
        ?>
        <?php
        if($canBatchAssignTo && count($bugs)):?>
        <div class="btn-group dropup">
          <button data-toggle="dropdown" type="button" class="btn"><?php echo $lang->bug->assignedTo?> <span class="caret"></span></button>
          <?php
          $withSearch = count($memberPairs) > 10;
          $actionLink = $this->createLink('bug', 'batchAssignTo', "productID=0&type=my", '', '', $bug->project);
          echo html::select('assignedTo', $memberPairs, '', 'class="hidden"');
          if($withSearch)
          {
              echo "<div class='dropdown-menu search-list search-box-sink' data-ride='searchList'>";
              echo '<div class="input-control search-box has-icon-left has-icon-right search-example">';
              echo '<input id="userSearchBox" type="search" class="form-control search-input" autocomplete="off" />';
              echo '<label for="userSearchBox" class="input-control-icon-left search-icon"><i class="icon icon-search"></i></label>';
              echo '<a class="input-control-icon-right search-clear-btn"><i class="icon icon-close icon-sm"></i></a>';
              echo '</div>';
              $membersPinYin = common::convert2Pinyin($memberPairs);
          }
          else
          {
              echo "<div class='dropdown-menu search-list'>";
          }
          echo '<div class="list-group">';
          foreach ($memberPairs as $key => $value)
          {
              if(empty($key)) continue;
              $searchKey = $withSearch ? ('data-key="' . zget($membersPinYin, $value, '') . " @$key\"") : "data-key='@$key'";
              echo html::a('javascript:$(".table-actions #assignedTo").val("' . $key . '");setFormAction("' . $actionLink . '")', '<i class="icon icon-person icon-sm"></i> ' . $value, '', $searchKey);
          }
          echo "</div>";
          echo "</div>";
          ?>
        </div>
        <?php endif;?>
      </div>
      <?php $pager->show('right', 'pagerjs');?>
    </div>
  </form>
  <?php endif;?>
</div>
<?php js::set('listName', 'bugList')?>
<?php include '../../common/view/footer.html.php';?>
