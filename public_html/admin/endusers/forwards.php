<?
    require_once("../util/tree.php");
		require_once("../util/endUser.php");
		require_once("../util/endUsers.php");
    $users    = new endUsers($dba);
    $userList = $users->getUsers();
    
    if( !$id ) $id = $_GET["id"];
    if( !$id ) $id = $_POST["id"];


    if( !$id ) $id = $userList[0]["id"];
    if( !$id ) $id = 1;
		
		$user = new endUser( new dba(), $id );

	  if( !$docId ) $docId = $_POST["docId"];
    if( !$PHP_SELF ) $PHP_SELF = $_SERVER["PHP_SELF"];
   
    if( $docId == $user->getRoleForward() )
		{
			$user->setForward( 0 );
		}
		else
		{
			if( $docId ) $user->setForward( $docId );
		}
		
		$forward4user = $user->getRoleForward();

    $tree = new tree( $dba, session_id(), 'tree' );
    if( !$toggle ) $toggle = $_GET["toggle"];
    if( !$toggle ) $toggle = $_POST["toggle"];
    $tree->toggle( $toggle );
?>
<script language="javascript">
	function changeRole()
	{
		alert('changin role');
		document.tree.submit();
	}
	function toggling( id )
	{
		document.tree.toggle.value = id;
		document.tree.submit();
	}
	function selectNode( id )
	{
		document.tree.docId.value = id;
		document.tree.submit();
	}

</script>
<form name="tree" action="<?=$PHP_SELF?>" method="post">
    <input type="hidden" name="pane" value="forwards">
    <input type="hidden" name="toggle">
    <input type="hidden" name="docId">
		
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><img src="../graphics/transp.gif" border="0" height="20">	</td>
	</tr>
	<tr>
		<td class="header">Document forward for user "<?=( $user->full_name )? $user->full_name: $user->name;?>"</td>
	</tr>
	<tr>
		<td><img src="../graphics/transp.gif" border="0" height="15">	</td>
	</tr>
</table>
	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="color1">
		<tr>
			<td width="1"><img src="../graphics/transp.gif" border="0" height="250" width="1"></td>
			<td valign="top">
	    	<table cellpadding="0" cellspacing="0" border="0">
	    		<tr>
	      		<td valign="top" class="tdpadtext" style="padding-right:15px;">
							Select user<br/>
							<select name="id" class="select_list" onchange="document.tree.submit()">
								<? for( $i = 0; $i< count( $userList ); $i++ ):?>
									<option value="<?=$userList[$i]["id"]?>" <? if( $userList[$i]["id"] == $id ) echo "selected";?> ><?=( $userList[$i]["full_name"] )? $userList[$i]["full_name"]: $userList[$i]["name"];?></option>
								<? endfor?>
							</select>
						</td>
	          <td valign="top" class="tdpadtext">
							Select document to farward to upon logon<br/>
							<!-- Her starter tabellen for tr�et-->
							<?
							$nodes =  $tree->getNodeArray();
							$n = count( $nodes );
							?>
							<table width="250" cellpadding="0" cellspacing="0" border="0" class="tdpadtext">
								<?for( $i = 0; $i < $n; $i++ ):?>
								<tr>
									<?//==================NODE TABLE CELL============================?>
									<td>
								    <table cellpadding="0" cellspacing="0" border="0">
											<tr>
								      	<?//==================SPACER CELL============================?>
								        <td width="<?=( $nodes[$i]["level"] ) * 10 ?>"><img src="../tree/graphics/space.gif" width="<?=( $nodes[$i]["level"] ) * 10 ?>" height="10" alt="space"\></td>
								        <?//==================DISCLOSURE TRIANGLE CELL============================?>
								        <td><a href="#" onclick="toggling( <?=$nodes[$i]["id"]?> )" title="Toggle" onfocus="if(this.blur)this.blur();"><img src="../tree/graphics/<?=( $nodes[$i]["open"] )? "down": "up" ?><?=( $nodes[$i]["node"] )? "node":"leaf"?>.gif" alt="Toggle" border="0"\></a></td>
							          <?//==================NODE ICON CELL============================?>
							          <td><a href="#" onclick="selectNode( <?=$nodes[$i]["id"]?> )" title="Select" class="nodeName" onfocus="if(this.blur)this.blur();"><img src="../tree/graphics/doc<?=( $forward4user == $nodes[$i]["id"] )?"":"_gray"?>.gif" alt="Toggle" border="0"/></a></td>
												<?//==================SPACER CELL============================?>
												<td><img src="../tree/graphics/space.gif" width="5" height="10" alt="space"\></td>
												<?//==================ITEM NAME CELL============================?>
								        <td><a href="#" onclick="selectNode( <?=$nodes[$i]["id"]?> )" title="Select" class="nodeName<?=( $forward4user == $nodes[$i]["id"] )?"":"_gray"?>" onfocus="if(this.blur)this.blur();"><?=$nodes[$i]["name"] ?></a></td>
											</tr>
										</table>
									</td>
								</tr>
								<?endfor?>
							</table>
							<!-- HER SLUTTER TR�ET-->
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
