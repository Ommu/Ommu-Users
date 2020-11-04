<?php
/**
 * Users (users)
 * @var $this app\components\View
 * @var $this ommu\users\controllers\MemberController
 * @var $model ommu\users\models\search\Users
 * @var $form yii\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.id)
 * @created date 15 November 2018, 07:04 WIB
 * @link https://github.com/ommu/mod-users
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;

$js = <<<JS
	$('form[name="gridoption"] :checkbox').click(function() {
		var url = $('form[name="gridoption"]').attr('action');
		var data = $('form[name="gridoption"] :checked').serialize();
		$.ajax({
			url: url,
			data: data,
			success: function(response) {
				//$("#w0").yiiGridView("applyFilter");
				//$.pjax({container: '#w0'});
				return false;
			}
		});
	});
JS;
	$this->registerJs($js, \app\components\View::POS_READY);
?>

<div class="grid-form">
    <?php echo Html::beginForm(Url::to(['/'.$route]), 'get', ['name' => 'gridoption']);
        $columns = [];
        foreach ($model->templateColumns as $key => $column) {
            if ($key == '_no') {
                continue;
            }
            $columns[$key] = $key;
        }
    ?>
        <ul>
            <?php foreach ($columns as $key => $val) { ?>
            <li>
				<?php echo Html::checkBox(sprintf("GridColumn[%s]", $key), in_array($key, $gridColumns) ? true : false, ['id'=>'GridColumn_'.$key]); ?>
				<?php echo Html::label($model->getAttributeLabel($val), 'GridColumn_'.$val); ?>
            </li>
            <?php } ?>
        </ul>
    <?php echo Html::endForm(); ?>
</div>