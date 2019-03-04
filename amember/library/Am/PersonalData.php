<?php

/**
 * Helper trait which holds account delete functions;
 */
trait PersonalData
{

    function deleteAction(User $user)
    {
        $errors = $this->cancelRecurringActiveInvoices($user);

        $errors = $this->pluginsDeletePersonalData($user, $errors);

        if (!empty($errors))
            return $errors;

        $login = $user->login;
        $user->delete();
        Am_Di::getInstance()->errorLogTable->log(___('Delete Personal Data: User %s was deleted by request', $login));
    }

    function anonymizeAction(User $user)
    {
        $errors = $this->cancelRecurringActiveInvoices($user);

        $errors = $this->pluginsDeletePersonalData($user, $errors);

        if (!empty($errors))
            return $errors;

        $this->anonymizeUser($user);
    }

    function anonymizeUser(User $user)
    {

        $di = Am_Di::getInstance();

        // We delete data from these tables: am_access_log, am_cc, am_data, am_echeck, am_error_log, am_invoice_log
        // am_saved_pass, am_mail_queue
        foreach (['?_access_log', '?_cc', '?_echeck', '?_error_log', '?_saved_pass'] as $tbl)
        {
            $di->db->query("DELETE  FROM {$tbl} WHERE user_id=?", $user->pk());
        }

        //$user->data()->delete();

        $di->db->query(""
            . "DELETE "
            . "FROM ?_invoice_log "
            . "WHERE invoice_id IN ("
            . "SELECT invoice_id FROM ?_invoice WHERE user_id=?"
            . ")", $user->pk());

        $di->db->query("DELETE FROM ?_mail_queue WHERE recipients=?", $user->email);

        // Fields to keep: 
        $to_keep = ['added', 'last_login'];

        //We must keep remote_addr and country for VAT purpose. 
        if (count($di->plugins_tax->getAllEnabled()))
        {
            $to_keep = array_merge($to_keep, ['country', 'remote_addr']);
        }
        if ($from_config = $di->config->get('keep-personal-fields'))
        {
            $to_keep = array_merge($to_keep, $from_config);
        }

        $update = $data_to_delete = [];
        foreach ($di->userTable->getPersonalDataFieldOptions() as $k => $v)
        {
            if (in_array($k, $to_keep))
            {
                continue;
            }
            else if ($k == 'login')
            {
                $update[$k] = 'deleted-user-' . $user->pk() . "*";
            }
            else if ($k == 'email')
            {
                $update[$k] = sprintf("deleted-user-%s*@email.invalid", $user->pk());
            }
            else if (strpos($k, 'data.') === 0)
            {
                $data_to_delete[] = substr($k, 5);
            }
            else
            {
                $update[$k] = '';
            }
        }

        $update['unsubscribed'] = 1;
        $update['is_locked'] = 1;

        $di->db->query("UPDATE  ?_user SET ?a WHERE user_id=?", $update, $user->pk());

        if (!empty($data_to_delete))
        {
            $di->db->query("DELETE FROM ?_data where `table` = 'user' AND `id` = ?, AND `key` IN (?a)", $user->pk(), $data_to_delete);
        }

        $di->errorLogTable->log(
            ___('Delete Personal Data: User %s(%s) was anonymized by request', $user->login, empty($update['login']) ? $update['login'] : $user->login
        ));
    }

    function pluginsDeletePersonalData(User $user, $errors = [])
    {

        /**
         * Remove record from third-party scripts. 
         */
        foreach (Am_Di::getInstance()->plugins_protect->getAllEnabled() as $plugin)
        {
            if (!($plugin instanceof Am_Protect_Databased))
                continue;

            $record = $plugin->getTable()->findByAmember($event->getUser());
            if (!empty($record))
            {
                try
                {
                    $plugin->getTable()->removeRecord($record);
                }
                catch (Exception $ex)
                {
                    $errors[] = ___('Unable to delete record from %s : %s', $plugin->getId(), $ex->getMessage());
                }
            }
        }
        /**
         * Notify other plugins or modules. 
         */
        $event = new Am_Event(Am_Event::DELETE_PERSONAL_DATA, ['user' => $user]);

        Am_Di::getInstance()->hook->call($event);

        $errors = array_reduce($event->getReturn(), function($_, $item)
        {
            return $_ + $item;
        }, $errors);

        return $errors;
    }

    /**
     * Return array of errors on failure. empty on success; 
     * @param type $user
     * @return Array $errors;
     */
    function cancelRecurringActiveInvoices(User $user)
    {
        $errors = [];
        foreach ($this->getRecurringActiveInvoices($user) as $invoice)
        {
            $result = new Am_Paysystem_Result();
            try
            {
                $invoice->getPaysystem()->cancelAction($invoice, 'cancel-admin', $result);
            }
            catch (Exception $e)
            {
                Am_Di::getInstance()->errorLogTable->logException($e);
                $errors[] = ___('Unable to cancel invoice #%s: %s', $invoice->pk(), $e->getMessage());
                continue;
            }

            if ($result->getStatus() != Am_Paysystem_Result::SUCCESS)
            {
                $statusMsg = ___('status was not success');
                $errors[] = ___('Unable to cancel invoice #%s: %s', $invoice->pk(), $statusMsg);
            }
        }
        return $errors;
    }

    function getRecurringActiveInvoices(User $user)
    {
        return array_map(
            function (Invoice $invoice)
        {
            $invoice->_paysysName = $invoice->paysys_id;
            return $invoice;
        }, Am_Di::getInstance()->invoiceTable->findBy(['user_id' => $user->pk(), 'status' => Invoice::RECURRING_ACTIVE])
        );
    }

    function buildPersonalDataArray(User $user)
    {
        $di = Am_Di::getInstance();

        $data = [];
        $fields = $di->config->get('personal-data-download-fields');
        foreach ($di->userTable->getPersonalDataFieldOptions() as $k => $v)
        {

            if (!(empty($fields) || in_array($k, $fields)))
                continue;

            if (strpos($k, 'data.') === 0)
            {
                $value = $user->data()->get(substr($k, 'data.'));
            }
            else
            {
                $value = $user->get($k);
            }

            $data[] = ['title' => $v, 'name' => $k, 'value' => $value];
        }


        $data = $di->hook->filter($data, Am_Event::BUILD_PERSONAL_DATA_ARRAY);
        return $data;
    }

}
