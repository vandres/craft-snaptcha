<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\snaptcha\controllers;

use Craft;
use craft\web\Controller;
use putyourlightson\snaptcha\models\SnaptchaModel;
use putyourlightson\snaptcha\Snaptcha;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class FieldController extends Controller
{
    // Properties
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected $allowAnonymous = true;

    // Public Methods
    // =========================================================================

    /**
     * Returns the field name.
     *
     * @return Response
     */
    public function actionGetFieldName(): Response
    {
        if (Craft::$app->getRequest()->getAcceptsJson()) {
            return $this->asJson(Snaptcha::$plugin->settings->fieldName);
        }

        return $this->asRaw(Snaptcha::$plugin->settings->fieldName);
    }

    /**
     * Returns a field value.
     *
     * @return Response
     */
    public function actionGetFieldValue(): Response
    {
        $value = Snaptcha::$plugin->snaptcha->getFieldValue(new SnaptchaModel()) ?? '';

        if (Craft::$app->getRequest()->getAcceptsJson()) {
            return $this->asJson($value);
        }

        return $this->asRaw($value);
    }

    /**
     * Returns a field name and value.
     *
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionGetField(): Response
    {
        $this->requireAcceptsJson();

        $value = Snaptcha::$plugin->snaptcha->getFieldValue(new SnaptchaModel()) ?? '';

        return $this->asJson([
            'name' => Snaptcha::$plugin->settings->fieldName,
            'value' => $value,
        ]);
    }

    /**
     * Validates a field value.
     *
     * @return Response
     */
    public function actionValidateFieldValue(): Response
    {
        $value = Craft::$app->getRequest()->get('value');

        $validated = Snaptcha::$plugin->snaptcha->validateField($value);

        if ($validated === false) {
            if (Craft::$app->getRequest()->getAcceptsJson()) {
                return $this->asErrorJson(Craft::t('snaptcha', Snaptcha::$plugin->settings->errorMessage));
            }

            return $this->asRaw(Craft::t('snaptcha', Snaptcha::$plugin->settings->errorMessage));
        }

        if (Craft::$app->getRequest()->getAcceptsJson()) {
            return $this->asJson(['success' => true]);
        }

        return $this->asRaw('success');
    }
}
