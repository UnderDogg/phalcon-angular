<?php

namespace Modules\Administrations\Controllers;

use Bitfalls\Phalcon\ControllerBase;
use Services\AdministrationsService;

/**
 * Class AdministrationsController
 */
class AdministrationsController extends ControllerBase
{

    public function indexAction()
    {

    }

    public function listAction()
    {
        $aSearchParams = $this->buildSearchParams(array(
            'q' => 'string', 'administrationid' => 'int'
        ), array());

        /** @var AdministrationsService $oService */
        $oService = $this->di->get('administrationsService');
        $oResult = $oService->search($aSearchParams);

        $aResult = $oResult->getData();

        foreach ($aResult as $i => &$aRow) {
            /** @var \Administrations $oAdministration */
            $oAdministration = \Administrations::findFirst(array("administrationid=1"));
           /*
            if (!$oAdministration->user && $oAdministration->mainFor) {
                $oAdministration->setUserId($oAdministration->mainFor->getId());
                $oAdministration->save();
            }
          */
            $aResult[$i] = $oAdministration;
        }

        $oResult->setData($aResult);

        $this->view->setVar('result', $oResult);
        $this->setupPagination($oResult, '/admin/administrations/list');

    }

    public function upsertAction()
    {
        $oAdministrationsModel = new \Administrations();
        $administrationid = $this->getParam('id', null, 'digit');
        if ($administrationid) {
            $oAdministrationsModel = $oAdministrationsModel->findFirst(
                array('administrationid = :id:', 'bind' => array('id' => $administrationid))
            );
            $this->view->setVar('sHeading', 'Edit the administration "' . $oAdministrationsModel->getCompanyName() . '"');
        } else {
            $this->view->setVar('sHeading', 'Insert a new administration');
        }

        try {
            if ($this->request->isPost()) {

                if (!filter_var($this->getParam('email', null, null, 'email'), FILTER_VALIDATE_EMAIL)) {
                    throw new \Exception('The email "' . $this->getParam('email') . '" does not seem to be a valid email address.');
                } else {
                    $oAdministrationsModel->setEmail($this->getParam('email'));
                }

                $oAdministrationsModel->setActivated($this->getParam('activated', 0));
                if ($oAdministrationsModel->getActivated() == 1) {
                    $oAdministrationsModel->setActivatedOn(date('Y-m-d H:i:s'));
                } else {
                    $oAdministrationsModel->setActivatedOn(null);
                }
                $oAdministrationsModel->save();

                $this->response->redirect('/admin/administrations/upsert/id/' . $oAdministrationsModel->getId(), true);
            }

        } catch (\Exception $e) {
            $this->view->setVar('errorMessage', $e->getMessage());
            $this->view->setVar('errorCode', $e->getCode());
            $this->view->setVar('stackTrace', $e->getTraceAsString());
        }

        $this->view->setVar('administration', $oAdministrationsModel);
    }

    public function deleteAction()
    {
        try {
            if ($this->getParam('id', null, 'digit')) {
                $oAdministrationModel = new \Administrations();
                $oAdministrationModel->findFirst(array('administrationid = :id:', 'bind' => array('administrationid' => $this->getParam('administrationid'))))->delete();
                $this->redirectBack();
            } else {
                throw new \Exception('ID not found or not valid.');
            }
        } catch (\Exception $e) {
            $this->view->setVar('errorMessage', $e->getMessage());
            $this->view->setVar('errorCode', $e->getCode());
            $this->view->setVar('stackTrace', $e->getTraceAsString());
        }
    }

}

