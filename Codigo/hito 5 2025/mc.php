<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluir PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Función para enviar boletín por correo
function enviarBoletinPorCorreo($rutaPDF, $nombrePDF = 'Boletin.pdf') {
    
    // Consulta a usuarios con envios = 1
    $mail = new PHPMailer(true);
    $config = include_once 'config.php';
    $conexion = mysqli_connect($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], $config['DB_NAME']);
    $consulta = "SELECT email FROM usuarios WHERE envios = 1";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
    
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $correo = $fila['email'];
            try { 
                #echo "Enviando a: $correo<br>";
                $mail->isSMTP();
                #echo "Configurando SMTP...<br>";
                $mail->CharSet = 'UTF-8';
                #echo "Charset configurado: UTF-8<br>";
                $mail->Host       = 'smtp.gmail.com';
                #echo "Host configurado: smtp.gmail.com<br>";
                $mail->SMTPAuth   = true;
                #echo "Autenticación SMTP activada<br>";
                $mail->Username   = 'correosVIGIFIA@gmail.com';
                #echo "Usuario configurado:";
                $mail->Password   = 'qjzx qxmu ftvf yxyj'; // Contraseña de aplicación
                #echo "Contraseña configurada<br>";
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                #echo "Seguridad SMTP activada<br>";
                $mail->Port       = 587;
                #echo "Puerto configurado: 587<br>";
                $mail->setFrom('correosVIGIFIA@gmail.com', 'Boletines');
                #echo "Remitente configurado:";
                $mail->addAddress($correo);
                #echo "Destinatario configurado: $correo<br>";
                $mail->isHTML(true);
                #echo "Formato HTML activado<br>";
                $mail->Subject = 'Nuevo boletín disponible';
                #echo "Asunto configurado: Nuevo boletín disponible<br>";
                $mail->Body    = 'Hola, te adjuntamos el boletín más reciente en formato PDF.';
                #echo "Cuerpo del mensaje configurado<br>";
                $mail->AltBody = 'Hola, te adjuntamos el boletín más reciente en PDF.';
                #echo "Cuerpo alternativo configurado<br>";
                #echo "sea rutaPDF: $rutaPDF<br>";
                $mail->addAttachment($rutaPDF, $nombrePDF);
                #echo "Adjunto configurado: $rutaPDF<br>";
        
                $mail->send();
                #echo "Boletín enviado a: $correo<br>";
                
            } catch (Exception $e) {
                error_log("Error al enviar a $correo: {$mail->ErrorInfo}");
                echo "Error al enviar a: $correo<br>";
                return false;
            }
        }
        return true;
    } else {
        echo "No hay usuarios con 'envios = 1'.";
    }
    
}
/*
$correo = $_POST['correo'];
$envio = $_POST['envios'];
$mail = new PHPMailer(true);
if($envio == 1){
    try {
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'correosVIGIFIA@gmail.com';
        $mail->Password   = 'qjzx qxmu ftvf yxyj'; // Contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->setFrom('correosVIGIFIA@gmail.com', 'Boletines');
        $mail->addAddress($correo);
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo boletín disponible';
        $mail->Body    = 'Hola, te adjuntamos el boletín más reciente en formato PDF.';
        $mail->AltBody = 'Hola, te adjuntamos el boletín más reciente en PDF.';
        $mail->addAttachment('pdf/4.pdf', $nombrePDF);
        $mail->send();
        echo "Boletín enviado a: $correo<br>";      
        } catch (Exception $e) {
            error_log("Error al enviar a $correo: {$mail->ErrorInfo}");
            echo "Error al enviar a: $correo<br>";
        }
}else{
    echo "<script>alert('No se ha enviado el boletín');</script>";

}
*/
?>
