<?php

class PriceCategories extends Controller {

    function __construct() {

        parent::__construct();
        // restrict access only to the owner
        Authenticate::ownerAuth();
    }

    /**
     * Display the price category page
     *
     * @return void
     */
    function index() {

        $this->view->title = 'Price Categories';
        $this->view->breadcumb = '<a href="' . URL . '">Home</a> <i class="fas fa-angle-right"></i> <a href="' . URL . 'controlPanel">Control Panel</a> <i class="fas fa-angle-right"></i> Price Categories';

        // get the price category list
        $this->view->pricecatList = $this->model->listPricecat();
        
        // get the price category  count to diplay in result 
        $this->view->pricecatCount = $this->model->getPriceCategoryCount('no');

        $this->view->render('control_panel/owner/price_categories');
    }


    /**
     * Add new price category
     *
     * @return void
     */
    function create() {

        $data = array();
        $data['price_category_id'] = $_POST['category_id'];
        $data['price_category_name'] = $_POST['category_name'];
        $data['production_cost'] = $_POST['production_cost'];
        $data['add_market_price'] = $_POST['market_price'];
        $data['discount'] = $_POST['discount'];

                    
        Logs::writeApplicationLog('Add Price Category','Attemting',Session::get('userData')['email'],$data);
        $this->model->create($data);
        Logs::writeApplicationLog('Price Category Added','Successfull',Session::get('userData')['email'],$data);

        header('location: ' . URL . 'priceCategories');
    }


    /**
     * 
     * Display edit price category page
     *when edit button click 
     * @param  mixed $id Id of the price category that need to be edited
     * @return void
     */
    function edit($id) {

        $this->view->title = 'Price Categories';
        $this->view->breadcumb = '<a href="' . URL . '">Home</a> <i class="fas fa-angle-right"></i> <a href="' . URL . 'controlPanel">Control Panel</a> <i class="fas fa-angle-right"></i><a href="' . URL . 'priceCategories">Price Categories</a> <i class="fas fa-angle-right"></i>Edit Price Category';

        // get category details of the given id
        
        $this->view->getpricecat = $this->model->getPriceCategory($id);

        $this->view->render('control_panel/owner/edit_price_categories');
    }


    /**
     * Update the existing price category
     *
     * @return void
     */
    function editSave() {

        $data = array();
        $data['prev_id'] = $_POST['prev_id'];
        $data['price_category_id'] = $_POST['category_id'];
        $data['price_category_name'] = $_POST['category_name'];
        $data['production_cost'] = $_POST['production_cost'];
        $data['add_market_price'] = $_POST['market_price'];
        $data['discount'] = $_POST['discount'];


        Logs::writeApplicationLog('Update Price Category','Attemting',Session::get('userData')['email'],$data);
        $this->model->update($data);
        Logs::writeApplicationLog('Price Category Updated','Successfull',Session::get('userData')['email'],$data);


        header('location: ' . URL . 'priceCategories');
    }


    /**
     * Delete existing price category
     *
     * @param  mixed $id Id of the price category that need to be deleted
     * @return void
     */
    function delete($id) {

        Logs::writeApplicationLog('Delete Price Category','Attemting',Session::get('userData')['email'],array($id));
        $this->model->delete($id);
        Logs::writeApplicationLog('Price Category Deleted','Successfull',Session::get('userData')['email'],array($id));


        header('location: ' . URL . 'priceCategories');
    }
}

?>