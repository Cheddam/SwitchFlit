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
     * @todo Clean up response handling.
	 * @todo Allow custom columns? Pagination considerations?
	 */
	public function getRecordsForDataObject(\SS_HTTPRequest $request)
	{
		$dataobject = $request->param('DataObject');

		if (! class_exists($dataobject)) {
            return $this->sendError('The class ' . $dataobject . ' does not exist.');
		}

		if (! in_array('DataObject', class_parents($dataobject))) {
            return $this->sendError('The class ' . $dataobject . ' is not a DataObject.');
		}

		if (! in_array('SwitchFlit\SwitchFlitable', class_implements($dataobject))) {
            return $this->sendError('The class ' . $dataobject . ' is not SwitchFlitable.');
		}

		$records = $dataobject::get();

		$results = $this->prepareRecords($records);

        $response = $this->getResponse();

        $response->setStatusCode(200);
        $response->addHeader('Content-Type', 'application/json');
		$response->setBody(json_encode(['items' => $results]));

		return $response;
	}

	public function prepareRecords($records)
    {
        $data = [];

        foreach ($records as $record) {
            if (! $record->canView()) continue;

            $data[] = [
                'title' => $record->SwitchFlitTitle(),
                'link' => $record->SwitchFlitLink()
            ];
        }

        return $data;
    }

    private function sendError($error)
    {
        $response = $this->getResponse();

        $response->setStatusCode(400);
        $response->addHeader('Content-Type', 'application/json');
        $response->setBody(json_encode([
            'errors' => [$error]
        ]));

        return $response;
    }
}
