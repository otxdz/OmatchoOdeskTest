<?php

namespace Omatcho;

class AsciiTable
{
	
	const COLUMN_SEPARATOR_CHAR = '|';
	const COLUMN_JOIN_CHAR = '+';
	const ROW_SEPARATOR_CHAR = '-';
	
	protected $tableData = null;
	protected $columns = null;
	protected $cellSpacing = 2;
	
	public function __construct(array $tableData = null)
	{
		if(!is_null($tableData))$this->setTableData($tableData);
	}
	
	public function printAscii()
	{
		echo $this->getAsciTable(); 
	}
	
	public function getAsciiTable()
	{
	
		$columns = $this->getColumns();
		
		$asciiData = '';
		
		//if we are not in console use html
		if(!$this->isConsole()) $asciiData .= '<pre>';
		
		$asciiData .= $this->getRowSeparator($columns);
		$asciiData .= $this->getAsciiRow($columns, $columns, true);
		$asciiData .= $this->getRowSeparator($columns);
		
		foreach($this->tableData as $row)
		{
			$asciiData .= $this->getAsciiRow($row, $columns);
		}
		$asciiData .= $this->getRowSeparator($columns);
		//are we in browser?
		if(!$this->isConsole()) $asciiData .=  '</pre>';
		
		return $asciiData;
	}
	
	public function isConsole()
	{
		return (php_sapi_name() === 'cli');
	}
	
	
	public function getTableData()
	{
		return $this->tableData;
	}
	
	public function setTableData(array $tableData)
	{
		$this->tableData = $tableData;
		$this->columns = null;
	}
	
	public function getColumns()
	{
		if(!$this->columns) {
			$this->columns = $this->extractColumnsData($this->tableData);
		}
		return $this->columns;
	}
	
	
	public function getCellSpacing()
	{
		return $this->cellSpacing;
	}
	
	public function setCellSpacing($cellSpacing)
	{
		$this->cellSpacing = $cellSpacing;
	}
	
	protected function getColumnLength($tableData, $column)
	{
		$max = strlen($column);
		
		foreach($tableData as $row) {
			if(!isset($row[$column])) continue;
			$dataLength = strlen($row[$column]);
			if($dataLength > $max) {
				$max = $dataLength;
			}
		}
		
		return $max + $this->cellSpacing;
	}
	
	protected function extractColumnsData(array $tableData)
	{
		$columnsData = array();
		$columns = array_keys(reset($tableData));
		
		foreach($columns as $column) {
			$columnsData[$column] = $this->getColumnLength($tableData, $column);
		}
		return $columnsData;
	}
	
	protected function getAsciiRow($rowData, $columnsData, $isHeader = false)
	{
		$row = '';
		foreach($columnsData as $column => $length)
		{
			$cellData = str_repeat(' ', $this->cellSpacing/2) . ( $isHeader ? $column : $rowData[$column]);
			$row .= self::COLUMN_SEPARATOR_CHAR . str_pad( $cellData, $length, ' ');
		}
		
		$row .= self::COLUMN_SEPARATOR_CHAR  . PHP_EOL;
		
		return $row;
	}
	
	protected function getRowSeparator($columnsData)
	{
		$rowSep = '';
		foreach($columnsData as $column => $length) {
			$rowSep .= self::COLUMN_JOIN_CHAR .  str_repeat(self::ROW_SEPARATOR_CHAR, $length);
		}
		$rowSep .= self::COLUMN_JOIN_CHAR . PHP_EOL;
		return $rowSep;
	}
	
	
	
	
}