<?php 

    require_once("./partials/header_part.php");
    require_once("./partials/navbar_part.php");
    require_once("./data_base/connection.php"); 
?>

<div class="container">
    <div class="row border pt-5 pb-5 mt-5 bg-light">
        <div class="col-xs-12 col-md-8 mx-auto mt-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Payment Details
                    </h3>
                </div>
                <div class="panel-body">
                    <form role="form">
                        <div class="form-group">
                            <label for="cardNumber">
                                CARD NUMBER</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="cardNumber" placeholder="Valid Card Number"
                                    required autofocus />
                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7 mt-4">
                                <div class="form-group">
                                    <label for="expityMonth">
                                        EXPIRY DATE</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="expityMonth" placeholder="MM" required />
                                    </div>
                                    <div class=" mt-2">
                                        <input type="text" class="form-control" id="expityYear" placeholder="YY" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-5 mt-4">
                                <div class="form-group">
                                    <label for="cvCode">
                                        CV CODE</label>
                                    <input type="password" class="form-control" id="cvCode" placeholder="CV" required />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-5">
                <button class="btn btn-primary btn-block" style="width:100%;">Total payment : $ 4544.4</button>
            </div>
            
        </div>
    </div>
</div>

<?php 
//var_dump($_SESSION);
require_once("./partials/footer_part.php");
    
?>