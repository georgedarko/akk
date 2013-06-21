
<!-- hero-unit -->
    		<div class="hero-unit drop-shadow raised">
	        	<form class="form-inline" action="actions/login.php">
	        		<input type="text" class="input-small" placeholder="Email" name="email">
	        		<input type="password" class="input-small" placeholder="Password" name="password">
	        		<input type="submit" class="btn btn-success" value="Sign In">
	        	</form>
<?
if ($_REQUEST['err']==3||$_REQUEST['err']==5||$_REQUEST['err']==6||$_REQUEST['err']==47||$_REQUEST['err']==36){
   echo notify(get_message_text($_REQUEST['err']), $_REQUEST['err']);  
}		
?>      		</div>
      		<!-- End hero-unit -->
		
