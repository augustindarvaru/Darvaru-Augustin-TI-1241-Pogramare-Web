<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preluăm datele din formular
    $nume = htmlspecialchars($_POST['nume']);
    $email = htmlspecialchars($_POST['email']);
    $continut = htmlspecialchars($_POST['continut']); // Cheie `continut`

    // Verificăm dacă toate câmpurile sunt completate
    if (empty($nume) || empty($email) || empty($continut)) {
        die("Toate câmpurile sunt obligatorii.");
    }

    // Conectarea la baza de date
    $conn = new mysqli('localhost', 'root', '', 'autentificare_db');

    // Verificăm conexiunea
    if ($conn->connect_error) {
        die("Eroare la conectare: " . $conn->connect_error);
    }

    // Inserăm mesajul în tabela `mesaje`
    $stmt = $conn->prepare("INSERT INTO mesaje (nume, email, continut) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nume, $email, $continut);

    if ($stmt->execute()) {
        echo "Mesaj trimis cu succes!";
        // Redirecționăm utilizatorul
        header("Location: index.html"); // Înlocuiește cu pagina de succes
        exit;
    } else {
        echo "Eroare la trimiterea mesajului: " . $stmt->error;
    }

    // Închidem conexiunea
    $stmt->close();
    $conn->close();
} else {
    echo "Metodă de trimitere invalidă.";
}
?>
