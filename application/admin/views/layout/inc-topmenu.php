<?php if ($CI->getUser()) { ?>
	<ul class="sf-menu">
<!--		<li><a href="javascript:void(0)">Manage Content</a>
			<ul>
				<li><a href="cms/type/index/">Manage Pages Types</a></li>
				<li><a href="cms/page">Manage Pages</a></li>
				<li><a href="cms/template">Manage Template</a></li>
				<li><a href="cms/menu">Manage Menus</a></li>
				<li><a href="news">Manage News</a></li>
				<li><a href="casestudy">Manage Case Studies</a></li>
				<li><a href="shipping/weight_shipping">Manage Shipping</a></li>
				<li><a href="slideshow">Manage Slide Show</a></li>
				<li><a href="review">Manage Reviews</a></li>
				<li><a href="pricing/pricing_plans">Manage Pricing Plan</a></li>
			</ul>
		</li>-->
		<li><a href="javascript:void(0)">Manage Catalog</a>
			<ul>
				<li><a href="catalog/category">Manage Categories</a></li>
                                <li><a href="catalog/attribute">Manage Attributes</a></li>
                                <!--<li><a href="catalog/assignattrcat">Assign Attributes To Category</a></li>-->
				<!--<li><a href="catalog/product_type">Manage Product Types</a></li>-->
				<li><a href="catalog/product">Manage Products</a></li>
<!--				<li><a href="supplier">Manage Suppliers</a></li>-->
				<!--<li><a href="coupon">Manage Coupons</a></li>-->
				<!--<li><a href="catalog/product/index/0/1">Manage Packages</a></li>-->
				<!--<li><a href="package/shows">Manage Show Packages</a></li>-->
			</ul>
		</li>
		<li><a href="javascript:void(0)">Manage Users</a>
			<ul>
				<li><a href="user/userprofile">Manage Profile Groups</a></li>
				<li><a href="user">Manage Users</a></li>
			</ul>
		</li>
	<!--	<li><a href="customer">Manage Customers</a>
			<ul>
				<li><a href="customer/pending">Pending Registration</a></li>
			</ul>
		</li>
		<li><a href="javascript:void(0)">Miscellaneous</a>
			<ul>
				<li><a href="setting/settings">Settings</a></li>
				<li><a href="admin/changepassword">Change Password</a></li>
			</ul>
		</li>-->
	</ul>
<?php } ?>
