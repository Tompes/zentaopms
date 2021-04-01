<?php
/* Actions. */
$lang->project->createGuide       = '選擇項目模板';
$lang->project->index             = '項目儀表盤';
$lang->project->home              = '項目主頁';
$lang->project->create            = '創建項目';
$lang->project->edit              = '編輯項目';
$lang->project->batchEdit         = '批量編輯項目';
$lang->project->view              = '項目概況';
$lang->project->batchEdit         = '批量編輯';
$lang->project->browse            = '項目列表';
$lang->project->all               = '所有項目';
$lang->project->start             = '啟動項目';
$lang->project->finish            = '完成項目';
$lang->project->suspend           = '掛起項目';
$lang->project->delete            = '刪除項目';
$lang->project->close             = '關閉項目';
$lang->project->activate          = '激活項目';
$lang->project->group             = '項目權限分組';
$lang->project->createGroup       = '項目創建分組';
$lang->project->editGroup         = '項目編輯分組';
$lang->project->copyGroup         = '項目複製分組';
$lang->project->manageView        = '項目維護視野';
$lang->project->managePriv        = '項目維護權限';
$lang->project->manageMembers     = '項目團隊';
$lang->project->export            = '導出';
$lang->project->addProduct        = '新建產品';
$lang->project->manageGroupMember = '維護分組用戶';
$lang->project->moduleSetting     = '列表設置';
$lang->project->moduleOpen        = '顯示項目集名';
$lang->project->dynamic           = '動態';
$lang->project->execution         = '執行列表';
$lang->project->qa                = '測試儀表盤';
$lang->project->bug               = 'Bug列表';
$lang->project->testcase          = '用例列表';
$lang->project->testtask          = '測試單';
$lang->project->build             = '版本';
$lang->project->updateOrder       = '排序';
$lang->project->sort              = '項目排序';
$lang->project->whitelist         = '項目白名單';
$lang->project->addWhitelist      = '項目添加白名單';
$lang->project->unbindWhitelist   = '項目刪除白名單';
$lang->project->manageProducts    = '關聯產品';
$lang->project->copyTitle         = '請選擇要複製的項目';
$lang->project->errorSameProducts = '項目不能關聯多個相同的產品。';
$lang->project->errorNoProducts   = '最少關聯一個產品';
$lang->project->copyNoProject     = '沒有可用的項目來複制';
$lang->project->searchByName      = '輸入項目名稱進行檢索';
$lang->project->deleted           = '已刪除';
$lang->project->linkedProducts    = '已關聯';
$lang->project->unlinkedProducts  = '未關聯';
$lang->project->testreport        = '測試報告';

/* Fields. */
$lang->project->common             = '項目';
$lang->project->stage              = '階段';
$lang->project->PM                 = '負責人';
$lang->project->name               = '項目名稱';
$lang->project->category           = '項目類型';
$lang->project->desc               = '項目描述';
$lang->project->code               = '項目代號';
$lang->project->copy               = '複製項目';
$lang->project->begin              = '計劃開始';
$lang->project->end                = '計劃完成';
$lang->project->status             = '狀態';
$lang->project->budget             = '預算';
$lang->project->template           = '項目模板';
$lang->project->estimate           = '預計';
$lang->project->consume            = '消耗';
$lang->project->surplus            = '剩餘';
$lang->project->progress           = '進度';
$lang->project->dateRange          = '起止日期';
$lang->project->to                 = '至';
$lang->project->realEnd            = '實際完成日期';
$lang->project->realBegan          = '實際開始日期';
$lang->project->bygrid             = '看板';
$lang->project->bylist             = '列表';
$lang->project->mine               = '我參與的';
$lang->project->myProject          = '我負責：';
$lang->project->other              = '其他：';
$lang->project->acl                = '訪問控制';
$lang->project->setPlanduration    = '設置工期';
$lang->project->auth               = '權限控制';
$lang->project->durationEstimation = '工作量估算';
$lang->project->leftStories        = '剩餘需求';
$lang->project->leftTasks          = '剩餘任務';
$lang->project->leftBugs           = '剩餘Bug';
$lang->project->children           = '子項目';
$lang->project->parent             = '所屬項目集';
$lang->project->allStories         = '總需求';
$lang->project->doneStories        = '已完成';
$lang->project->doneProjects       = '已結束';
$lang->project->allInput           = '項目總投入';
$lang->project->weekly             = '項目周報';
$lang->project->pv                 = 'PV';
$lang->project->ev                 = 'EV';
$lang->project->sv                 = 'SV';
$lang->project->ac                 = 'AC';
$lang->project->cv                 = 'CV';
$lang->project->pvTitle            = '計劃完成';
$lang->project->evTitle            = '實際完成';
$lang->project->svTitle            = '進度偏差';
$lang->project->acTitle            = '實際花費';
$lang->project->cvTitle            = '成本偏差';
$lang->project->teamCount          = '人數';
$lang->project->longTime           = '長期';
$lang->project->future             = '待定';
$lang->project->moreProject        = '更多項目';
$lang->project->days               = '可用工作日';

