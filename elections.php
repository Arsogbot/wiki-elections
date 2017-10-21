<?php
function retrive_data()
{
	$url = 'https://hy.wikipedia.org/w/api.php?action=query&list=users|usercontribs&ususers=' . $_GET["name"] . '&usprop=editcount|registration&ucnamespace=0&ucuser=' . $_GET["name"] . '&ucprop=timestamp&uclimit=max&format=json';
	$article_api = file_get_contents($url);
	function article_edit_count($api, $url)
	{
		$fives = 0;
		while(strpos($api, 'uccontinue') && $fives < 1000) {
			$fives = $fives + 500;
			preg_match('/"uccontinue":"([^"]+)/', $api, $uccontinue);
			$api = file_get_contents($url . '&uccontinue=' . $uccontinue[1]);
		}
		return $fives + substr_count($api, "timestamp");
	}
	$article_edits_count = article_edit_count($article_api, $url);
	preg_match('/"editcount":(\d+)/', $article_api, $edit_count);
	preg_match('/"registration":"([^"]+)/', $article_api, $experience_arr);
	$dt = new DateTime($experience_arr[1]);
	$experience = time() - $dt->getTimestamp();
	return array($experience, $edit_count[1], $article_edits_count);
}

function edits_count_of_n_month_from_now($n)
{
	$ucstart = time() - ($n - 1) * 2628000;
	$ucend = time() - $n * 2628000;
	$url = 'https://hy.wikipedia.org/w/api.php?action=query&list=usercontribs&uclimit=50&format=json&ucuser='.$_GET["name"]. '&ucstart='. $ucstart . '&ucend='. $ucend;
	$api = file_get_contents($url);
	return substr_count($api, "timestamp");
}

$data = retrive_data();
function common_template($_months, $_edits, $_edits0, $_lmonth, $_l3months)
{
	global $data;
	$exper = array($_months .' ամիս վիքիստաժ', floor($data[0]/2628000));

	if ($data[0]/2628000 > $_months) 
	{
		array_push($exper, 'green');
	} else 
	{
		array_push($exper, 'red');
	}

	$edits = array('Նվազագույնը '. $_edits .' գործողություն', $data[1]);
	if ($data[1] >= $_edits) 
	{
		array_push($edits, 'green');
	} else 
	{
		array_push($edits, 'red');
	}



	$edits_in_main = array('Նվազագույնը ' . $_edits0 . ' գործողություն հոդվածներում', $data[2] . '֊ից ավել');
	if ($data[1] >= $_edits0) 
	{
		array_push($edits_in_main, 'green');
	} else 
	{
		array_push($edits_in_main, 'red');
	}

	$last_month = array('Նվազագույնը ' . $_lmonth . ' գործողություն վերջին ամսում', edits_count_of_n_month_from_now(1));
	if (edits_count_of_n_month_from_now(1) >= $_lmonth) 
	{
		array_push($last_month, 'green');
	} else 
	{
		array_push($last_month, 'red');
	}
	$last_3month_sum = edits_count_of_n_month_from_now(2) . ', ' . edits_count_of_n_month_from_now(3) . ', ' . edits_count_of_n_month_from_now(4);
	$last_3month = array('Վերջին ամսվան նախորդող 3 ամիսներին ամսական ' . $_l3months . '-ական գործողություն', $last_3month_sum);
	if (edits_count_of_n_month_from_now(2) >= $_l3months || edits_count_of_n_month_from_now(3) >= $_l3months || edits_count_of_n_month_from_now(4) >= $_l3months) 
	{
		array_push($last_3month, 'green');
	} else 
	{
		array_push($last_3month, 'red');
	}

	$result = array($exper, $edits, $edits_in_main, $last_month, $last_3month);

	return $result;
}

function article_of_the_year() 
{
	return common_template(11, 500, 250, 10, 1);
}

function featured_articles()
{
	return common_template(6, 500, 250, 10, 1);
}

function good_articles()
{
	return common_template(3, 500, 250, 10, 1);
}

function admin_elect()
{
	return common_template(6, 1000, 500, 33, 1);
}

function del_elect()
{
	return common_template(6, 500, 100, 0, 0);
}
?>
<!DOCTYPE html>
<html lang="hy">
	<head>
	    <meta charset="UTF-8">
		<link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/9/92/Roman_Election.jpg">
		<title>Ընտրություններ Հայերեն Վիքիպեդիայում</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div>
			<h1>Խնդրում ենք նշել քվեարկությունը մասնակցի անունը</h1>
			<p>Գործիքի օգնությամբ հնարովոր է ավտոմատ որոշել մասնակիցը համապատասխան նախագծին մասնակցելու իրավունք ունի թե ոչ։</p>
		</div>
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
	   <table>
	     <tr>
	       <td>Պահանջ</td>
	       <td>Ունի</td>
	     </tr>
	     <?php 
	     $cols = article_of_the_year();
		switch ($_GET["election"]) {
			case '1':
				$cols = article_of_the_year();
				break;
			case '2':
				$cols = featured_articles();
				break;
			case '3':
				$cols = good_articles();
				break;
			case '4':
				$cols = admin_elect();
				break;
			case '5':
				$cols = del_elect();
				break;
		}
	     foreach ($cols as $row) : ?>
	     <tr bgcolor="<?php echo $row[2]; ?>">
	       <td><?php echo $row[0]; ?></td>
	       <td><?php echo $row[1]; ?></td>
	     </tr>
	     <?php endforeach; ?>
	   </table>
	</body>
</html>