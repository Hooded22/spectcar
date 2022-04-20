<?php
class TransactionController extends BaseController
{
    public function findAllAction()
    {
        if(!$this->validateMethod('GET')) {
            return;
        }

        $strErrorDesc = null;
        $strErrorHeader = null;
        $responseData = '';

        try {
            $transacitiomn = new TransactionModel();
            $responseData = json_encode($transacitiomn->getAll());
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        } finally {
            $this->responseData($responseData, $strErrorDesc, $strErrorHeader);
        }
    }

    public function findByIdAction() {
        
    }
}