<?php

namespace App\Admin\Controller;

use App\Repository\BrandsRepository;

class BrandsController extends AdminController {
    public function __construct(private BrandsRepository $brandsRepository) {}
    public function index() {
        $brands = $this->brandsRepository->get();
        $this->render('brands/index', [
            'brands' => $brands
        ]);
    }
    public function create() {
        $errors = [];
        $this->render('brands/create' , [
            'errors' => $errors
        ]);
    }
}