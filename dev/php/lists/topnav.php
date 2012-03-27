<?php
echo '
<div class="topNav">
			<ul class="topNav">
				<li class="about">
					<a href="'.$contextRoot.'about.php">About</a>
				</li>
                <li class="bikes">
					<a href="'.$contextRoot.'">Bikes<img src="'.$contextRoot.'images/downarrow.png" alt="arrow"/></a>
					<ul>
						<li><a href="'.$contextRoot.'steel_road.php">Steel Road</a></li>
                        <li><a href="'.$contextRoot.'steel_mtn.php">Steel Mountain</a></li>
                        <li><a href="'.$contextRoot.'steel_cross.php">Steel Cross</a></li>
                        <li><a href="'.$contextRoot.'steel_track.php">Steel Track</a></li>
                        <li><a href="'.$contextRoot.'steel_single.php">Steel Single Speed</a></li>
                        <li><a href="'.$contextRoot.'ti_road.php">Titanium Road</a></li>
                        <li><a href="'.$contextRoot.'ti_mtn.php">Titanium Mountain</a></li>
                        <li><a href="'.$contextRoot.'ti_cross.php">Titanium Cross</a></li>
                        <li><a href="'.$contextRoot.'ti_single.php">Titanium Single Speed</a></li>
					</ul>                    
				</li>
                <li class="ordering">
					<a href="'.$contextRoot.'">Ordering<img src="'.$contextRoot.'images/downarrow.png" alt="arrow"/></a>
					<ul>
						<li><a href="'.$contextRoot.'orders_new.php">New Bike Orders</a></li>
                        <li><a href="'.$contextRoot.'orderform/DeSalvo-Order-Form.pdf">Order Form</a></li>
                        <li><a href="'.$contextRoot.'buildkits.php">Build Kits</a></li>
					</ul>
				</li>
                <li class="partners">
					<a href="'.$contextRoot.'links.php">Partners</a>
				</li>
                <li class="contact">
					<a href="'.$contextRoot.'contact.php">Contact</a>
				</li>
			</ul>
</div>
';
?>
<!-- This is the topnavigation ul for the e-commerce side of the site. When Mike is ready this will be re-added.
<li class="store">
    <a href="'.$contextRoot.'">Store<img src="'.$contextRoot.'images/downarrow.png" alt="arrow"/></a>
	<ul>
	    <li><a href="">Softgoods</a></li>
        <li><a href="">Bikes</a></li>
        <li><a href="">Sale Items</a></li>
	</ul>
</li>
-->