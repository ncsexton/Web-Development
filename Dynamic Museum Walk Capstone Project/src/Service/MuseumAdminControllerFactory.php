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
 *****************************************************************************/

namespace DynamicMuseumWalk\Service;

use DynamicMuseumWalk\Controller\MuseumAdminController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

/**
 * Factory for creating the MuseumAdminController, specifically to get and pass the ACL service and database connection to the controller
 * @author Scott Maday
 */
class MuseumAdminControllerFactory implements FactoryInterface
{
	function __construct() {
	}

	public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
	{
		return new MuseumAdminController($services->get("Omeka\Acl"), $services->get("Omeka\Connection"));
	}
}

?>