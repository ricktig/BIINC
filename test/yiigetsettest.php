<?php

// change the following paths if necessary
$yii='c:/wamp/www/development/yiitest/yii-master/framework/yii.php';
$config='c:/wamp/www/development/yiitest/myyiitest/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();


	class Document extends CComponent
	{
		private $_textWidth;
		protected $_completed=false;

		public function getTextWidth()
		{
				return $this->_textWidth;
		}

		public function setTextWidth($value)
		{
			$this->_textWidth=$value;
		}

		Public function getTextHeight()
		{
			//calculate and return text height
		}

		Public function setCompleted($value)
		{
			$this->_completed=$value;
		}
	}//end Document class

	//Use the class to test getter/setter
	$document = new Document();
	
	//since TextWidth has both get and set methods
	//we can write and read to TextWidth
	$document->textWidth=100; //uses implied setTextWidth method
	echo $document->textWidth; //uses implied getTextWidth method
	
	//since TextHeight only has a getter, we can only read TextHeight
	$document->textHeight; //produces no output since there is no setter
	echo $document->textHeight; //uses implied getTextHeight method
	
	//since Completed only has a setter, we can only write Completed
	$document->completed=true;
	?>