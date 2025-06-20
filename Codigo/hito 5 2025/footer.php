<?php
include_once 'idiomas.php';
$idioma = $_COOKIE['idiomaSeleccionado'] ?? 'es'; // Idioma por defecto
// Footer de FIA
?>

<div class="footer">
    <div class="footer-section">
        <div class="logos">
            <img src="img/minis.png" alt="Ministerio de Agricultura">
            <img src="img/fia.png" alt="FIA">
        </div>
    </div>

    <div class="footer-section">
        <h4><?php echo traducir('SITIOS DE INTERÉS',$idioma)?></h4>
        <ul>
            <li><?php echo traducir('Ministerio de Agricultura',$idioma)?></li>
            <li><?php echo traducir('ANID',$idioma)?></li>
            <li><?php echo traducir('Corfo', $idioma)?></li>
            <li><?php echo traducir('CNID', $idioma)?></li>
            <li><?php echo traducir('Licitaciones de proveedores', $idioma)?></li>
            <li><?php echo traducir('Gobierno Transparente', $idioma)?></li>
            <li><?php echo traducir('Solicitudes de Transparencia',$idioma)?></li>
            <li><?php echo traducir('Memorias FIA',$idioma)?></li>
        </ul>
    </div>

    <div class="footer-section">
        <h4><?php echo traducir('CONTACTO',$idioma)?></h4>
        <p>
            Loreley 1582, La Reina, Santiago<br>
            <?php echo traducir('Teléfono',$idioma)?>: +562 2431 3000<br>
            contacto@fia.cl
        </p>
    </div>

    <div class="footer-section">
        <h4><?php echo traducir('REDES SOCIALES',$idioma)?></h4>
        <div class="social-icons">
            <img src="img/aaa.png" alt="Instagram">
        </div>
    </div>
</div>

<div class="footer-copy">
    © 2022 FIA -<?php echo traducir(' FUNDACIÓN PARA LA INNOVACIÓN AGRARIA. Todos los derechos reservados.', $idioma)?>
</div>
