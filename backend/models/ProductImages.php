<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

use backend\models\ProductGallery;

class ProductImages extends Model
{
    /**
     * @var UploadedFile[]
     */
	public $product;
    public $imageFiles;

    public function rules()
    {
        return [
			[['product', 'imageFiles'], 'required'],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 10],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) { 
            foreach ($this->imageFiles as $file) {
				$filePath = '../assets/uploads/products/' . create_guid() . '.' . $file->extension;
                $file->saveAs($filePath);
				$model = new ProductGallery;
				$model->product = $this->product;
				$model->image = $filePath;
				$model->type = 'gallery';
				$model->save(false);
		    }
            return true;
        } else {
            return false;
        }
    }
}

?>