#!/usr/bin/php -f
<?php

require_once 'abstract.php';

class Herve_Run_Method extends Mage_Shell_Abstract
{

    protected function _parseArgs()
    {
        $this->_args = array_slice(
            array_filter($_SERVER['argv'],
                create_function('$e',
                    'return $e != \'--\';')),
            1);
        return $this;
    }

    /**
     * Run script
     *
     * @return null
     */
    public function run()
    {
        if (empty($this->_args)) {
            echo $this->usageHelp();
            return;
        }

        $uri = array_shift($this->_args);
        $method = array_shift($this->_args);
        $model = Mage::getModel($uri);

        echo "\n\r";

        try {
            $result = call_user_func_array(array($model, $method), $this->_args);
            echo 'Processed "' . get_class($model) . '::' . $method . '()" and returned ';
            if (is_object($result)) {
                echo 'an instance of "' . get_class($result) . '"';
            }
            else {
                var_dump($result);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        echo "\n\r\n\r";
    }

    /**
     * Get the usage string
     *
     * @return string
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f run_method.php -- <class URi> <method> [args]

    Example:
    php -f run_method.php -- module/class method arg1 arg2
    will do:
    Mage::getModel('module/class')->method(arg1, arg2);

    Do the 'help' command to see the list of available commands

USAGE;
    }
}

$shell = new Herve_Run_Method();
$shell->run();
