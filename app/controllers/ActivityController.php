<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class ActivityController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for activity
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Activity', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "activityid";

        $activity = Activity::find($parameters);
        if (count($activity) == 0) {
            $this->flash->notice("The search did not find any activity");

            $this->dispatcher->forward([
                "controller" => "activity",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $activity,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a activity
     *
     * @param string $activityid
     */
    public function editAction($activityid)
    {
        if (!$this->request->isPost()) {

            $activity = Activity::findFirstByactivityid($activityid);
            if (!$activity) {
                $this->flash->error("activity was not found");

                $this->dispatcher->forward([
                    'controller' => "activity",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->activityid = $activity->activityid;

            $this->tag->setDefault("activityid", $activity->activityid);
            $this->tag->setDefault("activityname", $activity->activityname);
            $this->tag->setDefault("activitydescription", $activity->activitydescription);
            $this->tag->setDefault("activitydate", $activity->activitydate);
            $this->tag->setDefault("activityplace", $activity->activityplace);
            
        }
    }

    /**
     * Creates a new activity
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "activity",
                'action' => 'index'
            ]);

            return;
        }

        $activity = new Activity();
        $activity->activityname = $this->request->getPost("activityname");
        $activity->activitydescription = $this->request->getPost("activitydescription");
        $activity->activitydate = $this->request->getPost("activitydate");
        $activity->activityplace = $this->request->getPost("activityplace");
        

        if (!$activity->save()) {
            foreach ($activity->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "activity",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("activity was created successfully");

        $this->dispatcher->forward([
            'controller' => "activity",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a activity edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "activity",
                'action' => 'index'
            ]);

            return;
        }

        $activityid = $this->request->getPost("activityid");
        $activity = Activity::findFirstByactivityid($activityid);

        if (!$activity) {
            $this->flash->error("activity does not exist " . $activityid);

            $this->dispatcher->forward([
                'controller' => "activity",
                'action' => 'index'
            ]);

            return;
        }

        $activity->activityname = $this->request->getPost("activityname");
        $activity->activitydescription = $this->request->getPost("activitydescription");
        $activity->activitydate = $this->request->getPost("activitydate");
        $activity->activityplace = $this->request->getPost("activityplace");
        

        if (!$activity->save()) {

            foreach ($activity->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "activity",
                'action' => 'edit',
                'params' => [$activity->activityid]
            ]);

            return;
        }

        $this->flash->success("activity was updated successfully");

        $this->dispatcher->forward([
            'controller' => "activity",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a activity
     *
     * @param string $activityid
     */
    public function deleteAction($activityid)
    {
        $activity = Activity::findFirstByactivityid($activityid);
        if (!$activity) {
            $this->flash->error("activity was not found");

            $this->dispatcher->forward([
                'controller' => "activity",
                'action' => 'index'
            ]);

            return;
        }

        if (!$activity->delete()) {

            foreach ($activity->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "activity",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("activity was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "activity",
            'action' => "index"
        ]);
    }

}
