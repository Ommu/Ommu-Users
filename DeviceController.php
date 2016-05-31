<?php
/**
 * DeviceController
 * @var $this DeviceController
 * @var $model UserDevice
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Android
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 9 April 2016, 06:37 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class DeviceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';

	/**
	 * @return array action filters
	 */
	public function filters() 
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','android'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() 
	{
		$this->redirect(Yii::app()->createUrl('site/index'));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionAndroid()
	{
		if(Yii::app()->request->isPostRequest) {
			$token = trim($_POST['token']);
			$key = trim($_POST['key']);
			
			$criteria=new CDbCriteria;
			$criteria->select = array('t.id','t.user_id');
			$criteria->compare('t.publish',1);
			$criteria->compare('t.android_id',$key);
			
			$device = UserDevice::model()->find($criteria);
			if($device == null) {
				$data=new UserDevice;
				$data->android_id = $key;
				if($data->save() && ($token != null && $token != '')) {
					$user = ViewUsers::model()->findByAttributes(array('token_password' => $token), array(
						'select' => 'user_id',
					));
					if($user != null) {
						if(UserDevice::model()->updateByPk($data->id, array('user_id'=>$user->user_id))) {
							$return = array(
								'success'=>'1',
								'message'=>'success, device berhasil ditambahkan (info member selesai diperbarui)',
							);
						} else {
							$return = array(
								'success'=>'1',
								'message'=>'success, device berhasil ditambahkan (info member tidak ada perubahan)',
							);
						}
					} else {
						$return = array(
							'success'=>'1',
							'message'=>'success, device berhasil ditambahkan (member tidak ditemukan)',
						);							
					}
				} else {
					$return = array(
						'success'=>'0',
						'message'=>'success, device tidak berhasil ditambahkan',
					);
				}
			} else {
				if($device->user_id == 0 && ($token != null && $token != '')) {
					$user = ViewUsers::model()->findByAttributes(array('token_password' => $token), array(
						'select' => 'user_id',
					));
					if($user != null) {
						if(UserDevice::model()->updateByPk($device->id, array('user_id'=>$user->user_id))) {
							$return = array(
								'success'=>'1',
								'message'=>'success, device berhasil ditambahkan (info member selesai diperbarui)',
							);
						} else {
							$return = array(
								'success'=>'1',
								'message'=>'success, device tidak terjadi perubahan (info member tidak ada perubahan)',
							);
						}
					} else {
						$return = array(
							'success'=>'1',
							'message'=>'success, device tidak terjadi perubahan (member tidak ditemukan)',
						);	
					}
				} else {
					$return = array(
						'success'=>'1',
						'message'=>'success, device tidak terjadi perubahan',
					);					
				}
			}
			
			echo CJSON::encode($return);
			
		} else 
			$this->redirect(Yii::app()->createUrl('site/index'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = UserDevice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) 
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-device-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
