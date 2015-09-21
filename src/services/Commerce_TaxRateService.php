<?php
namespace Craft;

/**
 * Class Commerce_TaxRateService
 *
 * @author    Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2015, Pixel & Tonic, Inc.
 * @license   http://buildwithcraft.com/license Craft License Agreement
 * @see       http://buildwithcraft.com/commerce
 * @package   craft.plugins.commerce.services
 * @since     1.0
 */
class Commerce_TaxRateService extends BaseApplicationComponent
{
	/**
	 * @param \CDbCriteria|array $criteria
	 *
	 * @return Commerce_TaxRateModel[]
	 */
	public function getAll ($criteria = [])
	{
		$records = Commerce_TaxRateRecord::model()->findAll($criteria);

		return Commerce_TaxRateModel::populateModels($records);
	}

	/**
	 * @param int $id
	 *
	 * @return Commerce_TaxRateModel
	 */
	public function getById ($id)
	{
		$record = Commerce_TaxRateRecord::model()->findById($id);

		return Commerce_TaxRateModel::populateModel($record);
	}

	/**
	 * @param Commerce_TaxRateModel $model
	 *
	 * @return bool
	 * @throws Exception
	 * @throws \CDbException
	 * @throws \Exception
	 */
	public function save (Commerce_TaxRateModel $model)
	{
		if ($model->id)
		{
			$record = Commerce_TaxRateRecord::model()->findById($model->id);

			if (!$record)
			{
				throw new Exception(Craft::t('No tax rate exists with the ID “{id}”',
					['id' => $model->id]));
			}
		}
		else
		{
			$record = new Commerce_TaxRateRecord();
		}

		$record->name = $model->name;
		$record->rate = $model->rate;
		$record->include = $model->include;
		$record->showInLabel = $model->showInLabel;
		$record->taxCategoryId = $model->taxCategoryId;
		$record->taxZoneId = $model->taxZoneId;

		$record->validate();

		if (!$record->getError('taxZoneId'))
		{
			$taxZone = craft()->commerce_taxZone->getById($record->taxZoneId);
			if ($record->include && !$taxZone->default)
			{
				$record->addError('taxZoneId',
					Craft::t('Included tax rates are only allowed for the default tax zone. Zone selected is not default.'));
			}
		}

		$model->validate();
		$model->addErrors($record->getErrors());

		if (!$model->hasErrors())
		{
			// Save it!
			$record->save(false);

			// Now that we have a record ID, save it on the model
			$model->id = $record->id;

			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * @param int $id
	 *
	 * @throws \CDbException
	 */
	public function deleteById ($id)
	{
		$TaxRate = Commerce_TaxRateRecord::model()->findById($id);
		$TaxRate->delete();
	}
}