<?php
namespace Craft;

/**
 * Class Commerce_PaymentMethodRecord
 *
 * @property int    $id    The primary key and id of the Payment Method
 * @property string $class
 * @property string $name
 * @property array  $settings
 * @property string $type
 * @property bool   $cpEnabled
 * @property bool   $frontendEnabled
 * @package Craft
 */
class Commerce_PaymentMethodRecord extends BaseRecord
{
	/**
	 * The name of the table not including the craft db prefix e.g craft_
	 *
	 * @return string
	 */
	public function getTableName ()
	{
		return 'commerce_paymentmethods';
	}

	/**
	 * @return array
	 */
	public function defineIndexes ()
	{
		return [
			['columns' => ['class'], 'unique' => true],
		];
	}

	/**
	 * @return array
	 */
	protected function defineAttributes ()
	{
		return [
			'class'           => [AttributeType::String, 'required' => true],
			'name'            => [AttributeType::String, 'required' => true],
			'settings'        => [AttributeType::Mixed],
			'cpEnabled'       => [
				AttributeType::Bool,
				'required' => true,
				'default'  => 0
			],
			'frontendEnabled' => [
				AttributeType::Bool,
				'required' => true,
				'default'  => 0
			],
		];
	}
}


