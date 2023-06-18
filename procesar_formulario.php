<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "proyectobdd";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'];
$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['password'];

// Validación de los campos
if (empty($nombre) || empty($apellido1) || empty($apellido2) || empty($email) || empty($login) || empty($password)) {
    echo "Por favor, complete todos los campos.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "El formato del correo electrónico no es válido.";
} elseif (strlen($password) < 4 || strlen($password) > 8) {
    echo "La contraseña debe tener entre 4 y 8 caracteres.";
} else {
    // Verificar si el correo electrónico ya existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "El correo electrónico ya está registrado. Por favor, utilice otro correo electrónico.";
    } else {
        // Insertar los datos en la base de datos
        $sql = "INSERT INTO usuarios (nombre, apellido1, apellido2, email, login, password) VALUES ('$nombre', '$apellido1', '$apellido2', '$email', '$login', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro completado con éxito. Los datos se han almacenado en la base de datos.";
            echo '<br>';
            echo '<a href="consulta.php">Consulta</a>'; // Agregamos el enlace para consultar los registros
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>