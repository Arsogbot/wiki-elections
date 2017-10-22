<!DOCTYPE html>
<html lang="hy">
	<head>
	    <meta charset="UTF-8">
		<link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/9/92/Roman_Election.jpg">
		<title>Ընտրություններ Հայերեն Վիքիպեդիայում</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h1>Խնդրում ենք նշել քվեարկությունը և մասնակցի անունը</h1><br>
		<p>Գործիքի օգնությամբ հնարավոր է ավտոմատ որոշել մասնակիցը համապատասխան քվարկությանը մասնակցելու իրավունք ունի թե ոչ։</p><br>
		<form action="elections.php" method="get">
			<select name="election">
			  <option value="1"<?php echo $selected1 ?>>Տարվա հոդված</option>
			  <option value="2"<?php echo $selected2 ?>>Ընտրյալ հոդված</option>
			  <option value="3"<?php echo $selected3 ?>>Լավ հոդված</option>
			  <option value="4"<?php echo $selected4 ?>>Ադմինիստրատորի իրավունքների դիմում</option>
			  <option value="5"<?php echo $selected5 ?>>Ջնջման կանոնակարգ</option>
			</select>
			Մասնակցի անուն։ <input type="text" name="name" value="<?php echo $inputvalue; ?>"><input type="submit" value="Ստուգել">
		</form><br>