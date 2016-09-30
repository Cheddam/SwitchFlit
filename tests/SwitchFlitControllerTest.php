<?php

use SwitchFlit\SwitchFlitable;

class SwitchFlitControllerTest extends FunctionalTest
{
	protected $usesDatabase = true;

	protected static $fixture_file = 'SwitchFlitControllerTest.yml';

	public function testReturnsJson()
    {
        $response = $this->get('/switchflit/SwitchFlitDemoDataObject/records');

        $this->assertEquals('application/json', $response->getHeader('Content-Type'));
    }

	public function testGetAllowedRecordsForSwitchFlitableDataObject()
	{
		$expected = (object)[
		    'items' => [
                (object)[
                    'title' => 'First',
                    'link' => '/sfobject/1'
                ],
                (object)[
                    'title' => 'Third',
                    'link' => '/sfobject/3'
                ],
            ],
		];

		$response = $this->get('/switchflit/SwitchFlitDemoDataObject/records');

        $this->assertEquals(200, $response->getStatusCode());
		$this->assertEquals($expected, json_decode($response->getBody()));
	}

	public function testDoNotGetRecordsForNonSwitchFlitableDataObject()
	{
        $expected = (object)[
            'errors' => ['The class Member is not SwitchFlitable.']
        ];

        $response = $this->get('/switchflit/Member/records');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals($expected, json_decode($response->getBody()));
	}

	public function testDoNotGetRecordsForNonExistentDataObject()
	{
        $expected = (object)[
            'errors' => ['The class NotReal does not exist.']
        ];

        $response = $this->get('/switchflit/NotReal/records');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals($expected, json_decode($response->getBody()));
	}

	public function testDoNotGetRecordsForNonDataObject()
	{
        $expected = (object)[
            'errors' => ['The class stdClass is not a DataObject.']
        ];

        $response = $this->get('/switchflit/stdClass/records');
	}
}

class SwitchFlitDemoDataObject extends DataObject implements SwitchFlitable
{
	private static $db = [
		'Name' => 'Varchar(150)',
	];

	public function SwitchFlitTitle()
	{
		return $this->Name;
	}

	public function SwitchFlitLink()
	{
		return '/sfobject/' . $this->ID;
	}

	public function canView($member = null)
	{
		return $this->ID != 2;
	}
}
