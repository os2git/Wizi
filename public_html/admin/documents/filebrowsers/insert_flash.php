<?php
include_once( "../../util/dba.php" );
include_once( "../../util/tree.php" );
include_once( "../../util/mediaTree.php" );

session_start();
$dba = new dba();
$root = 1;
$tree = new mediaTree( $dba, session_id(), 'mediatree' );

$mediaLib = $dba->rootpath."media/";

//get parameters
$id			= $_POST["id"];
$action	= $_POST["action"];
$toggle = $_POST["toggle"];
$browser = $_GET["browser"];

if (!$id) 		$id			= $_GET["id"];
if (!$action) $action	= $_GET["action"];
if (!$toggle) $toggle	= $_GET["toggle"];
if (!$browser) $browser	= $_POST["browser"];

$formats = array("doc","gif","jpg","mdb","pdf","ppt","png","swf","wvx","xls");

$tree->toggle( $toggle );
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>Insert flash files</title>
		<link rel="stylesheet" href="../../style/style.css" type="text/css">
		<script src="thescript.js" language="javascript" type="text/javascript"></script>
</head>
<body>
<?
			$nodes =  $tree->getNodeArray();
			$n = count( $nodes );
		?>
		<h1>Select flash to insert:</h1>
		<table cellpadding="0" cellspacing="0" border="0">
			<? for( $i = 0; $i < $n; $i++ ):?>
				<? $format = $nodes[$i]["format"];?>
				<? $imgPath = $mediaLib.$nodes[$i]["id"].".".$nodes[$i]["format"];?>
				<? if( !in_array($format, $formats) ) $format = 'general';?>
			<tr>
				<td>
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="<?=( $nodes[$i]["level"] ) * 10 ?>"><img src="../../mediatree/graphics/space.gif" width="<?=( $nodes[$i]["level"] ) * 10 ?>" height="10" alt="space"\></td>
							<td>
								<a href="<?=$_SERVER["PHP_SELF"]?>?toggle=<?=$nodes[$i]["id"]?>&browser=<?=$browser?>" title="Toggle"><img src="../../mediatree/graphics/<?=( $nodes[$i]["open"] )? "down": "up" ?><?=( $nodes[$i]["node"] )? "node":"leaf"?>.gif" alt="Toggle" border="0"\></a></td>
							<td>
								<? if ($format == 'swf'):?>
									<a href="javascript:" onClick="chooseFlash('<?php echo $imgPath; ?>','<?=$nodes[$i]["width"]?>','<?=$nodes[$i]["height"]?>');" title="Select" class="nodeName"><img src="../../mediatree/graphics/file_icons/<?=$format?>.gif" alt="Select" border="0"/></a>
								<? else:?>
									<img src="../../mediatree/graphics/file_icons/<?=$format?>_gray.gif" alt="Select" border="0"/>
								<? endif?>
							</td>
							<td><img src="../../mediatree/graphics/space.gif" width="5" height="10" alt="space"\></td>
							<td class="nodeName">
								<? if ($format == 'swf'):?>
									<a href="javascript:" onClick="chooseFlash('<?php echo $imgPath; ?>','<?=$nodes[$i]["width"]?>','<?=$nodes[$i]["height"]?>');" title="Select" class="nodeName"><?=$nodes[$i]["name"] ?></a>
								<? else:?>
									<?=$nodes[$i]["name"] ?>
								<? endif?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<? endfor?>
	</table>
</body>
</html>