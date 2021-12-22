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
******************************************************************************/
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
 * Controller for routes involving administrative priviledges inside the admin view for Omeka
 * @author Scott Maday
 * @author Travis Ledbetter
 */
class MuseumAdminController extends AbstractActionController {
	private static $templateRoot = "museum-admin";

	protected $acl;
	protected $connection;

	function __construct($acl, $connection) {
		$this->acl = $acl;
		$this->connection = $connection;
	}

	private function buildView(string $action) {
		$view = new ViewModel();
		$view->setTemplate(MuseumAdminController::$templateRoot . "/$action");
		return $view;
	}
	private function buildParameterizedView(string $action)
	{
		// Perform a SELECT operation on the database and store the result
		$museums = array();
		$sql =  "SELECT museum.`id`,museum.`title`,saved_presentations.`item` ";
		$sql .= "FROM museum,saved_presentations ";
		$sql .= "WHERE museum.`id` = saved_presentations.`museum_id`";
		$results = $this->connection->fetchAll($sql);

		/* cleaned up results so the name is only shown once in the $museums array
		*  array now has the following structure:
		*  Array ([name] => [First Saved Presentation] => Array ([id] => 1 [items] => Array ([0] => 13 [1]... 
		*  => 4 [2] => 15 ...)) [Second Saved Presentation] => Array ...  
		*/
		foreach($results as $result) {
			$name = $result['title'];
			$id = $result['id'];
			$item = $result['item'];
			if(key_exists($name,$museums)) {
				array_push($museums[$name]['items'],$item);
			} else {
				$museums[$name] = array(
					'id' => $id,
					'items' => array()
				);
				array_push($museums[$name],$name);
				array_push($museums[$name]['items'],$item);
			}
		}
		// Create view
		$view = $this->buildView($action);
		$id = intval($this->params()->fromQuery("id"));
		// Attatch variables
		$view->setVariable("escaper", new Escaper("utf-8"));
		$view->setVariable("query", $this->params()->fromQuery());
		$view->setVariable("id", $id > 0 ? $id : null);
		$view->setVariable("connection", $this->connection);
		$view->setVariable("museums", $museums);
		return $view;
	}

	private function redirectToSaves($id = null, $query = null) {
		$newQuery = $query;
		if($id != null) {
			$newQuery["id"] = $id;
		}
		return $this->redirect()->toRoute("admin/museum-admin/saves", [], ["query" => $newQuery]);
	}

	public function indexAction() {
		return $this->redirectToSaves();
	}

	// Responsible for viewing the saved presentations
	public function savesAction() {
		return $this->buildParameterizedView("saves");
	}

	// TODO Create, delete, and update presentations (doesn't and shouldn't need to render a view)
	public function addPresentationAction() {
		$query = $this->params()->fromQuery();
		$saveItems = $query["items"];
		$presTitle = $query["name"];

		$sql =  "INSERT INTO museum (title) ";
		$sql .= "VALUES ('$presTitle')";
		$this->connection->exec($sql);

		$presID = $this->getSavedPresentationID($presTitle);

		$sql =  "INSERT INTO saved_presentations (museum_id,item) ";
		$sql .= "VALUES ";
		for($i = 0; $i < sizeof($saveItems); $i++) {
			if($i == sizeof($saveItems) - 1) {
				$sql .= "($presID,$saveItems[$i])";
			} else {
				$sql .= "($presID,$saveItems[$i]),";
			}
		}
		$this->connection->exec($sql);
		$this->connection->close();
		return $this->redirectToSaves($presID, ["message" => "Added museum successfully"]);
	}
	public function updatePresentationAction() {
		$id = $this->params("id");
		// TODO Perform an UPDATE operation on the database based on the $id
		return $this->redirectToSaves($id, ["message" => "You are trying to update a presentation that's already saved of $id"]);
	}
	public function deletePresentationAction() {
		$id = $this->params("id");
		$sql = "DELETE FROM museum WHERE id = $id";
		$this->connection->exec($sql);
		return $this->redirectToSaves(null, ["message" => "Deleted museum successfully"]);
	}
	function getSavedPresentationID($presTitle) {
		// fetchAll() required to flush connection cursor for further operations
		$stmt = $this->connection->fetchAll("SELECT id FROM museum WHERE title = '$presTitle'");
		return $stmt[0]['id'];
	}
	function getSavedPresentationTitle($presID) {
		// fetchAll() required to flush connection cursor for further operations
		$stmt = $this->connection->fetchAll("SELECT title FROM museum WHERE id = $presID");
		return $stmt[0]['title'];
	}
}


?>
