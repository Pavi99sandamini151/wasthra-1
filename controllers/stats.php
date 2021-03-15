<?php

class Stats extends Controller {

    function __construct() {
        parent::__construct();
        Authenticate::adminAuth();
    }

    function index() {
        $this->view->title = 'Stats';
        $this->view->breadcumb = '<a href="' . URL . '">Home</a> <i class="fas fa-angle-right"></i> <a href="' . URL . 'controlPanel">Control Panel</a> <i class="fas fa-angle-right"></i> Stats';

        $this->view->visitorCount = $this->model->getVisitorCount();
        $this->view->salesCount = $this->model->getSalesCount();
        $this->view->totalOrderCount = $this->model->getTotalOrderCount();
        $this->view->revenueAndCost = $this->model->getRevenueAndCost();
        $this->view->totalSalesPerCategory = $this->model->getTotalSalesPerCategory();
        $this->view->totalSalesPerCity = $this->model->getTotalSalesPerCity();

        if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
            switch ($filter) {
                case 'daily':
                    $this->view->visitorCount = $this->model->getVisitorCount("date=CURRENT_DATE()");
                    $this->view->salesCount = $this->model->getSalesCount("date=CURRENT_DATE()");
                    $this->view->salesDistribution = $this->model->getDailySalesDistribution();
                    break;
                case 'weekly':
                    $this->view->salesDistribution = $this->model->getWeeklySalesDistribution();
                    break;
                case 'monthly':
                    $this->view->salesDistribution = $this->model->getMonthlySalesDistribution();
                    break;
                case 'yearly':
                    $this->view->salesDistribution = $this->model->getYearlySalesDistribution();
                    break;
                default:
                    $this->view->salesDistribution = $this->model->getDailySalesDistribution();
                    break;
            }
        } else{
            $this->view->salesDistribution = $this->model->getDailySalesDistribution();
        }
        $this->view->render('control_panel/owner/stats');
    }
}