$lang->project->productNotEmpty        = '請關聯產品或創建產品。';
$lang->project->existProductName       = '產品名稱已存在。';
$lang->project->changeProgram          = '%s > 修改項目集';
$lang->project->changeProgramTip       = '修改項目集後，該項目關聯的產品也會同時修改所屬項目集，請確認是否修改。';
$lang->project->linkedProjectsTip      = '關聯的項目如下';
$lang->project->multiLinkedProductsTip = '該項目關聯的如下產品還關聯了其他項目，請取消關聯後再操作';
$lang->project->linkStoryByPlanTips    = "此操作會將所選計划下面的{$lang->SRCommon}全部關聯到此項目中";
$lang->project->createExecution        = "該項目下沒有{$lang->executionCommon}，請先創建{$lang->executionCommon}";

$lang->project->tenThousand = '萬';

$lang->project->unitList['CNY'] = '人民幣';
$lang->project->unitList['USD'] = '美元';
$lang->project->unitList['HKD'] = '港元';
$lang->project->unitList['NTD'] = '台元';
$lang->project->unitList['EUR'] = '歐元';
$lang->project->unitList['DEM'] = '馬克';
$lang->project->unitList['CHF'] = '瑞士法郎';
$lang->project->unitList['FRF'] = '法國法郎';
$lang->project->unitList['GBP'] = '英鎊';
$lang->project->unitList['NLG'] = '荷蘭盾';
$lang->project->unitList['CAD'] = '加拿大元';
$lang->project->unitList['RUR'] = '盧布';
$lang->project->unitList['INR'] = '盧比';
$lang->project->unitList['AUD'] = '澳大利亞元';
$lang->project->unitList['NZD'] = '新西蘭元';
$lang->project->unitList['THB'] = '泰國銖';
$lang->project->unitList['SGD'] = '新加坡元';

$lang->project->currencySymbol['CNY'] = '¥';
$lang->project->currencySymbol['USD'] = '$';
$lang->project->currencySymbol['HKD'] = 'HK$';
$lang->project->currencySymbol['NTD'] = 'NT$';
$lang->project->currencySymbol['EUR'] = '€';
$lang->project->currencySymbol['DEM'] = 'DEM';
$lang->project->currencySymbol['CHF'] = '₣';
$lang->project->currencySymbol['FRF'] = '₣';
$lang->project->currencySymbol['GBP'] = '£';
$lang->project->currencySymbol['NLG'] = 'ƒ';
$lang->project->currencySymbol['CAD'] = '$';
$lang->project->currencySymbol['RUR'] = '₽';
$lang->project->currencySymbol['INR'] = '₹';
$lang->project->currencySymbol['AUD'] = 'A$';
$lang->project->currencySymbol['NZD'] = 'NZ$';
$lang->project->currencySymbol['THB'] = '฿';
$lang->project->currencySymbol['SGD'] = 'S$';

$lang->project->modelList['scrum']     = "Scrum";
$lang->project->modelList['waterfall'] = "瀑布";

$lang->project->featureBar['all']       = '所有';
$lang->project->featureBar['doing']     = '進行中';
$lang->project->featureBar['wait']      = '未開始';
$lang->project->featureBar['suspended'] = '已掛起';
$lang->project->featureBar['closed']    = '已關閉';

