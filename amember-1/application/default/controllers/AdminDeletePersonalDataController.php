<?php

class AdminDeletePersonalDataController extends Am_Mvc_Controller_Grid
{

    public
        function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission('grid_u');
    }

    public
        function createGrid()
    {
        $query = new Am_Query($this->getDi()->userDeleteRequestTable);

        $query->leftJoin('?_user', 'u', 't.user_id=u.user_id');
        $query->leftJoin('?_admin', 'a', 't.admin_id = a.admin_id');

        $query->addField('u.login', 'login');
        $query->addField('a.login', 'admin');

        $query->setOrderRaw('completed, added');

        $grid = new Am_Grid_Editable('_user_delete_request', ___('Personal Data Delete Requests'), $query, $this->_request, $this->view);

        $grid->addField('added', ___('Added'))->setRenderFunction(function($rec)
        {
            return sprintf("<td>%s</td>", amDatetime($rec->added));
        });

        $grid->addField('user_id', ___('User'))
            ->setRenderFunction(function($rec)
            {
                return sprintf(
                    "<td><a href='%s' target='_top'>%s</a></td>", $this->getDi()->url('admin-users', ['_u_a' => 'edit', '_u_id' => $rec->user_id]), $rec->login
                );
            });

        $grid->addField('remote_addr', ___('IP address'));

        $grid->addField(new Am_Grid_Field_Expandable('errors', ___('Processing Errors')))->setGetFunction(function($record)
        {
            return "<pre>" . $record->errors . "</pre>";
        });

        $grid->addField('processed', ___('Time Processed'))->setRenderFunction(function($rec)
        {
            return sprintf("<td>%s</td>", amDatetime($rec->processed));
        });
        $grid->addField('admin_id', ___('Processed by admin'))->setRenderFunction(function($rec)
        {
            return sprintf("<td>%s</td>", $rec->admin);
        });

        $grid->addCallback(Am_Grid_Editable::CB_TR_ATTRIBS, function(& $ret, $record)
        {
            if ($record->completed)
            {
                $ret['class'] = isset($ret['class']) ? $ret['class'] . ' disabled' : 'disabled';
            }
        });

        $grid->actionsClear();
        $grid->actionAdd(new Am_Grid_Action_Process());
        $grid->addCallback(Am_Grid_Editable::CB_RENDER_STATIC, function(&$out){
            $out = <<<CUT
<pre>
When you click to "process" Delete Request, amember will try to 
    cancel all user's active recurring invoices, 
    unsubscribe user from all newsletter lists, 
    and remove user from all linked third-party scripts. 
On success user's personal data will be anonymized. 
If aMember was unable to cancel invoices/subscirptions automatically, 
you will need to review errors and do everything that is necessary to cancel/unsubscribe manually, 
and then run anonymize process again. 
</pre>
CUT;
        });

        return $grid;
    }

}

class Am_Grid_Action_Process extends Am_Grid_Action_Abstract
{

    use PersonalData;

    function isAvailable($record)
    {
        return !$record->completed;
    }
    function markAsProcessed()
    {
        $rec = $this->grid->getRecord();
        $rec->processed = Am_Di::getInstance()->sqlDateTime;
        $rec->completed = 1;
        $rec->admin_id = Am_Di::getInstance()->authAdmin->getUserId();
        $rec->update();
        return $this->grid->redirectBack();
    }

    public
        function run()
    {
        $this->user = Am_Di::getInstance()->userTable->load($this->grid->getRecord()->user_id, false);
        if ($this->grid->getRequest()->get('confirm'))
        {

            if ($this->grid->getRequest()->get('confirm_errors'))
            {
                $this->anonymizeUser($this->user);
                return $this->markAsProcessed();
            }
            else
            {
                $errors = [];
                switch (Am_Di::getInstance()->config->get('account-removal-method'))
                {
                    case 'delete' :
                        $errors = $this->deleteAction($this->user);
                        break;
                    case 'anonymize' :
                        $errors = $this->anonymizeAction($this->user);
                        break;
                }

                if (!empty($errors))
                {
                    echo $this->renderConfirmation(___('I confirm,  I fixed above errors. Delete Personal Data Now!'), $errors);
                }
                else
                {
                    return $this->markAsProcessed();
                }
            }
        }
        else
        {
            echo $this->renderConfirmation();
        }
    }

    public
        function renderConfirmation($btnText = null, $errors = [])
    {
        $message = Am_Html::escape($this->getConfirmationText());
        if (!empty($errors))
        {
            $errorsText = "<div><p style='color:red;'>"
                . ___('aMember was unable to delete Personal Data automatically. Please review and fix below errors then click to continue')
                . "</p></div>";
            $errorsText .= "<pre>" . implode("\n", $errors) . "</pre>";
            $addHtml = sprintf("<input type='hidden' name='%s_confirm_errors' value='yes'/>", $this->grid->getId());
        }
        else
        {
            $errorsText = $addHtml = '';
        }


        $form = $this->renderConfirmationForm($btnText, $addHtml);
        $back = $this->renderBackButton(___('No, cancel'));
        return <<<CUT
<div class="info">
<p>{$message}{$errorsText}</p>
<br />
<div class="buttons">
$form $back
</div>
</div>
CUT;
    }

    function getConfirmationText()
    {
        return ___("Do you really want to delete Personal Data for user %s?\n"
            . "This action can't be reverted!", $this->user->login);
    }

}
