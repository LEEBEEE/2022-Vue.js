<?php
namespace application\controllers;

use Exception;

class ApiController extends Controller {
    public function categoryList() {
        return $this->model->getCategoryList();
    }
    public function productInsert() {
        $json = getJson();
        print_r($json);
        return [_RESULT => $this->model->productIns($json)];
    }
    public function productList() {
        $param = [];

        if(isset($_GET["cate3"])) {
            $cate3 = intval($_GET["cate3"]);
            if($cate3 > 0) {
                $param["cate3"] = $cate3;
            }
        } else {
            if(isset($_GET["cate1"])) {
                $param["cate1"] = $_GET["cate1"];
            }
            if(isset($_GET["cate2"])) {
                $param["cate2"] = $_GET["cate2"];
            }
        } 
        return $this->model->productList($param);
    }
    public function productList2() {
        return $this->model->productList2();
    }
    public function productDetail() {
        $urlPaths = getUrlPaths();
        if(!isset($urlPaths[2])) {
            exit();
        }
        $param = [
            'product_id' => intval($urlPaths[2])
        ];
        return $this->model->productDetail($param);
    }
    public function upload() {
        $urlPaths = getUrlPaths();
        if(!isset($urlPaths[2]) || !isset($urlPaths[3])) {
            exit();
        }
        $productId = intval($urlPaths[2]);
        $type = intval($urlPaths[3]);
        $json = getJson();
        $image_parts = explode(";base64", $json["image"]);
        $imge_type_aux = explode("image/", $image_parts[0]);
        $image_type = $imge_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $dirPath = _IMG_PATH . "/" . $productId . "/" . $type;
        $path = uniqid() . "." . $image_type;
        $filePath = $dirPath . "/" . $path;
        if(!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true);
        }
        $result = file_put_contents($filePath, $image_base64);
        if($result) {
            $param = [
                'product_id' => $productId,
                'type' => $type,
                'path' => $path,
                // 'path' => end(explode('/', $filePath))
                // end() : 배열 마지막값 가져오기
            ];
            return [_RESULT => $this->model->productImgIns($param)];
        }
    }
    public function productImageList() {
        $urlPaths = getUrlPaths();
        if(!isset($urlPaths[2])) {
            exit();
        }
        $productId = intval($urlPaths[2]);
        $param = [
            'product_id' => $productId
        ];
        return $this->model->productImgList($param);
    }
    public function productImgDel() {
        $result = 0;
        switch(getMethod()) {
            case _DELETE:
                // urlpath에 죄다 담아옴
                // url: /api/productImgDel/id/product_id/type/path
                $urlPaths = getUrlPaths();
                if(count($urlPaths) !== 6) {
                    exit();
                }
                $param = ["img_id" => intval(isGetOne())];

                // 아이디만 받아와서 셀렉트
                // $img = $this->model->selImgOne($param);
                // $productId = $img->product_id;
                // $type = $img->type;
                // $path = $img->path;

                $result = $this->model->productImgDel($param);
                if($result) {
                    unlink(_IMG_PATH . "/" . $urlPaths[3] . "/" . $urlPaths[4] . "/" . $urlPaths[5]);
                }
                
                break;
        }
        return [_RESULT => $result];
    }

    public function delProduct() {
        $result = 0;
        switch(getMethod()) {
            case _DELETE:
                $productId = intval(isGetOne());
                if(!$productId) {
                    exit();
                }
                $dir = _IMG_PATH . "/" . $productId;
                rmdirAll($dir);
                $param = [
                    'product_id' => $productId
                ];
                $result = $this->model->delProduct($param);

                return [_RESULT => $result];
        }
    }

    // 삭제 강사님 풀이
    public function deleteProduct() {
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 3) {
            exit();
        }
        $productId = intval($urlPaths[2]);
        
        try {
            $param = [
                "product_id" => $productId
            ];
            $this->model->beginTransaction();
            $this->model->productImageDelete($param);
            $result = $this->model->productDelete($param);
            if($result === 1) {
                //이미지 삭제
                rmdirAll(_IMG_PATH . "/" . $productId);    
                $this->model->commit();
            } else {
                $this->model->rollback();    
            }
        } catch(Exception $e) {
            print "에러발생<br>";
            print $e . "<br>";
            $this->model->rollback();
        }    
        
        return [_RESULT => 1];
    }

    public function cate1List() {
        return $this->model->cate1List();
    }

    public function cate2List() {
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 3) {
            exit();
        }
        $param = [ "cate1" => isGetOne() ];
        return $this->model->cate2List($param);
    }

    public function cate3List() {
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 4) {
            exit();
        }
        $param = [ "cate1" => isGetOne(), "cate2" => $urlPaths[3] ];
        return $this->model->cate3List($param);
    }
}