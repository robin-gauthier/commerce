<?php
namespace Craft;

class Commerce_CustomerFieldType extends BaseFieldType
{
	// Properties
	// =========================================================================

	/** @var  Commerce_CustomerModel $_customer */
	private $_customer;

	/**
	 * @inheritDoc IComponentType::getName()
	 *
	 * @return string
	 */
	public function getName ()
	{
		return Craft::t('Commerce Customer Info');
	}

	/**
	 * @inheritDoc BaseElementFieldType::defineContentAttribute()
	 * @return bool
	 */
	public function defineContentAttribute ()
	{
		return false;
	}

	/**
	 * @inheritDoc BaseElementFieldType::getInputHtml()
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return string
	 */
	public function getInputHtml ($name, $value)
	{
		return craft()->templates->render('commerce/_fieldtypes/customer/_input', [
			'customer' => $this->getCustomer()
		]);
	}

	/**
	 * @return BaseModel|Commerce_CustomerModel
	 */
	private function getCustomer ()
	{
		if (!$this->_customer)
		{
			$this->_customer = craft()->commerce_customer->getByUserId($this->element->id);
		}

		return $this->_customer;
	}

	/**
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public function prepValue ($value)
	{
		return $value;
	}
}