<?php

namespace common\components\asterisk;

use common\components\helpers\ArrayHelper;
use Yii;
use yii\base\Exception;

class Asterisk
{
    private static $_model;

    private $_answer;
    private $_config = [];
    private $_lengthString = 60000;
    private $_socket = null;

    public function __construct()
    {
        $this->_setConfig();
    }

    /**
     * @return Asterisk
     */
    public static function getModel()
    {
        if (empty(self::$_model)) {
            self::$_model = new self();
        }

        return self::$_model;
    }

    public function call($workPlace, $phoneNumber, $orderId = null)
    {
        $this->_connect();

        $phoneNumber = $this->_getFormattedPhoneNumber($phoneNumber);

        $list = [
            'Action: originate',
            'Async: true',
            'Priority: 1',
            'Channel: SIP/' . $workPlace,
            'Context: outbound-allroutes',
            'Timeout: 30000',
            'Callerid: auto-dial <' . $phoneNumber . '>',
            'Exten: ' . $phoneNumber,
//            'Variable: CALLERID(name)=' . $workPlace,
//            'Variable: CDR(operator)=' . Yii::$app->getUser()->getId()
        ];

//        if (!empty($orderId)) {
//            $list[] = 'Variable: CDR(orderid)=' . $orderId;
//        }

        $this->_sendCommands($list);
        $this->_disconnect();
    }

    public function sendSms($phoneNumber, $smsText)
    {
        $this->_connect();

        $phoneNumber = $this->_getFormattedPhoneNumber($phoneNumber);
        $smsText = iconv('UTF-8', 'cp1251', $smsText);

        $list = [
            'Action: DongleSendSMS',
            'Device: d4',
            'Message: ' . $smsText,
            'Number: ' . $phoneNumber
        ];

        $this->_sendCommands($list);
        $this->_disconnect();
    }

    private function _connect()
    {
        if (!empty($this->_socket)) {
            return $this->_socket;
        }

        $this->_socket = fsockopen($this->_config['host'], $this->_config['port'], $errno, $errstr, 1);
        if (empty($this->_socket)) {
            $this->_socket = null;
            throw new Exception(Yii::t('yii', "Could not connect - $errstr ($errno)"));
        }

        stream_set_timeout($this->_socket, 3);

        $list = [
            'Action: Login',
            'UserName: ' . $this->_config['username'],
            'Secret: ' . $this->_config['password']
        ];

        $this->_sendCommands($list);

        if (strpos($this->_answer, 'Message: Authentication accepted') == false) {
            $this->_socket = null;

            throw new Exception('Authentication failed');
        }
    }

    private function _disconnect()
    {
        if (empty($this->_socket)) {
            return false;
        }

        $this->_sendCommands(['Action: Logoff']);
        fclose($this->_socket);

        $this->_socket = null;
    }

    /**
     * @param string $phoneNumber
     *
     * @return string
     */
    private function _getFormattedPhoneNumber($phoneNumber)
    {
        $phoneNumber = str_replace([' ', '(', ')', '-', '_', '+'], '', $phoneNumber);
        return $phoneNumber;

//        $firstNumber = substr($phoneNumber, 0, 1);
//
//        if ($firstNumber == 8) {
//            return '+7' . substr($phoneNumber, 1, strlen($phoneNumber) - 1);
//        }
//
//        return '+' . $phoneNumber;
    }

    /**
     * @return string
     */
    private function _readAnswer()
    {
        $this->_answer = '';
        if (empty($this->_socket)) {
            return;
        }

        do {
            $line = fgets($this->_socket, $this->_lengthString);
            $info = stream_get_meta_data($this->_socket);

            $this->_answer .= $line;
            $end = strpos($this->_answer, 'Items');
            $end = $end !== false ? $end : strpos($this->_answer, 'EventList: Complete');
            if ($end !== false) {
                break;
            }

        } while (!feof($this->_socket) && $info['timed_out'] == false);
    }

    /**
     * @param array $commandList
     */
    private function _sendCommands($commandList)
    {
        if (empty($this->_socket)) {
            return;
        }

        $command = implode("\r\n", $commandList) . "\r\n\r\n";
//        echo 'QUERY: ' . "\r\n";
//        echo $command;
        fputs($this->_socket, $command);

        $this->_readAnswer();
//        echo 'ANSWER: ' . "\r\n";
//        echo $this->_answer;
    }

    private function _setConfig()
    {
        $this->_config = ArrayHelper::getValue(Yii::$app->params, 'asterisk');
        if (empty($this->_config)) {
            throw new Exception(Yii::t('yii', 'Asterisk configuration not found'));
        }

        if (empty($this->_config['host']) || empty($this->_config['port'])) {
            throw new Exception(Yii::t('yii', 'Not set host or port to server Asterisk.'));
        }

        if (empty($this->_config['username']) || empty($this->_config['password'])) {
            throw new Exception(Yii::t('yii', 'Not set username or password to server Asterisk.'));
        }
    }
}
