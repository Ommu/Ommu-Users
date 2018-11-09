<?php
/**
 * UsernameController
 * @var $this yii\web\View
 * @var $model ommu\users\models\UserHistoryUsername
 *
 * UsernameController implements the CRUD actions for UserHistoryUsername model.
 * Reference start
 * TOC :
 *	Index
 *	View
 *	Delete
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 Ommu Platform (www.ommu.co)
 * @created date 8 October 2017, 05:40 WIB
 * @modified date 5 May 2018, 02:18 WIB
 * @link https://github.com/ommu/mod-users
 *
 */
 
namespace ommu\users\controllers\history;

use Yii;
use yii\filters\VerbFilter;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use ommu\users\models\UserHistoryUsername;
use ommu\users\models\search\UserHistoryUsername as UserHistoryUsernameSearch;

class UsernameController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all UserHistoryUsername models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new UserHistoryUsernameSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$gridColumn = Yii::$app->request->get('GridColumn', null);
		$cols = [];
		if($gridColumn != null && count($gridColumn) > 0) {
			foreach($gridColumn as $key => $val) {
				if($gridColumn[$key] == 1)
					$cols[] = $key;
			}
		}
		$columns = $searchModel->getGridColumn($cols);

		$this->view->title = Yii::t('app', 'User History Usernames');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
		]);
	}

	/**
	 * Displays a single UserHistoryUsername model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		$this->view->title = Yii::t('app', 'Detail {model-class}: {username}', ['model-class' => 'User History Username', 'username' => $model->username]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_view', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing UserHistoryUsername model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();
		
		Yii::$app->session->setFlash('success', Yii::t('app', 'User history username success deleted.'));
		return $this->redirect(['index']);
	}

	/**
	 * Finds the UserHistoryUsername model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return UserHistoryUsername the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = UserHistoryUsername::findOne($id)) !== null) 
			return $model;
		else
			throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
