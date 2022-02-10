<?php
/**
 * The model file of convert module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     convert
 * @version     $Id: model.php 4129 2013-01-18 01:58:14Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php
class convertModel extends model
{
    /**
     * Connect to db.
     * 
     * @access public
     * @return void
     */
    public function connectDB($dbName = '')
    {
        $dsn = "mysql:host={$this->config->db->host}; port={$this->config->db->port};dbname={$dbName}";
        try 
        {
            $dbh = new PDO($dsn, $this->config->db->user, $this->config->db->password);
            $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->exec("SET NAMES {$this->config->db->encoding}");
            $this->sourceDBH = $dbh;
            return $dbh;
        }
        catch (PDOException $exception)
        {
            return $exception->getMessage();
        }
    }
 
    /**
     * Check database exits or not.
     * 
     * @access public
     * @return bool
     */
    public function dbExists($dbName = '')
    {
        $sql = "SHOW DATABASES like '{$dbName}'";
        return $this->dbh->query($sql)->fetch();
    }

    /**
     * Check table exits or not.
     * 
     * @access public
     * @return bool
     */
    public function tableExists($table)
    {
        $sql = "SHOW tables like '$table'";
        return $this->dbh->query($sql)->fetch();
    }

    /**
     * Save the max id of every table. Thus when we convert again, when can delete id larger then the saved max id.
     * 
     * @access public
     * @return void
     */
    public function saveState()
    {
        /* Get user defined tables. */
        $constants     = get_defined_constants(true);
        $userConstants = $constants['user'];

        /* These tables needn't save. */
        unset($userConstants['TABLE_BURN']);
        unset($userConstants['TABLE_GROUPPRIV']);
        unset($userConstants['TABLE_PROJECTPRODUCT']);
        unset($userConstants['TABLE_PROJECTSTORY']);
        unset($userConstants['TABLE_STORYSPEC']);
        unset($userConstants['TABLE_TEAM']);
        unset($userConstants['TABLE_USERGROUP']);
        unset($userConstants['TABLE_STORYSTAGE']);
        unset($userConstants['TABLE_SEARCHDICT']);

        /* Get max id of every table. */
        foreach($userConstants as $key => $value)
        {
            if(strpos($key, 'TABLE') === false) continue;
            if($key == 'TABLE_COMPANY') continue;
            $state[$value] = (int)$this->dao->select('MAX(id) AS id')->from($value)->fetch('id');
        }
        $this->session->set('state', $state);
    }

    public function importJiraFromDB($type = '', $lastID = 0)
    {
        $limit = 1000;
        $nextObject = false;
        if(empty($type)) $type = key($this->lang->convert->jira->objectList);

        foreach($this->lang->convert->jira->objectList as $module => $moduleName)
        {
            if($module != $type and !$nextObject) continue;
            if($module == $type) $nextObject = true;

            while(true)
            {
                $query = $this->buildQuery($module);
            }
        }
    }

    public function buildQuery($module)
    {
        if($module == 'user')
    }
}
