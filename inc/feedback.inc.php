<form class="mail" action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
	<input type="text" name="to" placeholder="Кому"><br>
	<input type="text" name="subject" placeholder="Тема"><br>
	<textarea name="body" placeholder="Текст"></textarea><br>
	<input type="submit" value="Отправить">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$to = $_POST["to"];
	$subject = $_POST["subject"];
	$body = $_POST["body"];
	if (!mail($to, $subject, $body)) {
		echo "Письмо не отправлено";
	}
}
