<?php
namespace Omeka\Controller\Admin;

use Omeka\Api\ResponseFilter;
use Omeka\Form\ItemForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ItemController extends AbstractActionController
{
    public function indexAction()
    {
        return $this->redirect()->toRoute('admin/default', array(
            'controller' => 'item',
            'action' => 'browse',
        ));
    }

    public function browseAction()
    {
        $view = new ViewModel;
        $page = $this->params()->fromQuery('page', 1);
        $response = $this->api()->search('items', array('page' => $page));
        $items = $response->getContent();

        $this->paginator($response->getTotalResults(), $page);

        $view->setVariable('items', $items);
        return $view;
    }

    public function addAction()
    {
        $view = new ViewModel;
        $response = $this->api()->search('resource_classes');
        $resourceClasses = $response->getContent();
        $resourceClassPairs = array();
        foreach ($resourceClasses as $resourceClass) {
            $resourceClassPairs[$resourceClass->getId()] = $resourceClass->getLabel();
        }
        
        $auth = $this->getServiceLocator()->get('Omeka\AuthenticationService');
        $currentUser = $auth->getIdentity();
        $ownerId = $currentUser->getId();

        $form = new ItemForm($resourceClassPairs, $ownerId);
        $view->setVariable('form', $form);

        if ($this->getRequest()->isPost()) {
            $response = $this->api()->create('items', $this->params()->fromPost());
            if ($response->isError()) {
                $view->setVariable('errors', $response->getErrors());
            } else {
                $view->setVariable('item', $response->getContent());
            }
        }
        return $view;
    }

    public function editAction()
    {}
}
