<?php
/**
 * User Verify (user-verify)
 * @var $this VerifyController
 * @var $model UserVerify
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/ommu-users
 *
 */

	$this->breadcrumbs=array(
		'User Verifies'=>array('manage'),
		'Create',
	);

if(isset($_GET['name']) && isset($_GET['email'])) {
	echo Yii::t('phrase', 'Hi, <strong>{name}</strong> an email with instructions for creating a new password has been sent to <strong>{email}</strong>', array(
		'{name}'=>$_GET['name'],
		'{email}'=>$_GET['email'],
	));

} else {?>
	<div class="form">
		<?php echo $this->renderPartial('_form', array(
			'model'=>$model,
		)); ?>
	</div>
<?php }?>