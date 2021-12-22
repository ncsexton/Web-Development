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
namespace DynamicMuseumWalk\Controller;

use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Part as MimePart;
use Laminas\Mvc\Controller\AbstractActionController;
use Omeka\Permissions\Acl;
use Laminas\View\Model\ViewModel;
use Laminas\Http\Headers;
use Laminas\Escaper\Escaper;
use Omeka\Api\Exception\NotFoundException;


/**
 * Controller for routes indicating one wishing to view a museum
 * @author Scott Maday
 */
class MuseumController extends AbstractActionController {
	private static $templateRoot = "museum";

	protected $acl;
	protected $connection;

	function __construct($acl, $connection) {
		$this->acl = $acl;
		$this->connection = $connection;
	}

	/**
	 * Determines the eligibility of an Item to be viewed on a presentation
	 */
	public static function itemIsDirty($item) : bool {
		return $item->isPublic();
	}

	// Builds a view for the actions
	private function buildView(string $action) {
		$view = new ViewModel();
		$view->setTemplate(MuseumController::$templateRoot . "/$action");
		return $view;
	}
	private function buildParameterizedView(string $action)
	{
		// Get results from a possible query
		$query = $this->params()->fromQuery();
		$itemIds = $this->params()->fromQuery("items");
		$items = array();
		$dirtyItems = array();
		$name = $this->params()->fromQuery("name");
		if(!isset($name) || empty($name)){
			$name = "Unnamed Presentation";
		}
		if($itemIds != null) {
			// TODO HACK make more efficient
			foreach($itemIds as $itemId) {
				$item = $this->api()->read("items", $itemId)->getContent();
				if(MuseumController::itemIsDirty($item)) {
					array_push($items, $item);
				} else {
					array_push($dirtyItems, $item);
				}
			}
		} else {
			$unfilteredItems = $query != null ? $this->api()->search("items", $query)->getContent() : array();
			foreach($unfilteredItems as $item) {
				if(MuseumController::itemIsDirty($item)) {
					array_push($items, $item);
				} else {
					array_push($dirtyItems, $item);
				}
			}
		}
		// Create view
		$view = $this->buildView($action);
		// Attatch variables
		$view->setVariable("escaper", new Escaper("utf-8"));
		$view->setVariable("name", $name);
		$view->setVariable("query", $query);
		$view->setVariable("connection", $this->connection);
		$view->setVariable("items", $items);
		$view->setVariable("dirtyItems", $dirtyItems);
		return $view;
	}

	// AbstractActionController overloads

	// Re-routes to the generate action
	public function indexAction() {
		// NOTE urls denoting an action must be specific with museum/action since the new route table declares museum as a literal
		return $this->redirect()->toRoute("museum/action", ["action" => "generate"]);
	}

	// Responsible for the user selecting what they wish to generate the museum walk
	public function generateAction() {
		return $this->buildParameterizedView("generate");
	}

	// Responsible for viewing the museum walk on the web
	public function viewAction() {
		return $this->buildParameterizedView("view");
	}

	// Responsible for rendering individual slides of the museum walk
	public function slidesAction() {
		$num = $this->params("num");
		if($num == null) {
			print("No num parameter for slides");
			return $this->indexAction();
		}
		$response = $this->getResponse();
		$response->getHeaders()->addHeaderLine("Content-Type", "image/webp");
		$item = null;
		try {
			$item = $this->api()->read("items", $num)->getContent();
		} catch (NotFoundException $e) { }
		$view = $this->buildParameterizedView("slides");
		$view->setVariable("num", $num);
		$view->setVariable("item", $item);
		$view->setTerminal(true);
		return $view;
	}

	// Responsible for saving the museum walk generated by the generate action
	public function savesAction() {
		return $this->buildParameterizedView("saves");

	}

	//TODO: Controls administrative rights
	


}


?>