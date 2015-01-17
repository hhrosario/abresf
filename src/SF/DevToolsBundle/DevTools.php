<?php

namespace SF\DevToolsBundle;

//use Symfony\Bundle\FrameworkBundle\Console\Application,
use Symfony\Component\Console\Application,
	SF\DevToolsBundle\Command;
    
/**
 * DevTools - Wrapper for several commands.
 *
 * @author Pablo Cuadrado <pablocuadrado@gmail.com>
 */
class DevTools extends Application {
    
    //FIXME: Probably misplaced.
    private $kernel;
    
    public function __construct($kernel) {
			parent::__construct('SF Dev Tools', '0.1');
			$this->kernel = $kernel;
			$this->kernel->boot();
									
    	$this->addCommands(array(
				new Command\BeautifyCRUD()
			));
    }
		
		public function getKernel() {
			return $this->kernel;
		}
		
}
