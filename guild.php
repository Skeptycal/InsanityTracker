<?php
	include('init.php');

	$realm = check_realm("/insanity/guild/REGION/REALM/$_GET[name]/");

	$region_enc = AddSlashes($_GET['region']);
	$realm_enc = AddSlashes($_GET['realm']);
	$name_enc = AddSlashes($_GET['name']);

	list($num_total) = db_list(db_fetch("SELECT COUNT(*) FROM characters WHERE region='$region_enc' AND realm='$realm_enc' AND guild='$name_enc'"));

	$ret = db_fetch("SELECT * FROM characters WHERE region='$region_enc' AND realm='$realm_enc' AND guild='$name_enc' AND got_it=1 ORDER BY date_got ASC");
	if (!count($ret['rows'])){

		if ($num_total){
			include('guild_notinsane.php');
		}else{
			include('guild_notfound.php');
		}
		exit;
	}
	$chars = $ret['rows'];
	$name = $chars[0]['guild'];

	$guild = db_single(db_fetch("SELECT * FROM guilds WHERE region='$region_enc' AND realm='$realm_enc' AND name='$name_enc'"));

	foreach ($chars as $k => $v){
		assign_patch($chars[$k]);
	}

	function format_rank($i){
		if ($i == 0) return '<i>unranked</i>';
		return $i;
	}

	include('head.txt');
?>

<h1>
	<a href="/insanity/">Insanity</a>
	/
	<a href="/insanity/guilds/<?=$realm['region']?>/"><?=StrToUpper($realm['region'])?></a>
	/
	<a href="/insanity/guilds/<?=$realm['region']?>/<?=$realm['slug']?>/"><?=HtmlSpecialChars(realm_name($realm))?></a>
	/
	<?=HtmlSpecialChars($name)?>
</h1>

<p>
	Realm rank:				<?=format_rank($guild['rank_realm'])?><br />
	<?=StrToUpper($realm['region'])?> rank:	<?=format_rank($guild['rank_region'])?><br />
	World rank:				<?=format_rank($guild['rank_world'])?><br />
</p>

<?
	$characters = $chars;
	include('inc_list.php')
?>

<?
	include('add.txt');
	include('foot.txt');
?>
