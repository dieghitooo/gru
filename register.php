<html>
<head>
    <title>gru</title>
</head>
<head>
    <title>gru</title>
    <style>
        /* Reset base */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: white;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 90%;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #004080;
        }

        input[type="text"],
        input[type="email"],
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
        input[type="email"]:focus,
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

        p {
            margin-top: 20px;
            text-align: center;
            font-size: 0.95rem;
        }

        p a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
        }

        p a:hover {
            text-decoration: underline;
        }

        /* Messaggi di errore o successo (potresti usarli dinamicamente in PHP) */
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
    </style>
</head>

<body>
<form method="post" action="">
    <label for="user">put your user</label>
    <input name="user" id="user" type="text" placeholder="username" required><br>
    <label for="email">put your email</label>
    <input name="email" id="email" type="email" placeholder="email" required><br>
    <label for="pass">put your password</label>
    <input name="pass" id="pass" type="password" placeholder="password" required><br>
    <input type="submit" value="Register"><br>
    <p>are you already register? <a href="logIn.php">log In</a></p>
</form>

<?php
require 'db.php'; // Importa il file 'db.php' che contiene la connessione al database usando PDO
global $pdo; // Rende disponibile la variabile $pdo (oggetto PDO) a livello globale
// Controlla se il metodo di richiesta è POST (cioè se il form è stato inviato)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica che tutti i campi del form siano stati compilati
    if (empty($_POST['user']) || empty($_POST['pass']) || empty($_POST['email'])) {
        echo "All fields are required."; // Mostra un messaggio se mancano campi obbligatori
    } else {
        // Recupera i dati inviati dal form
        $user = $_POST['user'];  // Esempio: "diego"
        $email = $_POST['email']; // Email dell'utente
        $pass = $_POST['pass'];  // Esempio: "ciao"
        try {
            // Prepara una query SQL per inserire un nuovo utente nella tabella 'gru'
            $stmt = $pdo->prepare("INSERT INTO gru (user, email, pass) VALUES (:user, :email, :pass)");
            // Esegue la query passando i valori dei parametri
            $stmt->execute([
                ':user' => $user,
                ':email' => $email,
                ':pass' => password_hash($pass, PASSWORD_DEFAULT) // Protegge la password con hashing
            ]);
            echo "Registration successful!"; // Messaggio di conferma registrazione
            header('Location: index.html'); // Reindirizza alla home (index.html)
            exit(); // Termina lo script dopo il reindirizzamento
        } catch (PDOException $e) {
            // Se c'è un errore con il database (es. utente duplicato), lo mostra
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

</body>
</html>
