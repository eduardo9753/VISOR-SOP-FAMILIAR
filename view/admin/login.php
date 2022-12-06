<?php include_once('view/templates/head.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 p-0">
            <div class="fondo"></div>
        </div>
        <div class="col-md-4 p-0 fondo-trasparente">
            <div class="">
                <h2 class="white text-center text-dark py-5">ADMIN SOP</h2>
            </div>
            <div class="">
                <div class="col-md-6 mx-auto centrar">
                    <form action="" id="frmAjaxLogin" method="POST">
                        <div class="container">
                            <div class="row text-center">
                                <div class="">
                                    <!--<div class="text-center my-3"><img src="public/img/user.png" alt=""></div>-->
                                    <div class="form-group">
                                        <label for="" class="morado my-3">Usuario</label>
                                        <input type="text" name="txt_usuario" id="txt_usuario" class="form-control" placeholder="Name User" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="morado my-3">Contraseña</label>
                                        <input type="password" name="txt_contra" id="txt_contra" class="form-control" placeholder="************" required>
                                    </div>

                                    <input type="submit" class="my-2 my-btn my-btn-color" name="btn-login" id="btn-login" value="Ingresar">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-5">
                <p class="lead">CRISTHIAN GARCIA - AREA DE SISTEMAS &copy; <?php echo date('Y')?></p>
            </div>
        </div>
    </div>
</div>


<?php include_once('view/templates/footer.php'); ?>