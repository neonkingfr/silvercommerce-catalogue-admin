<?php

namespace SilverCommerce\CatalogueAdmin\Extensions;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverCommerce\CatalogueAdmin\Model\TaxRate;

/**
 * Provides additional settings required globally for this module
 *
 * @author i-lateral (http://www.i-lateral.com)
 * @package product-catalogue
 */
class SiteConfigExtension extends DataExtension
{
    
    private static $db = [
        "ShowPriceAndTax" => "Boolean"
    ];

    private static $has_one = [
        'DefaultProductImage'    => Image::class
    ];

    public function updateCMSFields(FieldList $fields)
    {   
        // Add config sets
        $fields->addFieldsToTab(
            'Root.Catalogue',
            [
                UploadField::create(
                    'DefaultProductImage',
                    _t("Catalogue.DefaultProductImage", 'Default product image')
                ),
                GridField::create(
                    'TaxRates',
                    _t("Catalogue.TaxRates", "Tax Rates"),
                    TaxRate::get(),
                    GridFieldConfig::create()->addComponents(
                        new GridFieldToolbarHeader(),
                        new GridFieldAddNewButton('toolbar-header-right'),
                        new GridFieldSortableHeader(),
                        new GridFieldDataColumns(),
                        new GridFieldPaginator(5),
                        new GridFieldEditButton(),
                        new GridFieldDeleteAction(),
                        new GridFieldDetailForm()
                    )
                ),
                CheckboxField::create("ShowPriceAndTax")
                    ->setDescription(_t(
                        "Catalogue.ShowPriceAndTaxDescription",
                        "Show product prices including tax"
                    )),
            ]
        );
    }
}
