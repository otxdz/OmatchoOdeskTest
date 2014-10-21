<?php

namespace OmatchoTest;

use Omatcho\AsciiTable;

class AsciiTableTest extends \PHPUnit_Framework_TestCase {
	
	
	private $data;
	
	public function setUp()
	{
		$this->data = array(
			array(
				'ID' => '1',
				'name' => 'Item 1'
			),
			array(
				'ID' => '2',
				'name' => 'Item 2'
			)
		);
	}
	
	public function testSetGetData()
	{
		 $asciiTable = new AsciiTable();
		 $asciiTable->setTableData($this->data);
		 $this->assertEquals($this->data, $asciiTable->getTableData());
	}
	
	public function testSetGetCellSpacing()
	{
		$cellSpacing = 1;
		$table = $this->getTable(false);
		$table->setCellSpacing($cellSpacing);
		$this->assertEquals($cellSpacing, $table->getCellSpacing());
	}
	
	public function testGetColumns()
	{
		$cellSpacing = 2;
		$table = $this->getTable();
		$table->setCellSpacing($cellSpacing);
		
		$expected = array(
			'ID' => 2 + $cellSpacing,
			'name' => 6 + $cellSpacing
		);
		
		$this->assertEquals($expected, $table->getColumns());
	}
	
	public function testGetAsciiTableConsole()
	{
		
		$expected  = '+----+--------+' . PHP_EOL;
		$expected .= '| ID | name   |' . PHP_EOL;
		$expected .= '+----+--------+' . PHP_EOL;
		$expected .= '| 1  | Item 1 |' . PHP_EOL;
		$expected .= '| 2  | Item 2 |' . PHP_EOL;
		$expected .= '+----+--------+' . PHP_EOL;
		
		$table = $this->getMockAsciiTable();
		$table->setCellSpacing(2);
		$table->expects($this->any())->method('isConsole')->will($this->returnValue(true));
		$this->assertEquals($expected, $table->getAsciiTable());
	}
	
	public function testGetAsciiTableNotConsole()
	{
		$expected = '<pre>';
		$expected .= '+----+--------+' . PHP_EOL;
		$expected .= '| ID | name   |' . PHP_EOL;
		$expected .= '+----+--------+' . PHP_EOL;
		$expected .= '| 1  | Item 1 |' . PHP_EOL;
		$expected .= '| 2  | Item 2 |' . PHP_EOL;
		$expected .= '+----+--------+' . PHP_EOL;
		$expected .= '</pre>';
		
		$table = $this->getMockAsciiTable();
		$table->setCellSpacing(2);
		$table->expects($this->any())->method('isConsole')->will($this->returnValue(false));
		$this->assertEquals($expected, $table->getAsciiTable());
	}
	
	private function getTable($setData = true)
	{
		$asciiTable = new AsciiTable();
		if($setData) $asciiTable->setTableData($this->data);
		return $asciiTable;
	}
	
	private function getMockAsciiTable()
	{
		$table = $this->getMock('Omatcho\AsciiTable', array('isConsole'), array(), '', false);
		$table->setTableData($this->data);
		return $table;
	}
}