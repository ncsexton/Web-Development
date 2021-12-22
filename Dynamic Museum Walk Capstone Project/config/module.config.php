<?php
/**
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

namespace DynamicMuseumWalk;

use Laminas\Router\Http\Segment;
use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\Factory\InvokableFactory;

/**
 * @author Scott Maday
 */
return [
	"controllers" => [
		"factories" => [
			Controller\MuseumController::class => Service\MuseumControllerFactory::class,
			Controller\MuseumAdminController::class => Service\MuseumAdminControllerFactory::class,
		],
	],
	"navigation" => [
		"AdminModule" => [
			[
				"label" => "Dynamic Museum Walk",
				"route" => "admin/museum-admin",
				"resource" => Controller\MuseumAdminController::class,
				"pages" => [
					[
						"label" => "Saved Presentations",
						"route" => "admin/museum-admin/saves",
						"visible" => true,
					],
					[
						"label" => "Generate a new museum",
						"route" => "museum/action",
						"visible" => true,
						"action" => "generate",
						"target" => "_blank"
					]
				],
			],
		],
	],
	"router" => [
		"routes" => [
			"museum" => [
				"type" => Literal::class,
				"options" => [
					"route" => "/museum",
					"defaults" => [
						"controller" => Controller\MuseumController::class,
						"action" => "index",
					]
				],
				"may_terminate" => true,
				"child_routes" => [
					"slides" => [
						"type" => Segment::class,
						"options" => [
							"route" => "/slides/:num",
							"constraints" => [
								"num" => "\d+",
							],
							"defaults" => [
								"action" => "slides",
							]
						]
					],
					"action" => [
						"type" => Segment::class,
						"options" => [
							"route" => "/:action",
							"constraints" => [
								"action" => "[a-zA-Z][a-zA-Z0-9_-]*",
							],
							"defaults" => [
								"action" => "generate",
							]
						]
					]
				]
			],
			"admin" => [
				"child_routes" => [
					"museum-admin" => [
						"type" => Literal::class,
						"options" => [
							"route" => "/museum",
							"defaults" => [
								"__NAMESPACE__" => "DynamicMuseumWalk\Controller",
								"controller" => Controller\MuseumAdminController::class,
								"action" => "index",
							]
						],
						"may_terminate" => true,
						"child_routes" => [
							"saves" => [
								"type" => Literal::class,
								"options" => [
									"route" => "/saves",
									"defaults" => [
										"action" => "saves",
									]
								],
								"may_terminate" => true,
								"child_routes" => [
									"add" => [
										"type" => Literal::class,
										"options" => [
											"route" => "/add",
											"defaults" => [
												"action" => "addPresentation",
											]
										],
									],
									"update" => [
										"type" => Segment::class,
										"options" => [
											"route" => "/update/:id",
											"constraints" => [
												"id" => "\d+",
											],
											"defaults" => [
												"action" => "updatePresentation",
											]
										],
									],
									"delete" => [
										"type" => Segment::class,
										"options" => [
											"route" => "/delete/:id",
											"constraints" => [
												"id" => "\d+",
											],
											"defaults" => [
												"action" => "deletePresentation",
											]
										],
									],
								]
							],
						]
					]
				]
			]
		],
	],
	
	"block_layouts" => [
		"invokables" => [
			"museum" => Admin\BlockLayout\MuseumBlockLayout::class
		]
	],
	"view_manager" => [
		"template_path_stack" => [
			dirname(__DIR__) . "/view",
		],
	]
];
