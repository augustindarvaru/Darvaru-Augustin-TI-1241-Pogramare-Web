<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preluăm datele trimise prin formular
    $email = htmlspecialchars(trim($_POST['email']));
    $parola = htmlspecialchars(trim($_POST['parola']));

    // Conectarea la baza de date
    $conn = new mysqli('localhost', 'root', '', 'autentificare_db');
    if ($conn->connect_error) {
        die("Eroare la conectare: " . $conn->connect_error);
    }

    // Verificăm dacă email-ul există în baza de date
    $stmt = $conn->prepare("SELECT id, parola FROM utilizatori WHERE email = ?");
    if (!$stmt) {
        die("Eroare la interogare: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $parola_hash);
    $stmt->fetch();

    // Verificarea parolei
    if ($parola_hash && password_verify($parola, $parola_hash)) {
        // Setăm sesiunea pentru utilizatorul autentificat
        $_SESSION['autentificat'] = true;
        $_SESSION['user_id'] = $user_id; // Salvăm ID-ul utilizatorului pentru utilizări viitoare
        $_SESSION['email'] = $email;

        // Redirecționăm către pagina de vizualizare a mesajelor
        header("Location: vizualizare-mesaje.php");
        exit();
    } else {
        echo "Email sau parolă greșită!";
    }

    $stmt->close();
    $conn->close();
} else {
    die("Acces neautorizat.");
}
?>
