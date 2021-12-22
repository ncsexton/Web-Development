<?php
/******************************************************************************
 * Dynamic Museum Walk (c) by Scott Maday, Nathon Sexton, Patel Deepkumar, 
 * Noah Hylton, Scout Doran, Travis Ledbetter
 * 
 * Dynamic Museum Walk is licensed under a
 * Creative Commons Attribution-ShareAlike 4.0 International License.
 * 
 * You should have received a copy of the license along with this
 * work. If not, see <http://creativecommons.org/licenses/by-sa/4.0/>.
 * 
 * Authors: Scott Maday, Travis Ledbetter
 *****************************************************************************/

// Note: Namespace must match the project folder name
namespace DynamicMuseumWalk;

use Omeka\Module\AbstractModule;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\ModuleManager;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\Event;
use Laminas\EventManager\SharedEventManagerInterface;
use Omeka\Permissions\Acl;

class Module extends AbstractModule implements ConfigProviderInterface {

	public function onBootstrap(MvcEvent $event)
	{
		parent::onBootstrap($event);
		$this->addAclRules();
		
	}

	protected function addAclRules() {
		$acl = $this->getServiceLocator()->get("Omeka\Acl");
		$acl->allow(null, Controller\MuseumController::class);
	}

	public function getConfig() {
		return include (__DIR__ . "/config/module.config.php");
	}

	public function getServiceConfig()
	{
		return [
			"factories" => [
				Model\MuseumTable::class => function($container) {
					$tableGateway = $container->get(Model\MuseumTableGateway::class);
					return new Model\MuseumTable($tableGateway);
				},
				Model\MuseumTableGateway::class => function($container) {
					$dbAdapter = $container->get(AdapterInterface::class);
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Museum());
					return new TableGateway("museum", $dbAdapter, null, $resultSetPrototype);
				},
			],
		];
	}
	public function getControllerConfig()
	{
		return [
			"factories" => [
				Controller\MuseumController::class => function($container) {
					return new Controller\MuseumController(
						$container->get(Model\MuseumTable::class),
					);
				}
			],
		];
	}
	//function name: install()
	//purpose: this function runs when the module is installed, it creates
	//a table in the database that will be used to store information
	public function install(ServiceLocatorInterface $serviceLocator)
	{
		$connection = $serviceLocator->get("Omeka\Connection");
		$sql =  "CREATE TABLE museum ( ";
		$sql .= " id int AUTO_INCREMENT NOT NULL PRIMARY KEY,";
		$sql .= " title varchar(100) NOT NULL )";
		$sql .= " DEFAULT CHARACTER SET UTF8 ENGINE = InnoDB";
		$connection->exec($sql);

		$sql =  "CREATE TABLE saved_presentations ( ";
		$sql .= " id int AUTO_INCREMENT PRIMARY KEY,";
		$sql .= " museum_id int NOT NULL,";
		$sql .= " item int,";
		$sql .= " FOREIGN KEY (museum_id)";
		$sql .= " REFERENCES museum(id)"; 
		$sql .= " ON UPDATE CASCADE";
		$sql .= " ON DELETE CASCADE)";
		$sql .= " DEFAULT CHARACTER SET UTF8 ENGINE = InnoDB";
		$connection->exec($sql);

	}
	//function name: uninstall()
	//purpose: this function runs when the module is unistalled, it drops
	//the table that was created on install
	public function uninstall(ServiceLocatorInterface $serviceLocator)
	{
		$connection = $serviceLocator->get("Omeka\Connection");
		$sql = "DROP TABLE IF EXISTS saved_presentations";
		$connection->exec($sql);

		$sql = "DROP TABLE IF EXISTS museum";
		$connection->exec($sql);
	}
}
