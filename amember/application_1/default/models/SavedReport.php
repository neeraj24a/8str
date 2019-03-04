<?php
/**
 * Class represents records from table saved_report
 * {autogenerated}
 * @property int $saved_report_id
 * @property string $report_id
 * @property string $request
 * @property int $admin_id
 * @see Am_Table
 */
class SavedReport extends Am_Record
{

}

class SavedReportTable extends Am_Table
{
    protected $_key = 'saved_report_id';
    protected $_table = '?_saved_report';
    protected $_recordClass = 'SavedReport';

    function sendSavedReports(Am_Event $event)
    {
        class_exists('Am_Report_Standard', true);

        foreach($this->getDi()->adminTable->findBy() as $admin) {
            $frequency = $admin->getPref(Admin::PREF_REPORTS_SEND_FREQUENCY);
            if ($frequency == $event->getId()) {
                $content = '';
                foreach($this->findByAdminId($admin->pk()) as $report) {
                    $r = Am_Report_Abstract::createById($report->report_id);
                    $r->applyConfigForm(new Am_Mvc_Request(unserialize($report->request)));
                    $result = $r->getReport();
                    $output = new Am_Report_Text($result);
                    $content .= $report->title . "\n----------------------------\n";
                    $content .= $output->render() . "\n";
                }

                if ($content) {
                    $mail = $this->getDi()->mail;
                    $mail->addTo($admin->email);
                    $mail->setSubject($this->getDi()->config->get('site_title') . ': Reports');
                    $mail->setBodyText($content);
                    $mail->send();
                }
            }
        }
    }
}
