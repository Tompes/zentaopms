<?php
$lang->gitlab = new stdclass;
$lang->gitlab->common        = 'GitLab';
$lang->gitlab->browse        = '浏览GitLab';
$lang->gitlab->create        = '添加GitLab';
$lang->gitlab->edit          = '编辑GitLab';
$lang->gitlab->view          = '查看GitLab';
$lang->gitlab->bindUser      = '绑定用户';
$lang->gitlab->webhook       = 'webhook';
$lang->gitlab->bindProduct   = '关联产品';
$lang->gitlab->importIssue   = '关联issue';
$lang->gitlab->delete        = '删除GitLab';
$lang->gitlab->confirmDelete = '确认删除该GitLab吗？';
$lang->gitlab->gitlabAccount = 'GitLab用户';
$lang->gitlab->zentaoAccount = '禅道用户';
$lang->gitlab->bindingStatus = '绑定状态';
$lang->gitlab->binded        = '已绑定';
$lang->gitlab->serverFail    = '连接GitLab服务器异常，请检查GitLab服务器。';
$lang->gitlab->lastUpdate    = '最后更新';

$lang->gitlab->browseAction  = 'GitLab列表';
$lang->gitlab->deleteAction  = '删除GitLab';
$lang->gitlab->gitlabProject = "{$lang->gitlab->common}项目";
$lang->gitlab->browseProject = "{$lang->gitlab->common}项目列表";
$lang->gitlab->gitlabIssue   = "{$lang->gitlab->common} issue";
$lang->gitlab->zentaoProduct = '禅道产品';
$lang->gitlab->objectType    = '类型'; // task, bug, story

$lang->gitlab->id             = 'ID';
$lang->gitlab->name           = "{$lang->gitlab->common}名称";
$lang->gitlab->url            = '服务地址';
$lang->gitlab->token          = 'Token';
$lang->gitlab->defaultProject = '默认项目';
$lang->gitlab->private        = 'MD5验证';

$lang->gitlab->lblCreate  = '添加GitLab服务器';
$lang->gitlab->desc       = '描述';
$lang->gitlab->tokenFirst = 'Token不为空时，优先使用Token。';
$lang->gitlab->tips       = '使用密码时，请在GitLab全局安全设置中禁用"防止跨站点请求伪造"选项。';

$lang->gitlab->placeholder = new stdclass;
$lang->gitlab->placeholder->name  = '';
$lang->gitlab->placeholder->url   = "请填写Gitlab Server首页的访问地址，如：https://gitlab.zentao.net。";
$lang->gitlab->placeholder->token = "请填写具有admin权限账户的access token";

$lang->gitlab->noImportableIssues = "目前没有可供导入的issue。";
$lang->gitlab->tokenError         = "当前token非管理员权限。";
$lang->gitlab->tokenLimit         = "GitLab Token权限不足。请更换为有管理员权限的GitLab Token。";
$lang->gitlab->hostError          = "无效的GitLab服务地址。";
$lang->gitlab->bindUserError      = "不能重复绑定用户 %s";
$lang->gitlab->importIssueError   = "未选择该issue所属的执行。";
$lang->gitlab->importIssueWarn    = "存在导入失败的issue，可再次尝试导入。";

$lang->gitlab->project = new stdclass;
$lang->gitlab->project->id                         = "项目ID";
$lang->gitlab->project->name                       = "项目名称";
$lang->gitlab->project->create                     = "添加{$lang->gitlab->gitlabProject}";
$lang->gitlab->project->edit                       = "编辑{$lang->gitlab->gitlabProject}";
$lang->gitlab->project->url                        = "项目 URL";
$lang->gitlab->project->path                       = "项目标识串";
$lang->gitlab->project->description                = "项目描述";
$lang->gitlab->project->visibility                 = "可见性级别";
$lang->gitlab->project->visibilityList['private']  = "私有(项目访问必须明确授予每个用户。 如果此项目是在一个群组中，群组成员将会获得访问权限)";
$lang->gitlab->project->visibilityList['internal'] = "内部(除外部用户外，任何登录用户均可访问该项目)";
$lang->gitlab->project->visibilityList['public']   = "公开(该项目允许任何人访问)";
$lang->gitlab->project->star                       = "星标";
$lang->gitlab->project->fork                       = "派生";
$lang->gitlab->project->mergeRequests              = "合并请求";
$lang->gitlab->project->issues                     = "议题";
$lang->gitlab->project->tagList                    = "主题";
$lang->gitlab->project->tagListTips                = "用逗号分隔主题。";
$lang->gitlab->project->emptyError                 = "项目名称或标识符不能为空";
$lang->gitlab->project->confirmDelete              = '确认删除该GitLab项目吗？';
