<?php

use SwitchFlit\SwitchFlitable;
use SwitchFlit\WithCustomQuery;

class SwitchFlitControllerTest extends FunctionalTest
{
	protected $usesDatabase = true;

	protected static $fixture_file = 'SwitchFlitControllerTest.yml';

	public function testReturnsJson()
    {
        $response = $this->get('/switchflit/SwitchFlitDataObject/records');

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

		$response = $this->get('/switchflit/SwitchFlitDataObject/records');

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

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals($expected, json_decode($response->getBody()));
	}

	public function testGetCorrectRecordsWithCustomQuery()
    {
        $expected = (object)[
            'items' => [
                (object)[
                    'title' => 'Second',
                    'link' => '/sfobject/2'
                ],
            ],
        ];

        $result = $this->get('/switchflit/SwitchFlitDataObjectWithCustomQuery/records');

        $this->assertEquals($expected, json_decode($result->getBody()));
    }
}

class SwitchFlitDataObject extends DataObject implements SwitchFlitable
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

class SwitchFlitDataObjectWithCustomQuery extends DataObject implements SwitchFlitable, WithCustomQuery
{
    private static $db = [
        'Name' => 'Varchar(150)',
        'Type' => "Enum('Valid,Invalid','Invalid')",
    ];

    /**
     * @return string The title to use in SwitchFlit for this DataObject
     */
    public function SwitchFlitTitle()
    {
        return $this->Name;
    }

    /**
     * @return string The link to use in SwitchFlit for this DataObject
     */
    public function SwitchFlitLink()
    {
        return '/sfobject/' . $this->ID;
    }

    /**
     * @param \DataList $data The original DataList.
     * @return \DataList The DataList with custom filters applied.
     */
    public static function SwitchFlitQuery(\DataList $data)
    {
        return $data->filter(['Type' => 'Valid']);
    }

    public function canView($member = null)
    {
        return true;
    }
}
