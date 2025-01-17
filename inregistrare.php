<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume = htmlspecialchars($_POST['nume']);
    $prenume = htmlspecialchars($_POST['prenume']);
    $email = htmlspecialchars($_POST['email']);
    $parola = htmlspecialchars($_POST['parola']);
    $confirma_parola = htmlspecialchars($_POST['confirma_parola']);
    
    if ($parola !== $confirma_parola) {
        die("Parolele nu coincid!");
    }
    
    $parola_hash = password_hash($parola, PASSWORD_BCRYPT);

    $conn = new mysqli('localhost', 'root', '', 'autentificare_db');
    if ($conn->connect_error) die("Eroare la conectare: " . $conn->connect_error);

    // Verificăm dacă email-ul este deja utilizat
    $check_email = $conn->prepare("SELECT id FROM utilizatori WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();
    if ($check_email->num_rows > 0) {
        die("Adresa de email este deja înregistrată!");
    }
    $check_email->close();

    // Adăugăm utilizatorul în baza de date
    $stmt = $conn->prepare("INSERT INTO utilizatori (nume, prenume, email, parola) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nume, $prenume, $email, $parola_hash);
    
    if ($stmt->execute()) {
        echo "Cont creat cu succes! Vei fi redirecționat către pagina de autentificare.";
        header("Refresh: 2; url=login.html"); // Redirecționare automată după 2 secunde
    } else {
        echo "Eroare: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
