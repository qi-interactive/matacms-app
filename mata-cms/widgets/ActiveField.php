<?php 

namespace matacms\widgets;

use Yii;
use yii\helpers\Json;
use yii\base\Event;
use mata\base\MessageEvent;
use yii\selectize\Selectize;
use zhuravljov\widgets\DatePicker;
use zhuravljov\widgets\DateTimePicker;
use yii\helpers\ArrayHelper;

class ActiveField extends \yii\widgets\ActiveField {

	public $model;

    const EVENT_INIT_DONE = "matacms\widgets\ActiveField::EVENT_INIT_DONE";

	/**
     * @inheritdoc
     */
    public function init() {
        $autoCompleteData = $this->model->autoCompleteData();
        if (isset($autoCompleteData[$this->attribute])) {
            if (is_callable($autoCompleteData[$this->attribute])) {
                $this->autoComplete(call_user_func($autoCompleteData[$this->attribute]));
            } else {
                $this->autoComplete($autoCompleteData[$this->attribute]);
            }
        }

        Event::trigger(self::className(), self::EVENT_INIT_DONE, new MessageEvent($this));
    }

    public function adjustLabelFor($options)
    {
       parent::adjustLabelFor($options);
   }

   public function wysiwyg($options = []) {
      $options = array_merge($this->inputOptions, $options);

      $options = array_merge([
        "s3" => "/mata-cms/media/redactor/s3",
        ], $options);

      $this->adjustLabelFor($options);
      $this->parts['{input}'] = \yii\imperavi\Widget::widget([
       'model' => $this->model,
       'attribute' => $this->attribute,
       'options' => $options
       ]);

      return $this;
  }

  public function dateTime($options = []) {

    $options = ArrayHelper::merge([
        'class' => 'form-control',
        ], $options);

    $clientOptions = isset($options["clientOptions"]) ? $options["clientOptions"] : [];

    $clientOptions = ArrayHelper::merge([
        'autoclose' => true,
        // 'format' => 'd MM yyyy hh:ii',
        'todayHighlight' => true,
        'weekStart' => 1
        ], $clientOptions);

    $this->parts['{input}'] = DateTimePicker::widget([
        'model' => $this->model,
        'attribute' => $this->attribute,
        'options' => $options,
        'clientOptions' => $clientOptions
        ]);

    return $this;
}

public function selectize($options = []) {
    $this->parts['{input}'] = Selectize::widget($options);
    return $this;
}

public function media() {
    $this->parts['{input}'] = \harrytang\fineuploader\Fineuploader::widget([
        'model' => $this->model,
        'attribute' => $this->attribute,
        'options' => $options
        ]);

    return $this;
}

    /**
     * Makes field auto completable
     * @param array $data auto complete data (array of callables or scalars)
     * @return static the field object itself
     */
    public function autoComplete($data)
    {
        static $counter = 0;
        $this->inputOptions['class'] .= ' typeahead typeahead-' . (++$counter);
        foreach ($data as &$item) {
            $item = ['word' => $item];
        }
        $this->form->getView()->registerJs("yii.gii.autocomplete($counter, " . Json::encode($data) . ");");

        return $this;
    }
}