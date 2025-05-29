<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8" />
    <title>Login Gru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f5f9;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        nav.navbar {
            /* navbar height standard bootstrap */
            flex: 0 0 auto;
        }

        main {
            flex: 1 0 auto; /* prende tutto lo spazio disponibile */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 15px;
        }

        .login-container {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }

        label {
            font-weight: 600;
            color: #004080;
            margin-top: 15px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-top: 5px;
            border: 1.5px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
        }

        input[type="submit"] {
            margin-top: 25px;
            width: 100%;
            background-color: #0d6efd;
            border: none;
            padding: 12px;
            font-size: 1.1rem;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #004080;
        }

        .message {
            margin-top: 20px;
            font-size: 0.95rem;
            color: #d6336c;
            font-weight: 600;
            text-align: center;
        }

        .message.success {
            color: #198754;
        }

        footer {
            flex-shrink: 0;
        }
    </style>
</head>
<body>
<main>
    <div class="login-container">
        <form method="post" action="">
            <label for="user">Username</label>
            <input name="user" id="user" type="text" placeholder="username" required>

            <label for="pass">Password</label>
            <input name="pass" id="pass" type="password" placeholder="password" required>

            <input type="submit" value="Login">
        </form>

        <?php
require 'db.php'; // Include il file per la connessione al database (usando PDO)

session_start(); // Avvia la sessione per mantenere i dati dell'utente dopo il login

global $pdo; // Rende disponibile la variabile globale $pdo (la connessione PDO)

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Controlla se il form è stato inviato tramite metodo POST
    $user = $_POST['user']; // Prende il nome utente dal form
    $pass = $_POST['pass']; // Prende la password dal form

    // Prepara una query per selezionare l'utente con il nome fornito
    $stmt = $pdo->prepare("SELECT * FROM gru WHERE user = :user");
    $stmt->execute([':user' => $user]); // Esegue la query sostituendo :user con il valore inserito
    $row = $stmt->fetch(PDO::FETCH_ASSOC); // Ottiene la riga risultante come array associativo

    if ($row) { // Se l'utente esiste nel database
        if (password_verify($pass, $row['pass'])) { // Verifica che la password inserita corrisponda all'hash salvato
            $_SESSION['user'] = $row['user']; // Salva l'utente nella sessione
            echo '<p class="message success">Login successful. Welcome, ' . htmlspecialchars($row['user']) . '!</p>';
            // Messaggio di benvenuto (usa htmlspecialchars per sicurezza contro XSS)
            header('Location: index.html'); // Reindirizza alla pagina principale
            exit(); // Termina lo script dopo il redirect
        } else {
            echo '<p class="message">Invalid password.</p>'; // Messaggio di errore se la password è sbagliata
        }
    } else {
        echo '<p class="message">User not found.</p>'; // Messaggio di errore se l'utente non esiste
    }
}
?>

    </div>
</main>
</body>
</html>
