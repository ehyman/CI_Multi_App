<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 扩展的CI_Loader，
 * 主要用于加载service层
 * 
 */
class MY_Loader extends CI_Loader
{
    /**
     * List of loaded services
     *
     * @var array
     */
    protected $_ci_services =    array();

    /**
     * List of paths to load services from
     *
     * @var array
     */
    protected $_ci_service_paths =   array();

    public function __construct()
    {
        parent::__construct();
        load_class('Service','core');
        $this->_ci_service_paths = array(APPPATH);
    }

    /**
     * service Loader
     *
     * Loads and instantiates libraries.
     * Designed to be called from application controllers.
     *
     * @param   string  $service    service name
     * @param   array   $params     Optional parameters to pass to the service class constructor
     * @param   string  $object_name    An optional object name to assign to
     * @return  object
     */
    public function service($service = '', $params = NULL, $object_name = NULL)
    {
        if(is_array($service))
        {
            foreach($service as $class)
            {
                $this->service($class, $params);
            }
            return;
        }
        if($service == '' or isset($this->_ci_services[$service])) {
            return FALSE;
        }
        if(! is_null($params) && ! is_array($params)) {
            $params = NULL;
        }
        $subdir = '';
        // Is the service in a sub-folder? If so, parse out the filename and path.
        if (($last_slash = strrpos($service, '/')) !== FALSE)
        {
            // The path is in front of the last slash
            $subdir = substr($service, 0, $last_slash + 1);
            // And the service name behind it
            $service = substr($service, $last_slash + 1);
        }
        foreach($this->_ci_service_paths as $path)
        {
            $filepath = $path .'service/'.$subdir.$service.'.php';

            if ( ! file_exists($filepath))
            {
                continue;
            }
            include_once($filepath);
            $service = strtolower($service);
            if (empty($object_name))
            {
                $object_name = $service;
            }
            $service = ucfirst($service);
            $CI = &get_instance();
            if($params !== NULL)
            {
                $CI->$object_name = new $service($params);
            }
            else
            {
                $CI->$object_name = new $service();
            }
            $this->_ci_services[] = $object_name;
            return;
        }
    }
}