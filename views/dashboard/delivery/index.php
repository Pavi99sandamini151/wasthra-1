<?php require 'views/header_dashboard.php'; ?>

<div class="small-container">
<div class="row">
				<h2 class="title title-min">Dashboard</h2>
			</div>
</div>
<div class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-4">
                	<div class="content">
                		<a href="<?php echo URL;?>orders/assignedOrders">
      						<div class="content-overlay"></div>
      						<div class="content-onlay">
      							<div class="content-details fadeOut-top">
      									<p>Assinged Orders</p>
       							
      						</div></div>
      						<img class="content-image" src="<?php echo URL; ?>public/images/dash-10.png">
      						<div class="content-details fadeIn-bottom">
       							<p>Assigned Orders</p>
      						</div>
      					</a>
      				</div>
                </div>
                <div class="col-4">
                	<div class="content">
                		<a href="<?php echo URL;?>orders/history">
      						<div class="content-overlay"></div>
      						<div class="content-onlay">
      							<div class="content-details fadeOut-top">
      									<p>History</p>
       							
      						</div></div>
      						<img class="content-image" src="<?php echo URL; ?>public/images/dash-1.png">
      						<div class="content-details fadeIn-bottom">
       							<p>History</p>
      						</div>
      					</a>
      				</div>
                </div>
               
                
        </div>
    </div>

</div>


    <?php require 'views/footer_dashboard.php'; ?>