<?php

use App\Datamodels\IntLink;
use App\Datamodels\ExtLink;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataObject;


class Footsy extends DataObject {
	private static $db = array(
		'Title' => 'Varchar(25)',
		'SortOrder' => 'Int(25)'
	);

	private static $has_many = array(
		'IntLinks' => IntLink::class,
		'ExtLinks' => ExtLink::class
	);

	private static $singular_name = 'Footsy';
	private static $plural_name = 'Footsies';

	private static $default_sort = 'SortOrder ASC';

	private static $summary_fields = array(
		'Title' => 'Title'
	);

	public function getCMSFields() {
		$f = new FieldList();

		$iDom = new GridField(
			'IntLinks',
			IntLink::class,
			$this->IntLinks(),
			GridFieldConfig_RelationEditor::create()->addComponent(new GridFieldSortableRows('SortOrder'))
		);
		//$iDom->setPopupWidth('960');
        //$iDom->setAddTitle('Internal Link');

        $eDom = new GridField(

			'ExtLinks',
			ExtLink::class,
			$this->ExtLinks(),
			GridFieldConfig_RelationEditor::create()
		);
		//$eDom->setPopupWidth('960');
        //$eDom->setAddTitle('External Link');

        $f->push(TextField::create('Title')->setTitle('Link Title'));
        $f->push(TextField::create('SortOrder'));
        $f->push(new LiteralField('', '<br />'));
        $f->push($iDom);
        $f->push(new LiteralField('', '<br />'));
        $f->push($eDom);

		return $f;
	}
}
