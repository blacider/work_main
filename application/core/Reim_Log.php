<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// from: https://github.com/andrewryno/codeigniter-raven-php/

class Reim_Log extends CI_Log {

    protected $_raven_client = null;
    protected $_raven_levels = [
            'error' => 'error',
            'info' => 'info',
            'debug' => 'debug',
            'all' => 'debug',
        ];

    public function __construct() {
        parent::__construct();
        try {
            $sentry_dsn = $this->load_sentry_config();
            if (!empty($sentry_dsn)) {
                $this->config_raven($sentry_dsn);
            }
        }
        catch (Exception $e) {
            // XXX logging
        }
    }

    public function write_log($level, $msg) {
        $rv = parent::write_log($level, $msg);
        if (empty($this->_raven_client)) {
            return $rv;
        }
        $level = strtolower($level);
        if ($level == 'error' and 
            !$this->is_called_inside_raven()
        ) {
            $this->_raven_client->captureMessage($msg, array(), $this->_raven_levels[$level], true);
        }
        return $rv;
    }

    private function load_sentry_config() {
        $config =& get_config();
        if (!array_key_exists('sentry_dsn', $config)) {
            return null;
        }
        return $config['sentry_dsn'];
    }

    private function config_raven($dsn) {
        if (!class_exists('Raven_Client')) {
            require_once BASEDIR . '/vendor/raven-php/lib/Raven/Autoloader.php';
            Raven_Autoloader::register();
        }
        $this->_raven_client = new Raven_Client($dsn);
        $error_handler = new Raven_ErrorHandler($this->_raven_client);
        $error_handler->registerErrorHandler();
        $error_handler->registerExceptionHandler();
        $error_handler->registerShutdownFunction();
    }

    private function is_called_inside_raven() {
        $stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10);
        foreach ($stack as $frame) {
            if (!array_key_exists('file', $frame)) {
                continue;
            }
            if (false !== strpos($frame['file'], 'lib/Raven/ErrorHandler.php')) {
                return true;
            }
        }
        return false;
    }

}
