<?php include_once('view/templates/head.php'); ?>

<?php include_once('view/templates/nav.php'); ?>

<!--para que no se muestra la paginacion ni el buscador quitar el id=datatable-->
<main>
    <section class="mt-1">
        <div class="container-fluid" id="recargar">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="titulo py-3 titulo_head_table">ESTADO DE PACIENTES EN SALA DE OPERACIONES</h1>
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table id="" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="titulo_head_table text-center text-capitalize">N°</th>
                                        <th class="titulo_head_table text-center text-capitalize">DOCUMENTO</th>
                                        <th class="titulo_head_table text-center text-capitalize">GENERO</th>
                                        <th class="titulo_head_table text-center text-capitalize">MEDICO</th>
                                        <th class="titulo_head_table text-center text-capitalize">ESPECIALIDAD</th>
                                        <!--<th class="titulo_head_table text-center text-capitalize">EN SALA</th>
                                        <th class="titulo_head_table text-center text-capitalize">RECUPERACION</th>
                                        <th class="titulo_head_table text-center text-capitalize">DE ALTA</th>-->
                                        <th class="titulo_head_table text-center text-capitalize">ESTADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dataSopMySql as $data) : $i = $i + 1; ?>

                                        <?php //if ($resul <= 60) {  ?>
                                            <tr class="">
                                                <td><?php echo $i; ?></td>
                                                <?php
                                                $letraPaterno = $this->UTILS->primeraLetra(utf8_encode($data->PATERNO));
                                                $letraMaterno = $this->UTILS->primeraLetra(utf8_encode($data->MATERNO));
                                                $combinacion = $this->UTILS->DELETE_ACENTO($data->PATERNO) . "  " . $this->UTILS->DELETE_ACENTO($data->MATERNO);
                                                ?>
                                                <td class="text-center tamanio-letra"><?php echo $data->DOCUMENTO; ?></td>
                                                <td class="text-center tamanio-letra"><?php if ($data->SEXO_PAC == 'M') :  ?>
                                                        <img src="public/img/man.png" alt="">
                                                    <?php else : ?>
                                                        <img src="public/img/woman.png" alt="">
                                                    <?php endif ?>
                                                </td>
                                                <td class="text-center tamanio-letra"><?php echo $this->UTILS->DELETE_ACENTO(utf8_encode($data->NOMBRE_PROFESIONAL)); ?></td>
                                                <td class="text-center tamanio-letra"><?php echo $this->UTILS->DELETE_ACENTO(utf8_encode($data->NOMBRE_ESPECIALIDAD)); ?></td>
                                                <!--<td class="text-center"><?php echo utf8_encode($data->FECHA_CHEKLIST); ?></td>
                                                <td class="text-center"><?php echo utf8_encode($data->FECHA_RECUPERACION); ?></td>
                                                <td class="text-center"><?php echo utf8_encode($data->FECHA_SALIDA); ?></td>-->
                                                <td class="text-center"><?php if ($data->ESTADO == '1') : ?>
                                                        <div class="p-3 mb-2 bg-success text-white text-center tamanio-letra">EN SALA<i class='bx bx-alarm bx-tada'></i></div>
                                                    <?php elseif ($data->ESTADO == '2') : ?>
                                                        <div class="p-3 mb-2 bg-warning text-white text-center tamanio-letra">RECUPERACION <i class='bx bx-smile bx-tada'></i></div>
                                                    <?php elseif ($data->ESTADO == '3') : ?>
                                                        <div class="p-3 mb-2 bg-primary text-white text-center tamanio-letra">DE ALTA <i class='bx bx-right-arrow-alt bx-fade-left'></i></div>
                                                    <?php endif ?>
                                                </td>
                                            </tr>
                                        <?php //} ?>


                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<?php include_once('view/templates/footer.php'); ?>