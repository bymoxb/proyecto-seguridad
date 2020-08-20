
<?php
 $valor=168;
?>
    <script>
setTimeout(function() {
       $('#divMessage').hide('fast');
}, 6000); // <-- time in milliseconds
</script>
 <h4 class="page-title">Pagos</h4>
 <hr />

 <div class="row">

<div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Resumen de la compra</div>
                    </div>
                    <div class="card-body">
                        <div class="jumbotron">
                            <h1 class="display-4">Samsung A30</h1>
                            <p class="lead">Color negro. 32GB</p>
                            <hr class="my-4">
                            <div class="row">
                                <div class="col">
                                    <label>Subtotal</label>
                                </div>
                                <div class="col">
                                    <label>$150</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>IVA</label>
                                </div>
                                <div class="col">
                                    <label>$18</label>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="row">
                                <div class="col">
                                    <label class="lead">Total</label>
                                </div>
                                <div class="col">
                                    <label class="lead" id="total"><?php echo $valor?></label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
             <div class="col-md-6">
             <div class="card">
                    <div class="card-header">
                        <div class="card-title">Pagar</div>
                    </div>
                    <div class="card-body">
                    <?php
                    if($status!=null){
                       if($status=="Fail"){
                        ?>
                        <div class="col-md-6" id="divMessage">
                            <div class="alert alert-danger" role="alert">
                            Transaccion Declinada. 
                            </div> 
                        </div>
                        <?php }
                     
                    } ?> 
           

                        <form id="kushki-pay-form" action="?action=callAPI" method="post">
                            <input type="hidden" name="total" value="<?php echo $valor?>">
                        </form>
                    </div>
                    
                </div>

            </div>
        </div>

            <script type="text/javascript">
        var total=$('label[id="total"]').text()
            var kushki = new KushkiCheckout({
                form: "kushki-pay-form",
                merchant_id: "6632ca9b4dc74570b458a2f9eeae8994",
                amount: total,
                currency: "USD",
                payment_methods: ["credit-card","cash"], // Payment Methods enabled
                inTestEnvironment: true 
                 // Optional
            });
        </script>