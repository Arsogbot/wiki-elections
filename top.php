<!DOCTYPE html>
<html lang="hy">
	<head>
	    <meta charset="UTF-8">
		<link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/9/92/Roman_Election.jpg">
		<title>Ընտրություններ Հայերեն Վիքիպեդիայում</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h1>Խնդրում ենք նշել քվեարկությունը և մասնակցի անունը</h1>
		<p>Գործիքի օգնությամբ հնարովոր է ավտոմատ որոշել մասնակիցը համապատասխան նախագծին մասնակցելու իրավունք ունի թե ոչ։</p>
		<form action="elections.php" method="get">
			<select name="election">
			  <option value="1">Տարվա հոդված</option>
			  <option value="2">Ընտրյալ հոդված</option>
			  <option value="3">Լավ հոդված</option>
			  <option value="4">Ադմինիստրատորի իրավունքների դիմում</option>
			  <option value="5">Ջնջման կանոնակարգ</option>
			</select>
			Մասնակցի անուն։ <input type="text" name="name"><input type="submit" value="Ստուգել">
		</form>