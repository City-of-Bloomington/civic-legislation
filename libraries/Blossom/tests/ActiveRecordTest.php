<?php
/**
 * @copyright 2014 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Cliff Ingham <inghamn@bloomington.in.gov>
 */
require_once './configuration.inc';

define('DATE_FORMAT', 'n/j/Y H:i:s');

class ActiveRecordTest extends PHPUnit_Framework_TestCase
{
	private $testModel;

	public function __construct()
	{
		$this->testModel = new TestModel();
	}

	public function testGetAndSet()
	{
		$this->testModel->set('testField', 'testValue');
		$this->assertEquals('testValue', $this->testModel->get('testField'));
	}

	public function testGetAndSetDate()
	{
		$dateString = '2012-01-01 01:23:43';
		$this->testModel->setDateData('testField', $dateString);
		$this->assertEquals($dateString, $this->testModel->getDateData('testField'));
	}

	public function testDateFormat()
	{
		$dateString = '1/3/2013 01:23:43';
		$this->testModel->setDateData('testField', $dateString);
		$this->assertEquals('Jan 3rd 2013', $this->testModel->getDateData('testField', 'M jS Y'));
	}

	public function testRawDateDataIsMySQLFormat()
	{
		$dateString = '1/3/2013 01:23:43';
		$mysqlDate = '2013-01-03 01:23:43';

		$this->testModel->setDateData('testField', $dateString);
		$this->assertEquals($mysqlDate, $this->testModel->getDateData('testField'));
	}

	public function testForeignKeyObject()
	{
		$this->testModel->set('foreignkey_id', 1);
		$o = $this->testModel->getForeignKeyObject('TestModel', 'foreignkey_id');
		$this->assertEquals(1, $o->get('id'));
	}
}

class TestModel extends Blossom\Classes\ActiveRecord
{
	protected $foreignkey;

	public function __construct($id=null)
	{
		if ($id) { parent::set('id', $id); }
	}

	public function validate() { }

	public function get($field) { return parent::get($field); }
	public function set($field, $value) { parent::set($field, $value); }

	public function getDateData($field, $format=null, \DateTimeZone $timezone=null)
	{
		return parent::getDateData($field, $format, $timezone);
	}

	public function setDateData($field, $date) { parent::setDateData($field, $date); }

	public function getForeignKeyObject($class, $field)
	{
		return parent::getForeignKeyObject($class, $field);
	}
}