$lang->project->aclList['private'] = "私有 (只有項目團隊成員和干係人可訪問)";
$lang->project->aclList['open']    = "公開 (有項目視圖權限即可訪問)";

$lang->project->acls['private'] = '私有';
$lang->project->acls['open']    = '公開';

$lang->project->authList['extend'] = '繼承 (取系統權限與項目權限的合集)';
$lang->project->authList['reset']  = '重新定義 (只取項目權限)';

$lang->project->statusList['wait']      = '未開始';
$lang->project->statusList['doing']     = '進行中';
$lang->project->statusList['suspended'] = '已掛起';
$lang->project->statusList['closed']    = '已關閉';

$lang->project->endList[31]  = '一個月';
$lang->project->endList[93]  = '三個月';
$lang->project->endList[186] = '半年';
$lang->project->endList[365] = '一年';
$lang->project->endList[999] = '長期';

$lang->project->empty                  = '暫時沒有項目';
$lang->project->accessDenied           = '您無權訪問該項目！';
$lang->project->chooseProgramType      = '選中項目管理模型';
$lang->project->nextStep               = '下一步';
$lang->project->hoursUnit              = '%s 工時';
$lang->project->membersUnit            = '%s人';
$lang->project->lastIteration          = '近期迭代';
$lang->project->ongoingStage           = '進行中的階段';
$lang->project->scrum                  = 'Scrum';
$lang->project->waterfall              = '瀑布';
$lang->project->waterfallTitle         = '瀑布式項目管理';
$lang->project->cannotCreateChild      = '該項目已經有實際的內容，無法直接添加子項目。您可以為當前項目創建一個父項目，然後在新的父項目下面添加子項目。';
$lang->project->confirmDelete          = "您確定要刪除嗎？";
$lang->project->emptyPM                = '暫無';
$lang->project->cannotChangeToCat      = "該項目已經有實際的內容，無法修改為父項目";
$lang->project->cannotCancelCat        = "該項目下已經有子項目，無法取消父項目標記";
$lang->project->parentBeginEnd         = "父項目起止時間：%s ~ %s";
$lang->project->childLongTime          = "子項目中有長期項目，父項目也應該是長期項目";
$lang->project->readjustTime           = '重新調整項目起止時間';
$lang->project->notAllowRemoveProducts = '該產品中的需求已與項目進行了關聯，請取消關聯後再操作。';

$lang->project->programTitle['0']    = '不顯示';
$lang->project->programTitle['base'] = '只顯示一級項目集';
$lang->project->programTitle['end']  = '只顯示最後一級項目集';

$lang->project->accessDenied      = '您無權訪問該項目！';
$lang->project->chooseProgramType = '選擇項目管理方式';
$lang->project->scrumTitle        = '敏捷開發全流程項目管理';
$lang->project->cannotCreateChild = '該項目已經有實際的內容，無法直接添加子項目。您可以為當前項目創建一個父項目，然後在新的父項目下面添加子項目。';
$lang->project->hasChildren       = '該項目有子項目存在，不能刪除。';
$lang->project->confirmDelete     = "您確定刪除項目[%s]嗎？";
$lang->project->cannotChangeToCat = "該項目已經有實際的內容，無法修改為父項目";
$lang->project->cannotCancelCat   = "該項目下已經有子項目，無法取消父項目標記";
$lang->project->parentBeginEnd    = "父項目起止時間：%s ~ %s";
$lang->project->parentBudget      = "父項目預算：";
$lang->project->beginLetterParent = "父項目的開始日期：%s，開始日期不能小於父項目的開始日期";
$lang->project->endGreaterParent  = "父項目的完成日期：%s，完成日期不能大於父項目的完成日期";
$lang->project->beginGreateChild  = "項目集的最小開始日期：%s，項目的開始日期不能小於項目集的最小開始日期";
$lang->project->endLetterChild    = "項目集的最大完成日期：%s，項目的完成日期不能大於項目集的最大完成日期";
$lang->project->childLongTime     = "子項目中有長期項目，父項目也應該是長期項目";
