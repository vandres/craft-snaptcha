<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\snaptcha\variables;

use craft\helpers\StringHelper;
use craft\helpers\Template;
use putyourlightson\snaptcha\models\SnaptchaModel;
use putyourlightson\snaptcha\Snaptcha;
use Twig\Markup;

/**
 * Snaptcha Variable
 */
class SnaptchaVariable
{
    /**
     * Returns the field name.
     *
     * @return string
     */
    public function getFieldName(): string
    {
        return Snaptcha::$plugin->settings->fieldName;
    }

    /**
     * Returns a field value.
     *
     * @param array|null $config
     *
     * @return string
     */
    public function getFieldValue($config = null): string
    {
        $model = new SnaptchaModel($config);

        return Snaptcha::$plugin->snaptcha->getFieldValue($model) ?? '';
    }

    /**
     * Returns a field.
     *
     * @param array|null $config
     *
     * @return Markup
     */
    public function getField($config = null): Markup
    {
        $value = $this->getFieldValue($config);

        if ($value === '') {
            return Template::raw('<!-- Snaptcha field could not be created. -->');
        }

        $fieldName = $this->getFieldName();
        $fieldId = $fieldName.'-'.StringHelper::randomString(5);

        $field = '<input type="hidden" id="'.$fieldId.'" name="'.$fieldName.'" value="">';
        $field .= '<script>document.getElementById("'.$fieldId.'").value = "'.$value.'";</script>';

        return Template::raw($field);
    }
}
