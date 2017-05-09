<?php 

/**
*  Corresponding Class to test YourClass class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
*  @author yourname
*/
class OfCOStarterClassTest extends PHPUnit_Framework_TestCase{

    /**
    * Just check if the OfCOStarter has no syntax error
    * @test
    */
    function no_syntax_errors()
    {
        $theme = new \Lapubell\WordpressStarter\OfCOStarter;
        $this->assertTrue( is_object($theme) );
    }

    /** @test */
    function can_set_ofco_configuration()
    {
        $theme = new \Lapubell\WordpressStarter\OfCOStarter;
        $config = [];
        $theme->setConfig( $config );

        $this->assertEquals([], $theme->getConfig( $config ));
    }

}