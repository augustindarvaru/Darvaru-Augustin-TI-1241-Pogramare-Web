<?php
session_start();

// Verificăm dacă utilizatorul este autentificat
if (!isset($_SESSION['autentificat']) || $_SESSION['autentificat'] !== true) {
    die("Acces interzis. Trebuie să vă autentificați.");
}

// Conectarea la baza de date
$conn = new mysqli('localhost', 'root', '', 'autentificare_db');
if ($conn->connect_error) {
    die("Eroare la conectare: " . $conn->connect_error);
}

// Selectarea mesajelor din baza de date
$sql = "SELECT id, nume, email, continut, data_trimiterii FROM mesaje ORDER BY data_trimiterii DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Eroare la interogare: " . $conn->error);
}

// Afișarea mesajelor într-un tabel
echo "<h2>Mesaje primite</h2>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Nume</th>
            <th>Email</th>
            <th>Conținut</th>
            <th>Data trimiterii</th>
        </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nume']}</td>
                <td>{$row['email']}</td>
                <td>{$row['continut']}</td>
                <td>{$row['data_trimiterii']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>Nu există mesaje.</td></tr>";
}

echo "</table>";

$conn->close();
?>
