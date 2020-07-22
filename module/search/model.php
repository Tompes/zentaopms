<?php
/**
 * The model file of search module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     search
 * @version     $Id: model.php 5082 2013-07-10 01:14:45Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
class searchModel extends model
{

    /**
     * Set search params to session. 
     * 
     * @param  array    $searchConfig 
     * @access public
     * @return void
     */
    public function setSearchParams($searchConfig)
    {
        $module = $searchConfig['module'];
        if(isset($this->config->bizVersion))
        {
            $flowModule = $module;
            if($module == 'projectStory') $flowModule = 'story';
            if($module == 'projectBug')   $flowModule = 'bug';

            $fields = $this->loadModel('workflowfield')->getList($flowModule);

            foreach($fields as $field)
            {
                /* The built-in modules and user defined modules all have the subStatus field, so set its configuration first. */
                if($field->field == 'subStatus')
                {
                    $field = $this->workflowfield->getByField($flowModule, 'subStatus');

                    $searchConfig['fields'][$field->field] = $field->name;
                    $searchConfig['params'][$field->field] = array('operator' => '=', 'control' => 'select', 'values' => $field->options);

                    continue;
                }

                /* The other built-in fields do not need to set their configuration. */
                if($field->buildin) continue;

                /* Set configuration for user defined fields. */
                $operator = ($field->control == 'input' or $field->control == 'textarea') ? 'include' : '=';
                $control  = ($field->control == 'select' or $field->control == 'radio' or $field->control == 'checkbox') ? 'select' : 'input';
                $options  = $this->workflowfield->getFieldOptions($field);

                $searchConfig['fields'][$field->field] = $field->name;
                $searchConfig['params'][$field->field] = array('operator' => $operator, 'control' => $control,  'values' => $options);
            }
        }

        $searchParams['module']       = $searchConfig['module'];
        $searchParams['searchFields'] = json_encode($searchConfig['fields']);
        $searchParams['fieldParams']  = json_encode($searchConfig['params']);
        $searchParams['actionURL']    = $searchConfig['actionURL'];
        $searchParams['style']        = zget($searchConfig, 'style', 'full');
        $searchParams['onMenuBar']    = zget($searchConfig, 'onMenuBar', 'no');
        $searchParams['queryID']      = isset($searchConfig['queryID']) ? $searchConfig['queryID'] : 0;

        $this->session->set($module . 'searchParams', $searchParams);
    }

    /**
     * Build the query to execute.
     * 
     * @access public
     * @return void
     */
    public function buildQuery()
    {
        /* Init vars. */
        $where        = '';
        $groupItems   = $this->config->search->groupItems;
        $groupAndOr   = strtoupper($this->post->groupAndOr);
        $module       = $this->session->searchParams['module'];
        $searchParams = $module . 'searchParams';
        $fieldParams  = json_decode($_SESSION[$searchParams]['fieldParams']);
        $scoreNum     = 0;

        if($groupAndOr != 'AND' and $groupAndOr != 'OR') $groupAndOr = 'AND';

        for($i = 1; $i <= $groupItems * 2; $i ++)
        {
            /* The and or between two groups. */
            if($i == 1) $where .= '(( 1  ';
            if($i == $groupItems + 1) $where .= " ) $groupAndOr ( 1 ";

            /* Set var names. */
            $fieldName    = "field$i";
            $andOrName    = "andOr$i";
            $operatorName = "operator$i";
            $valueName    = "value$i";

            /* Fix bug #2704. */
            $field = $this->post->$fieldName;
            if(isset($fieldParams->$field) and $fieldParams->$field->control == 'input' and $this->post->$valueName === '0') $this->post->$valueName = 'ZERO';

            /* Skip empty values. */
            if($this->post->$valueName == false) continue;
            if($this->post->$valueName == 'ZERO') $this->post->$valueName = 0;   // ZERO is special, stands to 0.
            if(isset($fieldParams->$field) and $fieldParams->$field->control == 'select' and $this->post->$valueName == 'null') $this->post->$valueName = '';   // Null is special, stands to empty if control is select. Fix bug #3279.

            $scoreNum += 1;

            /* Set and or. */
            $andOr = strtoupper($this->post->$andOrName);
            if($andOr != 'AND' and $andOr != 'OR') $andOr = 'AND';

            /* Set operator. */
            $value    = trim($this->post->$valueName);
            $operator = $this->post->$operatorName;
            if(!isset($this->lang->search->operators[$operator])) $operator = '=';

            /* Set condition. */
            $condition = '';
            if($operator == "include")
            {
                $condition = ' LIKE ' . $this->dbh->quote("%$value%");
            }
            elseif($operator == "notinclude")
            {
                $condition = ' NOT LIKE ' . $this->dbh->quote("%$value%"); 
            }
            elseif($operator == 'belong')
            {
                if($this->post->$fieldName == 'module')
                {
                    $allModules = $this->loadModel('tree')->getAllChildId($value);
                    if($allModules) $condition = helper::dbIN($allModules);
                }
                elseif($this->post->$fieldName == 'dept')
                {
                    $allDepts = $this->loadModel('dept')->getAllChildId($value);
                    $condition = helper::dbIN($allDepts);
                }
                else
                {
                    $condition = ' = ' . $this->dbh->quote($value) . ' ';
                }
            }
            else
            {
                if($operator == 'between' and !isset($this->config->search->dynamic[$value])) $operator = '=';
                $condition = $operator . ' ' . $this->dbh->quote($value) . ' ';
            }

            /* Processing query criteria. */
            if($operator == '=' and preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', $value))
            {
                $condition  = '`' . $this->post->$fieldName . "` >= '$value' AND `" . $this->post->$fieldName . "` <= '$value 23:59:59'";
                $where     .= " $andOr ($condition)";
            }
            elseif($operator == '<=' and preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', $value))
            {
                $where .= " $andOr " . '`' . $this->post->$fieldName . "` <= '$value 23:59:59'";
            }
            elseif($condition)
            {
                $where .= " $andOr " . '`' . $this->post->$fieldName . '` ' . $condition;
            }
        }

        $where .=" ))";
        $where  = $this->replaceDynamic($where);

        /* Save to session. */
        $querySessionName = $this->post->module . 'Query';
        $formSessionName  = $this->post->module . 'Form';
        $this->session->set($querySessionName, $where);
        $this->session->set($formSessionName,  $_POST);
        if($scoreNum > 2 && !dao::isError()) $this->loadModel('score')->create('search', 'saveQueryAdvanced');
    }

    /**
     * Init the search session for the first time search.
     * 
     * @param  string   $module 
     * @param  array    $fields 
     * @param  array    $fieldParams 
     * @access public
     * @return void
     */
    public function initSession($module, $fields, $fieldParams)
    {
        $formSessionName  = $module . 'Form';
        if(isset($_SESSION[$formSessionName]) and $_SESSION[$formSessionName] != false) return;

        for($i = 1; $i <= $this->config->search->groupItems * 2; $i ++)
        {
            /* Var names. */
            $fieldName    = "field$i";
            $andOrName    = "andOr$i";
            $operatorName = "operator$i";
            $valueName    = "value$i";

            $currentField = key($fields);
            $operator     = isset($fieldParams[$currentField]['operator']) ? $fieldParams[$currentField]['operator'] : '=';

            $queryForm[$fieldName]    = key($fields);
            $queryForm[$andOrName]    = 'and';
            $queryForm[$operatorName] = $operator;
            $queryForm[$valueName]    =  '';

            if(!next($fields)) reset($fields);
        }
        $queryForm['groupAndOr'] = 'and';
        $this->session->set($formSessionName, $queryForm);
    }

    /**
     * Set default params for selection.
     * 
     * @param  array  $fields 
     * @param  array  $params 
     * @access public
     * @return array
     */
    public function setDefaultParams($fields, $params)
    {
        $hasProduct = false;
        $hasProject = false;
        $hasUser    = false;

        $fields = array_keys($fields);
        foreach($fields as $fieldName)
        {
            if(empty($params[$fieldName])) continue;
            if($params[$fieldName]['values'] == 'products') $hasProduct = true;
            if($params[$fieldName]['values'] == 'users')    $hasUser    = true;
            if($params[$fieldName]['values'] == 'projects') $hasProject = true;
        }

        if($hasUser)
        {
            $users = $this->loadModel('user')->getPairs('realname|noclosed');
            $users['$@me'] = $this->lang->search->me;
        }
        if($hasProduct) $products = array('' => '') + $this->loadModel('product')->getPairs();
        if($hasProject) $projects = array('' => '') + $this->loadModel('project')->getPairs();

        foreach($fields as $fieldName)
        {
            if(!isset($params[$fieldName])) $params[$fieldName] = array('operator' => '=', 'control' => 'input', 'values' => '');
            if($params[$fieldName]['values'] == 'users')    $params[$fieldName]['values']  = $users;
            if($params[$fieldName]['values'] == 'products') $params[$fieldName]['values']  = $products;
            if($params[$fieldName]['values'] == 'projects') $params[$fieldName]['values']  = $projects;
            if(is_array($params[$fieldName]['values']))
            {
                /* For build right sql when key is 0 and is not null.  e.g. confirmed field. */
                if(isset($params[$fieldName]['values'][0]) and $params[$fieldName]['values'][0] !== '')
                {
                    $params[$fieldName]['values'] = array('ZERO' => $params[$fieldName]['values'][0]) + $params[$fieldName]['values'];
                    unset($params[$fieldName]['values'][0]);
                }
                elseif(empty($params[$fieldName]['values']))
                {
                    $params[$fieldName]['values'] = array('' => '', 'null' => $this->lang->search->null);
                }
                else
                {
                    $params[$fieldName]['values'] = $params[$fieldName]['values'] + array('null' => $this->lang->search->null);
                }
            }
        }
        return $params;
    }

    /**
     * Get a query.
     * 
     * @param  int    $queryID 
     * @access public
     * @return string
     */
    public function getQuery($queryID)
    {
        $query = $this->dao->findByID($queryID)->from(TABLE_USERQUERY)->fetch();
        if(!$query) return false;

        /* Decode html encode. */
        $query->form = htmlspecialchars_decode($query->form, ENT_QUOTES);
        $query->sql  = htmlspecialchars_decode($query->sql, ENT_QUOTES);

        $hasDynamic  = strpos($query->form, '$') !== false;
        $query->form = unserialize($query->form);
        if($hasDynamic)
        {
            $_POST = $query->form;
            $this->buildQuery();
            $querySessionName = $query->form['module'] . 'Query';
            $query->sql = $_SESSION[$querySessionName];
        }
        return $query;
    }

    /**
     * Save current query to db.
     * 
     * @access public
     * @return void
     */
    public function saveQuery()
    {
        $sqlVar  = $this->post->module  . 'Query';
        $formVar = $this->post->module  . 'Form';
        $sql     = $_SESSION[$sqlVar];
        if(!$sql) $sql = ' 1 = 1 ';

        $query = fixer::input('post')
            ->add('account', $this->app->user->account)
            ->add('form', serialize($_SESSION[$formVar]))
            ->add('sql',  $sql)
            ->skipSpecial('sql,form')
            ->remove('onMenuBar')
            ->get();
        if($this->post->onMenuBar) $query->shortcut = 1;
        $this->dao->insert(TABLE_USERQUERY)->data($query)->autoCheck()->check('title', 'notempty')->exec();

        if(!dao::isError())
        {
            $queryID = $this->dao->lastInsertID();
            if(!dao::isError()) $this->loadModel('score')->create('search', 'saveQuery', $queryID);
            return $queryID;
        }
        return false;
    }

    /**
     * Delete current query from db.
     *
     * @param  int    $queryID
     * @access public
     * @return void
     */
    public function deleteQuery($queryID)
    {
        $this->dao->delete()->from(TABLE_USERQUERY)->where('id')->eq($queryID)->andWhere('account')->eq($this->app->user->account)->exec();
        die('success');
    }

    /**
     * Get title => id pairs of a user.
     * 
     * @param  string    $module 
     * @access public
     * @return array
     */
    public function getQueryPairs($module)
    {
        $queries = $this->dao->select('id, title')
            ->from(TABLE_USERQUERY)
            ->where('account')->eq($this->app->user->account)
            ->andWhere('module')->eq($module)
            ->orderBy('id_desc')
            ->fetchPairs();
        if(!$queries) return array('' => $this->lang->search->myQuery);
        $queries = array('' => $this->lang->search->myQuery) + $queries;
        return $queries;
    }

    /**
     * Get records by the condition.
     * 
     * @param  string    $module 
     * @param  string    $moduleIdList
     * @param  string    $conditions 
     * @access public
     * @return array
     */
    public function getBySelect($module, $moduleIdList, $conditions)
    {
        if($module == 'story')
        {
            $pairs = 'id,title';
            $table = TABLE_STORY;
        }
        else if($module == 'task')
        {
            $pairs = 'id,name';
            $table = TABLE_TASK;
        }
        $query    = '`' . $conditions['field1'] . '`';
        $operator = $conditions['operator1'];
        $value    = $conditions['value1'];
        
        if(!isset($this->lang->search->operators[$operator])) $operator = '=';
        if($operator == "include")
        {
            $query .= ' LIKE ' . $this->dbh->quote("%$value%");
        }
        elseif($operator == "notinclude")
        {
            $where .= ' NOT LIKE ' . $this->dbh->quote("%$value%"); 
        }
        else
        {
            $query .= $operator . ' ' . $this->dbh->quote($value) . ' ';
        }
        
        foreach($moduleIdList as $id)
        {
            if(!$id) continue;
            $title = $this->dao->select($pairs)
                ->from($table)
                ->where('id')->eq((int)$id)
                ->andWhere($query)
                ->fetch();
            if($title) $results[$id] = $title;
        }
        if(!isset($results)) return array();
        return $this->formatResults($results, $module);
    }

    /**
     * Format the results.
     * 
     * @param  array    $results 
     * @param  string   $module 
     * @access public
     * @return array
     */
    public function formatResults($results, $module)
    {
        /* Get title field. */
        $title = ($module == 'story') ? 'title' : 'name';
        $resultPairs = array('' => '');
        foreach($results as $result) $resultPairs[$result->id] = $result->id . ':' . $result->$title;
        return $resultPairs;
    }

    /**
      Replace dynamic account and date. 
     * 
     * @param  string $query 
     * @access public
     * @return string 
     */
    public function replaceDynamic($query)
    {
        $this->app->loadClass('date');
        $lastWeek  = date::getLastWeek();
        $thisWeek  = date::getThisWeek();
        $lastMonth = date::getLastMonth();
        $thisMonth = date::getThisMonth();
        $yesterday = date::yesterday();
        $today     = date(DT_DATE1);
        if(strpos($query, '$') !== false)
        {
            $query = str_replace('$@me', $this->app->user->account, $query);
            $query = str_replace("'\$lastMonth'", "'" . $lastMonth['begin']      . "' and '" . $lastMonth['end']        . "'", $query);
            $query = str_replace("'\$thisMonth'", "'" . $thisMonth['begin']      . "' and '" . $thisMonth['end']        . "'", $query);
            $query = str_replace("'\$lastWeek'",  "'" . $lastWeek['begin']       . "' and '" . $lastWeek['end']         . "'", $query);
            $query = str_replace("'\$thisWeek'",  "'" . $thisWeek['begin']       . "' and '" . $thisWeek['end']         . "'", $query);
            $query = str_replace("'\$yesterday'", "'" . $yesterday . ' 00:00:00' . "' and '" . $yesterday . ' 23:59:59' . "'", $query);
            $query = str_replace("'\$today'",     "'" . $today     . ' 00:00:00' . "' and '" . $today     . ' 23:59:59' . "'", $query);
        }
        return $query;
    }
}
