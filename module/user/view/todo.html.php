<?php
/**
 * The todo view file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: todo.html.php 4744 2013-05-04 02:41:05Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include "../../common/view/datepicker.html.php"; ?>
<?php include './featurebar.html.php';?>
<?php js::set('userID', $user->id);?>
<?php js::set('type', $type);?>
<div id='mainContent'>
  <nav id='contentNav'>
    <ul class='nav nav-default'>
      <?php
      foreach($lang->todo->periods as $period => $label)
      {
          $active = $type == $period ? 'active' : '';
          $vars = "userID={$user->id}&date=$period";
          if($period == 'before') $vars .= "&status=undone";
          echo "<li id='$period' class='$active'>" . html::a(inlink('todo', $vars), $label) . '</li> ';
      }
      ?>
    </ul>
  </nav>

  <form method='post' target='hiddenwin' action='<?php echo $this->createLink('todo', 'import2Today');?>' data-ride='table' id='todoform' class='main-table table-todo'>
    <table class='table has-sort-head table-fixed'>
      <?php $vars = "userID={$user->id}&type=$type&status=$status&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}"; ?>
      <thead>
      <tr class='colhead'>
        <th class='c-id'>    <?php common::printOrderLink('id',     $orderBy, $vars, $lang->idAB);?></th>
        <th class='c-date'>  <?php common::printOrderLink('date',   $orderBy, $vars, $lang->todo->date);?></th>
        <th class='c-type'>  <?php common::printOrderLink('type',   $orderBy, $vars, $lang->todo->type);?></th>
        <th class='c-pri' title='<?php echo $lang->pri;?>'>   <?php common::printOrderLink('pri',    $orderBy, $vars, $lang->priAB);?></th>
        <th>                 <?php common::printOrderLink('name',   $orderBy, $vars, $lang->todo->name);?></th>
        <th class='c-date'>  <?php common::printOrderLink('begin',  $orderBy, $vars, $lang->todo->beginAB);?></th>
        <th class='c-date'>  <?php common::printOrderLink('end',    $orderBy, $vars, $lang->todo->endAB);?></th>
        <th class='c-status'><?php common::printOrderLink('status', $orderBy, $vars, $lang->todo->status);?></th>
      </tr>
      </thead>
      <tbody>
      <?php foreach($todos as $todo):?>
      <tr class='text-left'>
        <td><?php echo $todo->id;?></td>
        <td><?php echo $todo->date == '2030-01-01' ? $lang->todo->periods['future'] : $todo->date;?></td>
        <td><?php echo $lang->todo->typeList[$todo->type];?></td>
        <td><span class='<?php echo 'pri' . zget($lang->todo->priList, $todo->pri, $todo->pri);?>'><?php echo zget($lang->todo->priList, $todo->pri, $todo->pri);?></span></td>
        <td class='text-left'>
          <?php echo ($todo->private and $this->app->user->account != $todo->account) ? $todo->name : html::a($this->createLink('todo', 'view', "id=$todo->id&from=company", '', true), $todo->name, '', "class='iframe'");?>
        </td>
        <td><?php echo $todo->begin;?></td>
        <td><?php echo $todo->end;?></td>
        <td class='<?php echo $todo->status;?>'><?php echo $lang->todo->statusList[$todo->status];?></td>
      </tr>
      <?php endforeach;?>
      </tbody>
    </table>

    <?php if($todos):?>
    <div class="table-footer"><?php $pager->show('right', 'pagerjs');?></div>
    <?php endif;?>

  </form>
</div>
<script>
$(function(){$('#<?php echo $type?>').addClass('active');})
</script>
<?php include '../../common/view/footer.html.php';?>
