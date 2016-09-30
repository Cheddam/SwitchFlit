<?php

namespace SwitchFlit;

class SwitchFlitController extends \Controller
{
	private static $url_handlers = [
		'$DataObject/records' => 'getRecordsForDataObject'
	];

	private static $allowed_actions = [
		'getRecordsForDataObject'
	];

	/**
	 * Pulls all items from a SwitchFlitable DataObject and returns them as JSON.
	 *
	 * @param \SS_HTTPRequest $request The current request.
	 * @return string The data in JSON format.
	 *
	 * @todo Allow custom columns? Pagination considerations?
	 */
	public function getRecordsForDataObject(\SS_HTTPRequest $request)
	{
		$dataobject = $request->param('DataObject');

		if (! class_exists($dataobject)) {
			throw new \Exception('The class ' . $dataobject . ' does not exist.');
		}

		if (! in_array('DataObject', class_parents($dataobject))) {
			throw new \Exception('The class ' . $dataobject . ' is not a DataObject.');
		}

		if (! in_array('SwitchFlit\SwitchFlitable', class_implements($dataobject))) {
			throw new \Exception('The class ' . $dataobject . ' is not SwitchFlitable.');
		}

		$records = $dataobject::get();
		$data = [];

		foreach ($records as $record) {
			if (! $record->canView()) continue;

			$data[] = [
				'title' => $record->SwitchFlitTitle(),
				'link' => $record->SwitchFlitLink()
			];
		}

		$this->response->addHeader('Content-Type', 'application/json');
		return json_encode($data);
	}
}
