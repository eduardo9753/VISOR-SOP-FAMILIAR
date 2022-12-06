<nav class="navbar navbar-expand-lg navbar-dark color-nav">
  <div class="container-fluid">
    <?php $temp = $this->MODELSOP->temperaturaActualCiudad("Lima"); ?>
    <a class="navbar-brand logo" href="#"><img src="public/img/logo.png" alt=""></a>
    <div class="title-dia">
      <p><img src="https://ssl.gstatic.com/onebox/weather/64/partly_cloudy.png" alt=""> <?php echo $temp['T_Celcius']; ?> °C</p>
      <!--<p><img src="<?php echo $temp['Imagen']; ?>" alt=""> <?php echo $temp['T_Celcius']; ?> °C</p>-->
      <!--<p><img src="https://ssl.gstatic.com/onebox/weather/64/partly_cloudy.png" alt=""> <?php echo $temp['T_Celcius']; ?> °C | <?php echo $temp['T_Fahrenheit']; ?> °F</p>-->
      <p class="lead"><?php echo utf8_encode($this->UTILS->diaActualCadena()) . ", " . Date("d") . " de " . $this->UTILS->mesActualCadena() . " del " . Date("Y") . " , " . $temp['Descripcion']; ?></p>
    </div>
    <div class="reloj"><?php echo Date('H:i:s') ?></div>
  </div>
</nav>