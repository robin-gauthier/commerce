<?php
namespace Craft;

/**
 * Class Commerce_ProductTypeRecord
 *
 * @property int               $id
 * @property string            $name
 * @property string            $handle
 * @property bool              $hasDimensions
 * @property bool              $hasUrls
 * @property bool              $hasVariants
 * @property string            $template
 * @property string            $titleFormat
 * @property int               $fieldLayoutId
 * @property int               $variantFieldLayoutId
 *
 * @property FieldLayoutRecord fieldLayout
 * @package Craft
 */
class Commerce_ProductTypeRecord extends BaseRecord
{
	/**
	 * @return string
	 */
	public function getTableName ()
	{
		return 'commerce_producttypes';
	}

	/**
	 * @return array
	 */
	public function defineIndexes ()
	{
		return [
			['columns' => ['handle'], 'unique' => true],
		];
	}

	/**
	 * @return array
	 */
	public function defineRelations ()
	{
		return [
			'fieldLayout'        => [
				static::BELONGS_TO,
				'FieldLayoutRecord',
				'onDelete' => static::SET_NULL
			],
			'variantFieldLayout' => [
				static::BELONGS_TO,
				'FieldLayoutRecord',
				'onDelete' => static::SET_NULL
			],
		];
	}

	/**
	 * @return array
	 */
	protected function defineAttributes ()
	{
		return [
			'name'          => [AttributeType::Name, 'required' => true],
			'handle'        => [AttributeType::Handle, 'required' => true],
			'hasUrls'       => AttributeType::Bool,
			'hasDimensions' => AttributeType::Bool,
			'hasVariants'   => AttributeType::Bool,
			'titleFormat'   => [AttributeType::String, 'required' => true],
			'template'      => AttributeType::Template
		];
	}

}