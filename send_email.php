<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = isset($_POST["phone"]) ? strip_tags(trim($_POST["phone"])) : 'Não fornecido';
    $message = trim($_POST["message"]);
    $consent = isset($_POST["consent"]) ? true : false;

    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message) || !$consent) {
        http_response_code(400);
        echo "Por favor, preencha todos os campos obrigatórios corretamente.";
        exit;
    }

    $recipient = "antoniojmabreu@hotmail.com"; // Replace with your email
    $subject = "Nova mensagem do formulário de contato de $name";
    
    $email_content = "Nome: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Telemóvel: $phone\n";
    $email_content .= "Mensagem:\n$message\n";

    $email_headers = "From: $name <$email>";

    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Obrigado! A tua mensagem foi enviada.";
    } else {
        http_response_code(500);
        echo "Ocorreu um erro ao enviar a mensagem.";
    }
} else {
    http_response_code(403);
    echo "Ocorreu um problema com o envio.";
}
?>
