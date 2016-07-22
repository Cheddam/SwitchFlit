<?php

class SwitchFlitController extends Controller
{
	private static $url_handlers = [
		'$Model/records' => 'getRecordsForModel'
	];

	private static $allowed_actions = [
		'getRecordsForModel'
	];

	private $allowed_models = [];

	public function init()
	{
		parent::init();

		$this->allowed_models = Config::inst()->get('SwitchFlit', 'models');
	}

	/**
	 * Pulls all items from a whitelisted model and returns them as JSON.
	 *
	 * @param SS_HTTPRequest $request The current request.
	 * @return string The data in JSON format.
	 *
	 * @todo Allow custom columns? Pagination considerations?
	 */
	public function getRecordsForModel(SS_HTTPRequest $request)
	{
		$model = $request->param('Model');

		if (! isset($this->allowed_models[$model])) return new SS_HTTPResponse(null, 403);

		$data = $model::get()->setQueriedColumns([
			'ID',
			$this->allowed_models[$model]['name'],
			$this->allowed_models[$model]['link']
		])->toNestedArray();

		return json_encode($data);
	}
}
