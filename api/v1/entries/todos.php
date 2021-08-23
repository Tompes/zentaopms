<?php
/**
 * 禅道API的todos资源类
 * 版本V1
 *
 * The todos entry point of zentaopms
 * Version 1
 */
class todosEntry extends entry
{
    public function get()
    {
        $control = $this->loadController('my', 'todo');
        $control->todo($this->param('date', 'all'), $this->param('user', ''), $this->param('status', 'all'), $this->param('order', 'date_desc'), 0, $this->param('total', 0), $this->param('limit', 20), $this->param('page', 1));
        $data = $this->getData();

        if(!isset($data->status)) return $this->sendError(400, 'error');
        if(isset($data->status) and $data->status == 'fail') return $this->sendError(400, $data->message);

        $pager  = $data->data->pager;
        $result = array();
        foreach($data->data->todos as $todo)
        {
            $result[] = $this->format($todo, 'assignedDate:time,finishedDate:time,closedDate:time');
        }
        return $this->send(200, array('page' => $pager->pageID, 'total' => $pager->recTotal, 'limit' => $pager->recPerPage, 'todos' => $result));
    }

    public function post()
    {
        $fields = 'name,desc,begin,end,private';
        $this->batchSetPost($fields);

        $this->setPost('date', $this->request('date', date("Y-m-d")));
        $this->setPost('type', $this->request('date', 'custom'));
        $this->setPost('pri', $this->request('pri', '3'));
        $this->setPost('status', $this->request('status', 'wait'));

        $control = $this->loadController('todo', 'create');
        $this->requireFields('name');

        $control->create();

        $data = $this->getData();
        if(isset($data->result) and $data->result == 'fail') return $this->sendError(400, $data->message);
        if(isset($data->result) and !isset($data->id)) return $this->sendError(400, $data->message);

        $todo = $this->loadModel('todo')->getByID($data->id);
        
        $this->send(201, $this->format($todo, 'assignedDate:time,finishedDate:time,closedDate:time'));
    }

}
