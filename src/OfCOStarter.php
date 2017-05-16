<?php
namespace Lapubell\WordpressStarter;

use PostTypes\PostType;
use duncan3dc\Laravel\BladeInstance;

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
     * call all the internal methods needed to make the magic happen
     */
    private function bootstrapTheme()
    {
        $this->setThemeSupport();
        $this->registerMenus();
        $this->registerCPT();
        $this->registerTemplates();
    }

    /**
     * manually register page templates
     */
    private function registerTemplates()
    {
        if (!isset($this->config['templates']) || !count($this->config['templates'])) {
            return;
        }

        $templatesToAdd = [];
        foreach ($this->config['templates'] as $templateName) {
            $templatesToAdd[ sanitize_title_with_dashes($templateName) ] = $templateName;
        }

        add_filter( 'theme_page_templates', function($templates) use ($templatesToAdd) {
            foreach ($templatesToAdd as $slug => $name) {
                $templates[ $slug ] = $name;
            }
            return $templates;
        });
    }

    /**
     * add in basic wordpress functionality based on the config settings
     */
    private function setThemeSupport()
    {
        if (isset($this->config['featuredImages']) && $this->config['featuredImages']) {
            add_theme_support( 'post-thumbnails' );
        }
    }

    /**
     * look for the menu locations inside the configuration and register them
     */
    private function registerMenus()
    {
        if (!isset($this->config['menus'])) {
            return;
        }

        $menus = $this->config['menus'];
        add_action( 'init', function() use ($menus) {
            register_nav_menus( $menus );
        });
    }

    /**
     * set the application configuration, then bootstrap the options
     * @param array $config this should have all the options that you want defined in your theme
     */
    public function setConfig( $config )
    {
        if (!is_array($config)) {
            return;
        }

        $this->config = $config;
        $this->bootstrapTheme();
    }

    /**
     * getter for the configuration in it's current state
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * return the view so that it can be parsed or displayed
     * @param  string $view name of the view (without the .blade.php extension)
     * @return string       the rendered view
     */
    public function showView($view = null)
    {
        // if you don't pass a view explictly, and we aren't in the wordpress ecosystem, then return false
        if (is_null($view) && !function_exists("get_post_type")) {
            return false;
        }

        // check if is page and has a template
        if (is_page() && get_page_template_slug()) {
            $view = get_page_template_slug();
        }

        if (is_null($view)) {
            $view = get_post_type();
        }

        $blade = new BladeInstance($this->config['views'], $this->config['viewsCache']);

        return $blade->render($view);
    }

    /**
     * register the different custom post types from the application configuration
     */
    private function registerCPT()
    {
        if (!isset($this->config['cpt'])) {
            return;
        }
        
        foreach ($this->config['cpt'] as $cpt) {
            $staff = new PostType($cpt['name']);
        }
    }
}