<?php
namespace Lapubell\WordpressStarter;

/**
*  OfCO Starter Class
*
*  This is the main class that bootstraps all the goods together for the OfCO Wordpress Starter Theme
*
*  @author lapubell
*/
class OfCOStarter{

    /**  @var array $config configuration array to generate the correct settings in wordpress */
    private $config;

    /**
     * set the application configuration
     * @param array $config this should have all the options that you want defined in your theme
     */
    public function setConfig( $config )
    {
        $this->config = $config;
    }

    /**
     * getter for the configuration in it's current state
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

}