<?php
/**
 * The browse view file of repo module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @author      Wang Yidong, Zhu Jinyong
 * @package     repo
 * @version     $Id: browse.html.php $
 */
?>
<?php include '../../common/view/header.html.php';?>
<div id='mainMenu' class='clearfix'>
  <div class='btn-toolbar pull-left'>
    <div class='btn-group group'>
      <button data-toggle='dropdown' type='button' class='btn btn-link btn-limit repo-select text-ellipsis' title='<?php $repos[$repoID];?>'>
        <span class='text'><?php echo $repos[$repoID];?></span>
        <span class='caret' style='margin-bottom: -1px'></span>
      </button>
      <div id='dropMenuRepo' class='dropdown-menu search-list' data-ride='searchList' data-url=''>
        <div class="input-control search-box has-icon-left has-icon-right search-example">
        <input type="search" class="form-control search-input" id="searchSource"/>
          <label class="input-control-icon-left search-icon"><i class="icon icon-search"></i></label>
          <a class="input-control-icon-right search-clear-btn"><i class="icon icon-close icon-sm"></i></a>
        </div>
        <div class="table-row">
          <div class="table-col col-left">
            <div class="list-group" id="repoList">
              <ul class='tree tree-angles' data-ride='tree'>
              <?php foreach($reposGroup as $groupName => $group):?>
              <?php if(empty($group)) continue;?>
                <li data-idx='<?php echo $groupName;?>' data-id='<?php echo $groupName;?>' class='has-list open in' style='cursor: pointer;'><i class='list-toggle icon'></i>
                  <div class='hide-in-search'><a class='text-muted'><?php echo $groupName;?></a><span class='label label-outline' style='margin-left:5px;'><?php echo $lang->repo->type;?></span></div>
                  <ul data-idx='<?php echo $groupName;?>'>
                  <?php
                  foreach($group as $id => $repoName)
                  {
                      $isSelected = $id == $repoID ? 'selected' : '';
                      $link = $this->createLink('repo', 'browse', "repoID=$id&branchID=&objectID=$objectID");
                      echo "<li data-idx='$repoName' data-id='$groupName-$repoName'><a href='{$link}' id='$groupName-$repoName' class='$isSelected text-ellipsis' title='$repoName' data-key='$repoName' data-app='{$app->tab}'>$repoName</a></li>";
                  }
                  ?>
                  </ul>
                </li>
              <?php endforeach;?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php if(!empty($branches)):?>
    <div class='btn-group'>
      <a href='javascript:;' class='btn btn-link btn-limit text-ellipsis' data-toggle='dropdown' style="max-width: 120px;"><span class='text' title='<?php echo $branches[$branchID];?>'><?php echo $branches[$branchID];?></span> <span class='caret'></span></a>
      <ul class='dropdown-menu' style='max-height:240px; max-width: 300px; overflow-y:auto'>
        <?php
        foreach($branches as $id => $branchName)
        {
            $isSelected = $id == $branchID ? 'class="selected"' : '';
            $base64BranchID = helper::safe64Encode(base64_encode($id));
            echo "<li $isSelected>" . html::a($this->createLink('repo', 'browse', "repoID=$repoID&branchID=$base64BranchID&objectID=$objectID"), $branchName, '', "title='{$branchName}' class='text-ellipsis' data-app='{$app->tab}'") . "</li>";
        }
        ?>
      </ul>
    </div>
    <?php endif;?>
    <div class="page-title">
      <strong>
        <?php
        $base64BranchID = helper::safe64Encode(base64_encode($branchID));
        echo html::a($this->repo->createLink('browse', "repoID=$repoID&branchID=$base64BranchID&objectID=$objectID"), $repo->name, '', "data-app='{$app->tab}'");
        $paths= explode('/', $path);
        $fileName = array_pop($paths);
        $postPath = '';
        foreach($paths as $pathName)
        {
            $postPath .= $pathName . '/';
            echo '/' . ' ' . html::a($this->repo->createLink('browse', "repoID=$repoID&branchID=$base64BranchID&objectID=$objectID&path=" . $this->repo->encodePath($postPath)), trim($pathName, '/'), '', "data-app='{$app->tab}'");
        }
        echo '/' . ' ' . $fileName;
        ?>
      </strong>
    </div>
  </div>
  <div class="btn-toolbar pull-right">
    <span class='last-sync-time'><?php echo $lang->repo->notice->lastSyncTime . $cacheTime?></span>
    <?php echo html::a($this->repo->createLink('browse', "repoID=$repoID&branchID=" . $base64BranchID . "&objectID=$objectID&path=" . $this->repo->encodePath($path) . "&revision=$revision&refresh=1"), "<i class='icon icon-refresh'></i> " . $lang->refresh, '', "class='btn btn-primary' data-app={$app->tab}");?>
    <?php if($repo->SCM == 'Gitlab' and common::hasPriv('gitlab', 'createBranch')) echo html::a($this->createLink('gitlab', 'createBranch', "gitlabID={$repo->gitlab}&projectID={$repo->project}"), "<i class='icon icon-sm icon-plus'></i> " . $lang->gitlab->createBranch, '', "class='btn btn-primary'");?>
  </div>
</div>
<div id="mainContent" class="main-row fade">
  <div class="main-col main-table">
    <table class='table table-fixed'>
      <thead>
        <tr>
          <th class='c-icon'></th>
          <th class='c-name'><?php echo $lang->repo->name?></th>
          <th class='text-center c-version'><?php echo $lang->repo->revisions?></th>
          <th class='c-date'><?php echo $lang->repo->time?></th>
          <th class='c-user'><?php echo $lang->repo->committer?></th>
          <th><?php echo $lang->repo->comment?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($infos as $info):?>
        <?php if(empty($info->name)) continue;?>
        <tr>
          <td class="icon">
            <span class="<?php echo $info->kind == 'dir' ? 'directory' : 'file';?> mini-icon"></span>
          </td>
          <td>
          <?php
          $infoPath = trim($path . '/' . $info->name, '/');
          $link = $info->kind == 'dir' ? $this->repo->createLink('browse', "repoID=$repoID&branchID=$base64BranchID&objectID=$objectID&path=" . $this->repo->encodePath($infoPath)) : $this->repo->createLink('view', "repoID=$repoID&objectID=$objectID&entry=" . $this->repo->encodePath($infoPath));
          echo html::a($link, $info->name, '', "title='{$info->name}' data-app={$app->tab}");
          ?>
          </td>
          <td align='center'><?php echo $repo->SCM == 'Subversion' ? $info->revision : substr($info->revision, 0, 10);?></td>
          <td><?php echo substr($info->date, 0, 10)?></td>
          <td><?php echo $info->account?></td>
          <?php $comment = htmlSpecialString($info->comment, ENT_QUOTES);?>
          <td class='comment' title='<?php echo $comment?>'><?php echo $comment?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
  <div class="side-col" id="sidebar">
    <div class="sidebar-toggle"><i class="icon icon-angle-right"></i></div>
    <div class='side-body'><?php include 'ajaxsidecommits.html.php';?></div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
