<?php
Yii::import('application.modules.admin.models.Category');
Yii::import('application.modules.admin.models.Product');
Yii::import('application.modules.admin.models.ProductGallery');
class DefaultController extends Controller {

    public $layout = '//layouts/main';
    public $param = 'value';
    public $cartEmpty = true;
    public function actionIndex(){
        $category_list = Category::model()->findAll(array("condition" => "status ='1' AND deleted='0'"));
        $this->render('index-new', array('categories' => $category_list));
    }
    
    public function actionLogin(){
        $model = new FrontUserLogin;
        if(isset($_POST['FrontUserLogin'])){
            $model->attributes = $_POST['FrontUserLogin'];
            if($model->validate()){
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $this->render('login', array('model' => $model));
    }
    
    public function actionAddToCart(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['product']) && isset($_POST['quantity'])){
                $name = $_POST['product'];
                $quantity = $_POST['quantity'];
                $product = Product::model()->find(array("condition" => "slug = '$name'"));
                if($product !== null){
                    if(!isset(Yii::app()->session['cartFilled'])){
                        Yii::app()->session['cart'] = [];
                        Yii::app()->session['cartFilled'] = true;
                    }
                    $isExisting = false;
                    $d = [];
                    foreach(Yii::app()->session['cart'] as $key => $cart){
                        $c = [];
                        $c['product'] = $cart['product'];
                        if($cart['product']->id == $product->id){
                           $quantity =  $cart['quantity'] + $quantity;
                           $c['quantity'] =  $quantity;
                           $isExisting = true;
                        } else {
                            $c['quantity'] = $cart['quantity'];
                        }
                        array_push($d, $c);
                    }
                    if($isExisting){
                        Yii::app()->session['cart'] = $d;
                    } else {
                        $a = [];
                        $a['product'] = $product;
                        $a['quantity'] = $quantity;
                        $b = Yii::app()->session['cart'];
                        array_push($b, $a);
                        Yii::app()->session['cart'] = $b;
                    }
                    
                    
                    $data['existing'] = $isExisting;
                    $data['name'] = $product->name;
                    $data['slug'] = $product->slug;
                    $data['price'] = $product->price;
                    $data['quantity'] = $quantity;
                    $data['image'] = base_url().'/images/products/'.(!empty($product->product_main_image[0]->image)) ? $product->product_main_image[0]->image : '';
                    echo json_encode($data, true);
                } else {
                    echo "error";
                }
            }
        } else {
            echo "error";
        }
    }
    
    public function actionRemoveFromCart(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['product'])){
                $name = $_POST['product'];
                $product = Product::model()->find(array("condition" => "slug = '$name'"));
                if($product !== null){
                    $d = [];
                    foreach(Yii::app()->session['cart'] as $key => $cart){
                        if($cart['product']->id != $product->id){
                           $c = [];
                           $c['product'] = $cart['product'];
                           $c['quantity'] = $cart['quantity'];
                           array_push($d, $c);
                        }
                    }
                    Yii::app()->session['cart'] = $d;
                    echo "removed";
                } else {
                    echo "error";
                }
            }
        } else {
            echo "error";
        }
    }
    
    public function actionCart(){
        $this->render("cart");
    }
    
    public function actionIndex1() {
        Yii::import('application.modules.admin.models.Category');
        Yii::import('application.modules.admin.models.Product');
        Yii::import('application.modules.admin.models.ProductGallery');
        Yii::import('application.modules.admin.models.Pages');

        $about = Pages::model()->find(array("condition" => "page_name='a' AND status ='1' AND deleted = '0'"));
        $vision = Pages::model()->find(array("condition" => "page_name='v' AND status ='1' AND deleted = '0'"));
        $mission = Pages::model()->find(array("condition" => "page_name='m' AND status ='1' AND deleted = '0'"));
        $category_list = Category::model()->findAll(array("condition" => "status ='1' AND deleted='0'"));
        $banner_list = Banners::model()->findAll(array("condition" => "status ='1' AND deleted = '0'"));
        $this->render('index', array('banner_list' => $banner_list, 'category_list' => $category_list, 'about' => $about, 'vision' => $vision, 'mission' => $mission));
    }

    public function actionLoginCheck() {
        if (Yii::app()->user->isGuest) {
            echo "GUEST";
        } else {
            echo "USER";
        }
    }

    public function actionAbout() {
        Yii::import('application.modules.admin.models.Pages');
        $about_us_content = Pages::model()->find(array("condition" => "page_name='a' AND status ='1' AND deleted = '0'"));
        //pre($about_us_content,true);
        $this->render('about', array('about_us_content' => $about_us_content));
    }

    public function actionContact() {
        Yii::import('application.modules.admin.models.Pages');
        $contact_us_content = Pages::model()->find(array("condition" => "page_name='c' AND status ='1' AND deleted = '0'"));
        $this->render('contact', array('contact_us_content' => $contact_us_content));
    }

    public function actionProduct($name) {
        Yii::import('application.modules.admin.models.Product');
        Yii::import('application.modules.admin.models.Category');
        Yii::import('application.modules.admin.models.ProductGallery');
        $categories = Category::model()->findAll(array("condition" => "status ='1' AND deleted='0'"));
        $product = Product::model()->find(array("condition" => "slug = '$name'"));
        $category = Category::model()->findByPk($product->category);
        $this->render('detail', array('product' => $product, 'categories' => $categories, 'category' => $category));
    }

    public function actionProducts() {
        Yii::import('application.modules.admin.models.Category');
        Yii::import('application.modules.admin.models.Product');
        Yii::import('application.modules.admin.models.ProductGallery');
        $categories = Category::model()->findAll(array("condition" => "status ='1' AND deleted='0'"));
        $dataProvider = new CActiveDataProvider('Product', array(
            'criteria' => array(
                'order' => 'date_entered DESC',
            ),
            'pagination' => array(
                'pageSize' => 12,
            ),
        ));
        $this->render('products', array(
            'dataProvider' => $dataProvider,
            'categories' => $categories
        ));
        /* $product = Product::model()->findAll();
          $this->render('products',array('products'=>$products)); */
    }

    public function actionProductCategory($name) {
        Yii::import('application.modules.admin.models.Category');
        Yii::import('application.modules.admin.models.Product');
        Yii::import('application.modules.admin.models.ProductGallery');
        $categories = Category::model()->findAll(array("condition" => "status ='1' AND deleted='0'"));
        $category = Category::model()->findByAttributes(array("slug" => $name));
//        pre($category->id, true);
        $dataProvider = new CActiveDataProvider('Product', array(
            'criteria' => array(
                'condition' => 'category = ' . '"' . $category->id . '"',
                'order' => 'date_entered DESC',
            ),
            'pagination' => array(
                'pageSize' => 12,
            ),
        ));
        $this->render('products', array(
            'dataProvider' => $dataProvider,
            'categories' => $categories
        ));
    }

    public function actionFaq() {
        Yii::import('application.modules.admin.models.Qna');
        $faq = Qna::model()->findAll(array("condition" => "status = '1'"));
        $this->render('faq', array('faq' => $faq));
    }

    public function actionCareer() {
        $model = new Careers;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Careers'])) {
            //pre($_FILES['Careers'], true);
            $model->attributes = $_POST['Careers'];
            $name = $_FILES['Careers']['name']['cv'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);

            $model->cv = CUploadedFile::getInstance($model, 'cv');
            if ($model->save()) {
                $fullPath = Yii::getPathOfAlias('webroot') . '/assets/cv/' . $model->id.'.' . $ext;
                $model->cv->saveAs($fullPath);
                $model->cv = $model->id.'.' . $ext;
                $model->save();
                $name = $model->first_name.' '.$model->middle_name.' '.$model->last_name;
                $phone = $model->mobile;
                $email = $model->email;
                $cv_url = domainUrl() .'/download-cv?id='.$model->id;
                $message = ownerEmail($name, $phone, $email, $cv_url);
                $to = 'neeraj24a@gmail.com';
                $subject = 'New CV Submitted';
                mailsend($to, "hr@naturaxion.com", $subject, $message);
                $model = new Careers;
                Yii::app()->user->setFlash('success', "Your Resume has been submitted successfully.");
                //$this->redirect(array('view', 'id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', "Some thing went wrong please verify errors below.");
            }
        }

        $this->render('career', array(
            'model' => $model,
        ));
    }
    
    public function actionDownloadCv($id){
        $model = Careers::model()->findByPk($id);
        if($model === null){
            throw new CHttpException(404,'No File Available');
        } else {
            Yii::app()->getRequest()->sendFile($model->cv, @file_get_contents('assets/cv/' . $model->cv));
        }
    }

}
