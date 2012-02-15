<?php

	include('init.php');

	$ret = db_fetch("SELECT * FROM realms ORDER BY total_insane DESC LIMIT 20");

	include('head.txt');
?>

<h1>
	Insanity
</h1>

<table width="100%"><tr valign="top"><td width="50%">

	<h2>Top Realms</h2>

	<table>
<? foreach ($ret['rows'] as $row){ ?>
		<tr>
			<td><?=StrToUpper($row['region'])?></td>
			<td><a href="/insanity/<?=$row['region']?>/<?=urlencode($row['slug'])?>/"><?=HtmlSpecialChars(realm_name($row))?></a></td>
			<td><?=$row['total_insane']?></td>
		</tr>
<? } ?>
	</table>

</td><td>

	<h2>Realms by region</h2>

	<ul>
<? foreach ($GLOBALS['cfg']['bnet_region_hosts'] as $k => $v){?>
		<li><a href="/insanity/<?=$k?>/"><?=StrToUpper($k)?></a>
<? } ?>
	</ul>

</td></tr></table>

<?
	include('foot.txt');
?>