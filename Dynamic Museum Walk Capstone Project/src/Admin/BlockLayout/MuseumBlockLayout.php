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

namespace DynamicMuseumWalk\Admin\BlockLayout;

use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Omeka\Site\BlockLayout\AbstractBlockLayout;

use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\View\Renderer\PhpRenderer;

/**
 * Block Layout during page configuration
 * This will be how administrators configure the dynamic musem walk as a component in the admin interface
 * @author Scott Maday
 */
class MuseumBlockLayout extends AbstractBlockLayout {
	public function getLabel() {
		return "Musem Walk";
	}

	public function form(PhpRenderer $view, SiteRepresentation $site, SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null){
		return ""; // TODO
	}

	// Render the view phtml
	public function render(PhpRenderer $view, SitePageBlockRepresentation $block) {
		return $view->partial("common/block-layout/museum");
	}
}


?>