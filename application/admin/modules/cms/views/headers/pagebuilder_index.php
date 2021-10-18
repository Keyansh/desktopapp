<?php
global $DWS_MIN_JS_ARR, $DWS_JS_ARR, $DWS_MIN_CSS_ARR;
// $DWS_JS_ARR[] = 'js/tinymce/tiny_mce.js';
// $DWS_JS_ARR[] = 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php';
$DWS_JS_ARR[] = 'assets/tinymce/tinymce.min.js';
$DWS_JS_ARR[] = 'js/cropper.js';
$DWS_MIN_CSS_ARR[] = 'css/pagetree.css';
$DWS_MIN_CSS_ARR[] = 'css/cropper.css';
?>
<link rel="stylesheet" href="<?= $this->config->item('site_url') ?>css/main.css">
<link rel="stylesheet" href="<?= $this->config->item('site_url') ?>css/style.css">
<link rel="stylesheet" href="<?= $this->config->item('site_url') ?>css/default_theme.css">
<link rel="stylesheet" href="<?= $this->config->item('site_url') ?>css/my_theme.css">

<style>
	@font-face {
		src: url(../fonts/Poppins-Regular.ttf);
		font-family: Poppins-Regular
	}

	@font-face {
		src: url(../fonts/Poppins-Medium.ttf);
		font-family: Poppins-Medium
	}

	@font-face {
		src: url(../fonts/Poppins-MediumItalic.ttf);
		font-family: Poppins-MediumItalic
	}

	@font-face {
		src: url(../fonts/Poppins-SemiBold.ttf);
		font-family: Poppins-SemiBold
	}

	@font-face {
		src: url(../fonts/Poppins-Light.ttf);
		font-family: Poppins-Light
	}

	@font-face {
		src: url(../fonts/Poppins-LightItalic.ttf);
		font-family: Poppins-LightItalic
	}

	@font-face {
		src: url(../fonts/Poppins-Bold.ttf);
		font-family: Poppins-Bold
	}

	@font-face {
		src: url(../fonts/Poppins-ExtraBold.ttf);
		font-family: Poppins-ExtraBold
	}

	@font-face {
		src: url(../fonts/Poppins-ExtraLight.ttf);
		font-family: Poppins-ExtraLight
	}

	* {
		scrollbar-width: thin;
		scrollbar-color: #000 #f15f22
	}

	::-webkit-scrollbar {
		width: 12px
	}

	::-webkit-scrollbar-track {
		background: #f15f22
	}

	::-webkit-scrollbar-thumb {
		background-color: #000;
		border-radius: 20px;
		border: 3px solid #f15f22
	}

	body {
		font-family: Poppins-Regular;
		position: relative;
		min-height: 100vh
	}

	a,
	a:focus,
	a:hover {
		text-decoration: none
	}

	.padding-zero {
		padding: 0
	}

	#header-section {
		background: #f60
	}

	.crb-section {
		padding: 0
	}

	#crb-section .container-fluid {
		padding: 0
	}

	.home-link {
		font-size: 18px;
		color: #fff;
		line-height: normal;
		transition: .3s;
		font-family: Poppins-medium;
		border-bottom: 2px solid #f60
	}

	.header-navbar.list-inline.line-div {
		margin-bottom: 0;
		padding-top: 0
	}

	.header-section {
		padding: 30px 0
	}

	.header-navbar.list-inline.line-div li a {
		padding: 33px 6px 33px 6px;
		color: #fff
	}

	.header-nav.list-inline a {
		color: #fff;
		padding: 0 10px;
		font-size: 19px;
		transition: .2s
	}

	.header-main {
		padding: 0
	}

	.header-right-div {
		padding: 0
	}

	.header-inner-div {
		padding: 0
	}

	.header-nav.list-inline {
		margin-bottom: 0
	}

	.home-link.active,
	.home-link:hover {
		text-decoration: none;
		border-bottom: 2px solid #fff
	}

	.social-link:hover {
		text-decoration: none;
		transform: scale(1.2)
	}

	#home-slider .owl-nav .owl-prev {
		position: absolute;
		top: 50%;
		left: 0;
		transform: translatey(-50%);
		margin: 0
	}

	#home-slider .owl-nav .owl-prev span {
		background-image: url(../images/left.png);
		background-repeat: no-repeat;
		font-size: 0;
		height: 70px;
		width: 70px;
		display: table;
		background-color: #777;
		background-position: center
	}

	#home-slider .owl-nav .owl-next {
		position: absolute;
		top: 50%;
		right: 0;
		transform: translatey(-50%);
		margin: 0
	}

	#home-slider .owl-nav .owl-next span {
		background-image: url(../images/right.png);
		background-repeat: no-repeat;
		font-size: 0;
		height: 70px;
		width: 70px;
		display: table;
		background-color: #777;
		background-position: center
	}

	#home-slider {
		position: relative
	}

	.header-top {
		display: flex;
		flex-wrap: wrap;
		align-items: center;
		text-align: right;
		padding: 0
	}

	.main-featured-links {
		border-bottom: none;
		margin: auto;
		display: table;
		margin-bottom: 50px;
		text-transform: uppercase
	}

	.digital-heading {
		font-size: 35px;
		line-height: 40px;
		color: #000;
		font-family: poppins-medium
	}

	.digital-sub-heading {
		font-size: 54px;
		line-height: 60px;
		color: #000;
		font-family: poppins-ExtraLight;
		margin-bottom: 25px
	}

	.digital-border-section {
		padding: 70px 0 50px 0
	}

	.digital-text {
		font-size: 17px;
		line-height: normal;
		color: #000;
		font-family: poppins-regular;
		margin-bottom: 22px
	}

	.promote-dummy-text {
		font-size: 17px;
		line-height: normal;
		color: #666;
		font-family: poppins-regular;
		margin-top: 10px
	}

	#digital-promote-section {
		background: #efefef
	}

	.digital-promote-inner-div {
		text-align: center
	}

	.digital-promote-div {
		padding: 0
	}

	.promote-heading {
		font-size: 22px;
		line-height: normal;
		color: #000;
		font-family: poppins-regular;
		margin-bottom: 8px
	}

	.promote-div {
		margin-bottom: 15px
	}

	.read-div {
		padding-top: 15px
	}

	.digital-main-img {
		padding-right: 0
	}

	.digital-promote-inner-div {
		padding: 0 40px
	}

	.digital-promote-main {
		padding: 30px 40px;
		transition: .2s
	}

	.digital-promote-section {
		padding-top: 35px
	}

	.promote-img {}

	.digital-main-text {
		padding-left: 0
	}

	.color-dot {
		color: #f60;
		font-size: 90px
	}

	.read-btn {
		font-size: 17px;
		line-height: normal;
		color: #000;
		padding: 7px 20px 7px 20px;
		border: 2px solid #000;
		display: table;
		border-radius: 20px;
		transition: .3s
	}

	.read-btn:focus,
	.read-btn:hover {
		color: #f60;
		background-color: #fff;
		text-decoration: none;
		border: 2px solid #fff;
		outline: 0
	}

	.read-div.subcribe-div a {
		margin: 0 !important;
		transition: .2s
	}

	.read-div.subcribe-div a:focus,
	.read-div.subcribe-div a:hover {
		background-color: #f60;
		color: #fff;
		text-decoration: none;
		outline: 0
	}

	#digital-border-section {
		background: #efefef
	}

	.digital-promote-main.active,
	.digital-promote-main:hover {
		background: #fff;
		border-radius: 10px;
		box-shadow: 2px 1px 12px rgba(0, 0, 0, .5)
	}

	.digital-promote-section {
		padding-bottom: 90px
	}

	#stelios-section {
		position: relative
	}

	#stelios-section .container-fluid {
		padding: 0
	}

	.stelios-section {
		padding: 0
	}

	.man-info-div {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		max-width: 90%
	}

	#stelios-section .container-fluid {
		width: 100%
	}

	.stelios-heading {
		font-size: 25px;
		line-height: normal;
		color: #efefef;
		font-family: poppins-medium;
		margin-bottom: 0
	}

	.dummy-text {
		font-size: 17px;
		line-height: normal;
		color: #fff;
		font-family: poppins-regular;
		margin-bottom: 25px
	}

	.man-info-div {
		padding: 0
	}

	.sir-name-text {
		font-size: 50px;
		line-height: 50px;
		color: #efefef;
		font-family: poppins-Extralight;
		margin-bottom: 25px
	}

	.gallery-work-heading {
		font-size: 32px;
		line-height: normal;
		color: #000;
		font-family: poppins-Semibold;
		margin-bottom: 0;
		text-align: center
	}

	.featured-text,
	.featured-work-text {
		padding: 0
	}

	#featured-work-text {
		background: #efefef
	}

	.gallery-work-text {
		font-size: 18px;
		line-height: normal;
		color: #000;
		font-family: poppins-light;
		margin-bottom: 15px;
		text-align: center
	}

	.featured-work-text {
		padding: 60px 0
	}

	.digital-img img {
		width: 100%
	}

	.item-img:hover .doublecolor-btn {
		transform: scale(1);
		transition: .3s
	}

	.doublecolor-btn {
		position: absolute;
		bottom: 0;
		left: 0;
		height: 100%;
		width: 100%;
		background: rgba(239, 96, 2, .8);
		display: flex;
		flex-wrap: wrap;
		transform: scale(0);
		justify-content: center;
		align-content: flex-end
	}

	.tab-content.col-xs-12 {
		position: relative;
		padding: 0
	}

	.item-img {
		padding: 0
	}

	.featured-links {
		padding: 0
	}

	.item-inner img {
		width: 100%
	}

	.full-fledge-item {
		padding: 0;
		width: calc(100% + 48px);
		margin-left: -24px
	}

	.nav-tabs>li.active>a,
	.nav-tabs>li.active>a:focus,
	.nav-tabs>li.active>a:hover {
		color: #fff !important;
		cursor: default;
		background-color: #f60;
		border: 1px solid #f60;
		border-bottom-color: #f60;
		outline: 0
	}

	.nav-tabs>li>a:hover {
		border-color: #f60
	}

	.nav.nav-tabs.main-featured-links li a {
		font-size: 16px;
		line-height: normal;
		color: #000;
		font-family: poppins-light;
		border-radius: 0;
		text-transform: capitalize
	}

	.nav.nav-tabs.main-featured-links {
		border-bottom: 1px solid #f60;
		margin: 45px auto
	}

	.web-text {
		font-size: 17px;
		line-height: normal;
		color: #efefef;
		font-family: poppins-medium;
		padding: 0;
		margin-bottom: 0
	}

	.easy-text-hover {
		font-size: 26px;
		line-height: normal;
		color: #efefef;
		font-family: poppins-medium
	}

	.item-inner {
		padding: 0
	}

	.item-img {
		padding: 0 24px;
		margin-bottom: 50px
	}

	.right-arrow i {
		font-size: 30px;
		border: 1px solid #fff;
		padding: 2px 12px;
		color: #fff;
		border-radius: 20px
	}

	.right-arrow {
		padding: 0;
		margin-top: 20px
	}

	.read-div.explore-div a {
		margin: auto;
		border: 2px solid #000
	}

	.read-div.explore-div a:hover {
		background-color: #f60;
		color: #fff;
		border: 2px solid #f60
	}

	#trusted-section .container-fluid {
		padding: 0
	}

	#trusted-section {
		background: #efefef
	}

	.trusted-top-text {
		font-size: 20px;
		line-height: normal;
		color: #fff;
		font-family: Poppins-LightItalic;
		text-align: center;
		margin: auto;
		width: 40%
	}

	.half-text-div {
		background: #fff;
		margin-left: -160px;
		padding: 45px 50px 45px 50px;
		width: calc(50% + 160px)
	}

	.half-img-text-div {
		display: flex
	}

	.digital-sub-heading.half-heading {
		font-size: 49px;
		line-height: 48px
	}

	.trusted-div-text {
		position: absolute;
		top: 34%;
		left: 0;
		transform: translatey(-50%)
	}

	.trusted-section {
		position: relative
	}

	.half-img-div {
		margin-top: -130px
	}

	#parters-section {
		background: #efefef
	}

	.parters-section {
		padding: 40px 0
	}

	.partner-div {
		padding: 0 5px;
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		align-items: center;
		min-height: 110px
	}

	.form-section {
		padding: 60px 150px
	}

	.simple-text {
		padding: 0 30px
	}

	.form-heading {
		font-size: 32px;
		line-height: normal;
		color: #fff;
		font-family: poppins-medium;
		text-align: center;
		margin-bottom: 55px
	}

	#form-section {
		background-image: url(../images/form--bg.jpg);
		background-repeat: no-repeat;
		background-size: 100% 100%
	}

	.form-control {
		border-radius: 0 !important
	}

	.text-div {
		padding-left: 0
	}

	.simple-request {
		font-size: 16px;
		line-height: 25px;
		color: #fff;
		font-family: poppins-Light;
		width: 100%;
		padding: 7px;
		border: none;
		border-bottom: 1px solid #fff;
		background: 0 0;
		height: 45px;
		display: table;
		margin-bottom: 42px;
		padding-bottom: 0;
		padding-left: 0;
		box-shadow: none;
		border-radius: 0 !important
	}

	#unique {
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none
	}

	.main-carot {
		background-image: url(../images/dropdown.png) !important;
		background-repeat: no-repeat !important;
		background-position: right !important;
		cursor: pointer;
		background-size: 30px !important
	}

	.book-request-div {
		font-size: 16px;
		line-height: 25px;
		color: #fff;
		width: 100%;
		padding: 0;
		background: 0 0;
		height: 45px;
		display: table;
		margin-bottom: 42px;
		padding-bottom: 0;
		font-family: poppins-light;
		box-shadow: none;
		border: none;
		border-radius: none !important;
		border-bottom: 1px solid #fff
	}

	.simple-text.contact-div {
		padding-right: 0
	}

	.submit-div a {
		margin: auto;
		padding: 5px 30px;
		transition: .3s;
		color: #fff;
		border: 1px solid #fff
	}

	.submit-div a:hover {
		border: 1px solid #fff
	}

	.form-control::placeholder {
		color: #fff;
		opacity: 1
	}

	.service1 {
		font-size: 15px;
		color: #666;
		font-family: poppins-medium;
		line-height: normal;
		transition: .3s
	}

	.footer-heading {
		font-size: 25px;
		color: #f60;
		font-family: Capriola-Regular;
		line-height: normal
	}

	.service1:focus,
	.service1:hover {
		color: #f60;
		text-decoration: none
	}

	.customer-data {
		display: flex;
		flex-wrap: wrap;
		padding: 40px 15px
	}

	.customer-data .col-sm-3 {
		width: calc(100% / 5)
	}

	.satisfy-parent {
		margin-top: 40px
	}

	.services-heading {
		font-size: 17px;
		line-height: normal;
		color: #000;
		font-family: poppins-medium
	}

	.last-text {
		border-top: 1px solid #d3d3d3;
		padding: 18px 15px
	}

	#footer-section .container-fluid {
		padding: 0
	}

	#footer-section {
		background: #f9f9f9;
		display: table;
		width: 100%;
		position: absolute;
		left: 0;
		bottom: 0
	}

	.last-text-left {
		font-size: 16px;
		line-height: normal;
		color: #666
	}

	.last-text-right a {
		font-size: 16px;
		line-height: normal;
		color: #666;
		float: right;
		padding-left: 20px;
		transition: .3s
	}

	.last-text-right a:focus,
	.last-text-right a:hover {
		color: #f60;
		text-decoration: none
	}

	.news-feed-div {
		padding-right: 0
	}

	.footer-text {
		font-size: 14px;
		line-height: normal;
		color: #666;
		font-family: poppins-medium;
		padding-right: 30px;
		margin-top: 16px
	}

	.parent-service {
		padding-left: 0
	}

	.footer-input {
		border-bottom: 1px solid #000;
		color: #000
	}

	.footer-input.form-control::placeholder {
		color: #000
	}

	#crb-section .container-fluid {
		width: 100%
	}

	#grid-section {
		background: #efefef
	}

	.gg-element img {
		border-radius: 0
	}

	.service-grid-heading {
		font-size: 34px;
		line-height: 30px;
		color: #000;
		font-family: poppins-semibold;
		text-align: center;
		margin-bottom: 20px
	}

	.service-grid-text {
		font-size: 19px;
		line-height: normal;
		color: #000;
		font-family: poppins-light;
		text-align: center;
		margin-bottom: 20px
	}

	.design-text {
		font-size: 17px;
		line-height: normal;
		color: #000;
		font-family: poppins-medium
	}

	.grid-section {
		margin-top: -176px;
		z-index: 99;
		background: #fff;
		padding: 40px 20px
	}

	.gg-element p {
		position: absolute;
		bottom: 0%;
		left: 0;
		transition: .2s;
		background: #fff;
		margin-bottom: 0;
		padding: 0 10px
	}

	.gg-element:hover p {
		bottom: 0
	}

	.gg-element {
		position: relative;
		overflow: hidden
	}

	.get_text {
		font-size: 24px;
		line-height: normal;
		color: #fff;
		font-family: poppins-Semibold;
		margin-bottom: 0
	}

	.get_right_side {
		position: fixed;
		top: 50%;
		right: -380px;
		z-index: 9999999;
		transform: translatey(-50%);
		padding: 18px 10px;
		cursor: pointer;
		transition: .2s;
		width: 380px;
		display: flex;
		align-items: center
	}

	.right_side_button_div {
		position: relative;
		padding: 0
	}

	.right-side-heading-col {
		position: absolute;
		z-index: 1;
		left: -140px;
		transform: rotate(-90deg) translateY(-50%);
		background: #f6f6f6;
		top: calc(50% - 20px);
		font-size: 20px;
		font-family: poppins-medium;
		padding: 10px 60px 12px 56px;
		cursor: pointer;
		transition: .2s;
		background-color: #f60;
		border-top-left-radius: 10px;
		border-top-right-radius: 10px
	}

	.get_right_side.main .right-side-heading-col {
		transform: translateX(-50%) rotate(180deg);
		left: 0;
		background: url(../images/portfolio-left.jpg) no-repeat;
		width: 33px;
		height: 33px;
		border-radius: 50px !important;
		padding: 0 0
	}

	.get_right_side.main .right-side-heading-col .get_text {
		display: none
	}

	.get_right_side.main {
		right: -11px
	}

	.quote-right.side_top_quote {
		background: #000;
		padding: 20px 0;
		border-radius: 20px
	}

	.right-side-heading-col {
		font-size: 20px;
		font-family: poppins-Semibold;
		cursor: pointer;
		color: #fff
	}

	.digital-border-section .read-div a {
		background-color: #f60;
		color: #fff;
		border-color: #f60
	}

	#common-banner-section .container-fluid {
		padding: 0
	}

	.common-banner-section {
		position: relative;
		margin-bottom: -60px
	}

	.common-banner-text-div {
		position: absolute;
		top: 74px;
		left: 0;
		transform: translateY(-50%);
		text-align: center
	}

	.common-banner-heading {
		font-size: 32px;
		line-height: normal;
		color: #fff;
		font-family: poppins-Semibold;
		margin-bottom: 0
	}

	.common-banner-text {
		font-size: 22px;
		line-height: normal;
		color: #fff;
		font-family: poppins-Semibold
	}

	.franchise-heading {
		font-size: 32px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium;
		margin-bottom: 12px
	}

	.main-accordion-heading {
		font-size: 22px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium;
		margin-bottom: 12px
	}

	#franchise-section {
		background: #efefef
	}

	.accordion-text-div {
		margin-top: 20px
	}

	.accordion-inner {
		padding-bottom: 30px
	}

	.panel.panel-default.accordion-group {
		margin-bottom: 30px !important
	}

	.accordion-heading {
		font-size: 17px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium;
		margin-bottom: 32px
	}

	.accordion-color-heading {
		font-size: 19px;
		line-height: normal;
		color: #f60;
		font-family: poppins-Semibold;
		width: 100%;
		display: block;
		margin-bottom: 12px
	}

	.accordion-text {
		font-size: 17px;
		line-height: normal;
		color: #000;
		font-family: poppins-Regular
	}

	.educate-div {
		font-size: 17px;
		line-height: normal;
		color: #000;
		font-family: poppins-Semibold;
		display: block;
		width: 100%;
		padding-left: 40px
	}

	.educate-inner-div {
		background-image: url(../images/accordion-icon1.png);
		background-repeat: no-repeat;
		background-position: left bottom
	}

	.experience-inner-div {
		background-image: url(../images/accordion-icon2.png);
		background-repeat: no-repeat;
		background-position: left bottom
	}

	.experience-div {
		font-size: 17px;
		line-height: normal;
		color: #000;
		font-family: poppins-Semibold;
		display: block;
		width: 100%;
		padding-left: 40px
	}

	.apply-btn {
		font-size: 18px;
		line-height: normal;
		color: #f60;
		border: 2px solid #f60;
		padding: 8px 20px;
		display: table;
		border-radius: 30px;
		font-family: poppins-medium;
		transition: .3s
	}

	.apply-btn:hover {
		color: #fff;
		border: 2px solid #f60;
		text-decoration: none;
		background-color: #f60
	}

	.apply-btn:focus {
		color: #fff;
		border: 2px solid #f60;
		text-decoration: none;
		background-color: #f60
	}

	.apply-div {
		margin-top: 30px
	}

	.accordion-color-heading:focus,
	.accordion-color-heading:hover {
		color: #f60;
		text-decoration: none;
		outline: 0
	}

	.accordion-toggle:focus,
	.accordion-toggle:hover {
		text-decoration: none;
		outline: 0
	}

	.accordion-text:focus,
	.accordion-text:hover {
		color: #000;
		text-decoration: none;
		outline: 0
	}

	.franchise-text {
		font-size: 16px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium;
		margin-bottom: 30px
	}

	.franchise-section {
		background: #fff;
		padding: 40px 30px
	}

	.franchise-color {
		color: #f60;
		text-decoration-color: #f60;
		text-decoration: underline
	}

	.franchise-color a {
		color: #f60
	}

	.accordion-main-inner-div {
		margin: 40px 0 0 0
	}

	.franchise-div {
		margin-top: 30px
	}

	.franchise-text.franchise-dummy-text {
		margin-bottom: 20px
	}

	.franchise-img video {
		max-width: 100%
	}

	.accordion {
		position: relative
	}

	.franchise-accordion-div .panel-group .panel {
		margin-bottom: 30px;
		border-radius: 0;
		border: none;
		box-shadow: none;
		border-bottom: 2px solid #d3d3d3 !important
	}

	.franchise-accordion-div .panel-heading.accordion-heading {
		border: none;
		background: 0 0;
		padding: 0
	}

	.franchise-accordion-div .panel-default>.panel-heading {
		background-color: #fff !important;
		border-color: #fff !important;
		padding: 0 !important
	}

	.franchise-accordion-div .panel-title {
		padding-bottom: 20px
	}

	.franchise-accordion-div .panel-title a {
		display: table
	}

	.franchise-accordion-div .panel-title a:focus,
	.franchise-accordion-div .panel-title a:hover {
		text-decoration: none;
		outline: 0
	}

	.accordion-group {
		margin-bottom: 40px
	}

	#accordion .panel-title a {
		position: relative
	}

	.services-look-heading {
		font-size: 22px;
		line-height: normal;
		color: #000;
		font-family: Poppins-LightItalic
	}

	.image-hover-div {
		background: #fff;
		padding: 20px 10px;
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
		border-radius: 0 0 10px 10px;
		box-shadow: 2px 1px 12px rgba(0, 0, 0, .5)
	}

	.image-hover-div {
		background: #fff;
		padding: 20px 15px
	}

	.images-div.list-inline {
		width: 100%;
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between
	}

	.services-img-div img {
		width: 100%
	}

	.services-img-heading {
		font-size: 20px;
		line-height: normal;
		color: #000;
		font-family: Poppins-Medium
	}

	.services-section .simple-text {
		padding: 0 0
	}

	.services-listing.list-inline {
		margin: auto;
		display: table
	}

	.services-section .book-request-div {
		background-image: url(../images/color-caret.png) !important;
		background-repeat: no-repeat !important;
		background-position: right !important;
		border-bottom: 1px solid #000;
		font-size: 22px;
		color: #f60;
		padding-right: 30px;
		background-size: 20px !important
	}

	.services-link-text {
		color: #999;
		font-size: 22px
	}

	.services-inner-div {
		margin-bottom: 45px;
		transition: .2s
	}

	.services-inner-div:hover .image-hover-div {
		background-color: #f60;
		box-shadow: none
	}

	.services-inner-div:hover .images-div {
		background-image: url(../images/services-icon-white.png);
		background-repeat: no-repeat;
		background-position: 112% -11px
	}

	.services-inner-div:hover .image-hover-div ul li {
		color: #fff;
		box-shadow: none
	}

	.images-div {
		background-image: url(../images/service-icon.png);
		background-repeat: no-repeat;
		background-position: right
	}

	.franchise-inner-div {
		padding-left: 0;
		padding-right: 60px
	}

	.franchise-video-div {
		padding-right: 0
	}

	#services-section {
		background-color: #efefef
	}

	.services-category-div {
		background: #fff;
		padding: 40px 30px 0 30px
	}

	.services-listing-inner {
		padding: 0 30px 20px 30px
	}

	.stuff-heading {
		font-size: 30px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium
	}

	.stuff-text {
		font-size: 18px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium;
		width: 60%;
		margin: auto;
		margin-bottom: 30px
	}

	.download-icon-inner {
		margin-top: 25px
	}

	.easy-download-text {
		margin-top: 60px
	}

	.easymarketing-div {
		margin: 110px 0
	}

	.download-div-text {
		font-size: 17px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium;
		margin-bottom: 0
	}

	.easy-marketing-main-div {
		background: #efefef;
		padding: 130px 40px 30px 40px;
		text-align: center
	}

	.easy-stuff-heading {
		font-size: 30px;
		line-height: normal;
		color: #000;
		font-family: Poppins-Light;
		text-align: center;
		margin-bottom: 50px
	}

	.easy-download-inner-div {
		transition: .2s;
		padding: 0 40px
	}

	.easy-marketing-main-div:hover {
		background-color: #f60
	}

	.download-black-img {
		filter: brightness(100%)
	}

	.easy-marketing-main-div:hover .download-icon-inner img,
	.easy-marketing-main-div:hover .easy-marketing-logo-div img {
		filter: brightness(0) invert(1)
	}

	.download-easy-icon {
		filter: brightness(100) invert(1)
	}

	.easy-marketing-main-div:hover .down-icon,
	.easy-marketing-main-div:hover .download-div-text {
		color: #fff
	}

	.stuff-section {
		background: #fff;
		padding: 50px 30px 80px 30px
	}

	.down-icon {
		font-size: 30px
	}

	.stuff-inner-div {
		padding: 0;
		text-align: center
	}

	.stuff-inner-div .apply-div {
		margin: auto;
		display: table
	}

	.easy-text {
		font-size: 15px;
		line-height: normal;
		color: #666;
		font-family: poppins-LightItalic
	}

	.why-easy-text-div ul li {
		background-image: url(../images/why-easy-tick.png);
		background-repeat: no-repeat;
		list-style-type: none;
		padding-left: 30px;
		background-position: left 4px;
		margin-bottom: 3px
	}

	.why-easy-text-div p {
		font-size: 15px;
		line-height: normal;
		color: #666;
		font-family: poppins-LightItalic
	}

	.easy-text-list {
		padding-left: 0
	}

	.whyeasy-text {
		font-size: 16px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium;
		margin-bottom: 30px
	}

	#why-easy-section {
		background: #efefef
	}

	.why-easy-section {
		background: #fff;
		padding: 60px 40px 0 40px
	}

	.about-text {
		padding-left: 0
	}

	.about-text {
		font-size: 30px;
		line-height: normal;
		color: #666;
		font-family: poppins-LightItalic;
		margin-bottom: 70px;
		padding-right: 30px
	}

	.easy-text-inner {
		margin-bottom: 60px
	}

	.man-text-div {
		background-image: url(../images/why-easy-man.png);
		background-repeat: no-repeat;
		background-position: right bottom;
		background-size: contain
	}

	.why-easy-text-div {
		padding: 0 30px 0 0
	}

	.why-easy-inner-div {
		padding: 0 0 0 30px
	}

	.why-easy-text-div {
		position: relative
	}

	.why-easy-text-div::before {
		content: "";
		display: table;
		background: #efefef;
		width: 2px;
		height: 100%;
		position: absolute;
		top: 0;
		right: 0
	}

	.edge-btn {
		font-size: 15px;
		line-height: normal;
		color: #000;
		border: 2px solid #666;
		padding: 6px 14px;
		display: table;
		margin-bottom: 12px;
		transition: .2s
	}

	.edge-btn:focus,
	.edge-btn:hover {
		color: #f60;
		border: 2px solid #f60;
		text-decoration: none
	}

	.sort-heading {
		font-size: 24px;
		line-height: normal;
		color: #f60;
		font-family: poppins-LightItalic
	}

	.packages-section {
		background: #fff;
		padding: 30px 40px 100px 30px
	}

	.packages-section-div {
		margin-bottom: 50px
	}

	.ready-heading {
		font-size: 20px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium;
		text-align: center;
		margin-bottom: 10px
	}

	.ready-speed-text {
		font-size: 32px;
		line-height: normal;
		color: #f60;
		font-family: poppins-Semibold;
		text-align: center
	}

	.speed-div {
		font-family: poppins-Medium;
		font-size: 22px
	}

	.ready-text {
		font-size: 16px;
		line-height: normal;
		color: #666;
		font-family: poppins-Medium;
		margin-bottom: 30px
	}

	.speed_pre {
		padding-left: 0
	}

	#packages-section {
		background: #efefef
	}

	.package-inner-div.package-inner-div_es1 {
		background: #efefef;
		padding: 30px 20px 30px 20px;
		border-radius: 10px;
		border-top: 10px solid #f60;
		margin-bottom: 0px;
		height: 100%;
		transition: .2s
	}

	.package-inner-div.package-inner-div_es1:hover {
		background: #fff;
		box-shadow: 2px 1px 12px rgba(0, 0, 0, .5)
	}

	.package-inner-div.package-inner-div_es1:hover .enquire-btn {
		background-color: #f60;
		color: #fff;
		text-decoration: none
	}

	.support-div,
	.packages-brands-div-inner li {
		background-image: url(../images/packages-icon.png);
		background-repeat: no-repeat;
		list-style-type: none;
		background-position: left;
		padding-left: 24px;
		font-size: 16px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium;
		margin-bottom: 8px
	}

	.packages-brands-div-inner {
		padding: 0 30px
	}

	.enquire-btn {
		font-size: 16px;
		line-height: normal;
		color: #f60;
		border: 2px solid #f60;
		display: table;
		padding: 6px 22px;
		border-radius: 20px;
		margin: auto;
		margin-bottom: -50px;
		font-family: poppins-Medium;
		transition: .2s
	}

	.play-video-btn {
		margin-bottom: 50px
	}

	.package-vedio-icon {
		padding-left: 5px
	}

	.play-btn {
		font-size: 16px;
		line-height: normal;
		color: #f60;
		text-transform: uppercase;
		font-family: poppins-Medium
	}

	.play-btn:focus,
	.play-btn:hover {
		color: #f60;
		text-decoration: none
	}

	.enquire-btn:focus,
	.enquire-btn:hover {
		background-color: #f60;
		color: #fff;
		text-decoration: none;
		outline: 0
	}

	#news-section {
		background: #efefef
	}

	.news-section {
		background: #fff;
		padding: 60px 40px
	}

	.news-main-text {
		background: #fff;
		margin: auto;
		display: table;
		width: 85%;
		float: none;
		transition: .2s;
		padding: 20px 20px
	}

	.easy-news-inner {
		margin-top: -50px
	}

	.news-day-text {
		font-size: 30px;
		line-height: normal;
		color: #999;
		font-family: poppins-Semibold
	}

	.news-month-text {
		font-size: 24px;
		line-height: normal;
		color: #999;
		font-family: poppins-Medium
	}

	.news-neque-heading {
		font-size: 17px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium
	}

	.news-neque-text {
		font-size: 15px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium
	}

	.news-half-inner-div {
		padding: 0 25px;
		margin-bottom: 30px
	}

	.read-more-btn {
		font-size: 20px;
		line-height: normal;
		color: #f60;
		font-family: poppins-Medium;
		transition: .2s
	}

	.read-more-btn:focus,
	.read-more-btn:hover {
		color: #f60;
		text-decoration: none;
		outline: 0
	}

	.news-archive-heading {
		font-size: 25px;
		line-height: normal;
		color: #999;
		font-family: poppins-Semibold;
		text-align: center;
		margin-bottom: 25px
	}

	.news-archive-main-div {
		padding: 0 0 0 30px
	}

	.news-archive-date {
		font-size: 15px;
		line-height: normal;
		color: #666;
		font-family: poppins-Light
	}

	.testimonails-heading {
		font-size: 30px;
		line-height: normal;
		color: #999;
		font-family: poppins-Semibold;
		margin-bottom: 15px
	}

	.owner-text {
		font-size: 15px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium;
		margin-bottom: 0
	}

	.co-owner-text {
		font-size: 15px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium;
		margin-bottom: 50px
	}

	.testimonails-btn {
		font-size: 16px;
		line-height: normal;
		color: #f60;
		border: 2px solid #f60;
		padding: 6px 20px;
		display: table;
		float: none;
		margin: auto;
		border-radius: 20px
	}

	.testimanails-section {
		margin-top: 50px;
		background: #efefef;
		padding: 30px
	}

	.commas-div img {
		width: auto !important;
		margin: auto
	}

	.news-line-img {
		width: auto !important;
		margin: auto
	}

	.testimonails-div-btn {
		margin-bottom: -48px
	}

	.testimonails-btn:focus,
	.testimonails-btn:hover {
		color: #f60;
		text-decoration: none;
		outline: 0
	}

	.news-line-img {
		margin-bottom: 10px
	}

	.commas-div {
		margin-bottom: 20px
	}

	.news-testimanails-div {
		text-align: center
	}

	.testimonails-text {
		font-size: 16px;
		line-height: normal;
		color: #000;
		font-family: Poppins-MediumItalic
	}

	.news-archive-main {
		border-bottom: 1px solid #d3d3d3;
		transition: .2s;
		margin-bottom: 20px
	}

	.news-archive-content {
		font-size: 15px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium
	}

	.news-listing-div a:focus p,
	.news-listing-div a:hover p {
		color: #f60;
		text-decoration: none;
		outline: 0
	}

	.news-listing-div a:focus,
	.news-listing-div a:hover {
		color: #f60;
		text-decoration: none;
		outline: 0
	}

	.news-insta-heading {
		font-size: 25px;
		line-height: normal;
		color: #000;
		font-family: poppins-Medium;
		margin-bottom: 30px
	}

	.news-content-div {
		padding: 0 12px;
		margin-bottom: 35px
	}

	.news-icon-img {
		padding-right: 10px
	}

	.news-div {
		background: #fff;
		padding: 10px;
		box-shadow: 2px 1px 12px rgba(0, 0, 0, .5);
		border-radius: 0 0 16px 16px;
		list-style-type: none
	}

	.news-icon-rating {
		font-size: 15px;
		line-height: normal;
		color: #000;
		font-family: poppins-Light;
		text-align: center;
		width: 100%
	}

	.news-img-heading {
		font-size: 15px;
		color: #000;
		line-height: normal;
		font-family: poppins-Light;
		text-align: center;
		margin-bottom: 15px
	}

	.news-content-div img {
		width: 100%
	}

	.insta-follow-div {
		margin-top: 15px
	}

	.insta-follow-img {
		margin: auto;
		display: table
	}

	.news-icon-text {
		padding: 0 10px
	}

	#news-slider .owl-dots .owl-dot.active span,
	#news-slider .owl-dots .owl-dot:focus span,
	#news-slider .owl-dots .owl-dot:hover span {
		background: #999 !important;
		outline: 0 !important
	}

	.news-hover-div:hover {
		color: #f60
	}

	.simple-text.text-div {
		padding-right: 0
	}

	.sticky-header {
		position: fixed !important;
		width: 100%;
		top: 0;
		left: 0;
		background: #fff;
		-webkit-transition: .3s;
		transition: .3s;
		z-index: 9999999;
		box-shadow: 0 8px 6px -6px rgba(0, 0, 0, .1)
	}

	#accordion .panel-title a::after {
		font-family: FontAwesome;
		content: "\f054";
		color: #999;
		position: absolute;
		top: 0;
		right: 0
	}

	#accordion .panel-title.activeacord a::after {
		content: "\f078"
	}

	.news-instagram-section {
		padding: 0 25px
	}

	#news-slider {
		width: calc(100% + 24px);
		margin-left: -12px
	}

	.form-control:focus {
		border-color: initial !important;
		outline: 0;
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
		box-shadow: none
	}

	input[type=checkbox],
	input[type=radio] {
		padding: 0
	}

	button::-moz-focus-inner,
	input::-moz-focus-inner {
		border: 0;
		padding: 0
	}

	*,
	:after,
	:before {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box
	}

	*,
	:after,
	:before {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box
	}

	a {
		text-decoration: none;
		-webkit-transition: all .3s ease-in-out;
		-moz-transition: all .3s ease-in-out;
		-ms-transition: all .3s ease-in-out;
		-o-transition: all .3s ease-in-out;
		transition: all .3s ease-in-out
	}

	a:focus,
	a:hover {
		color: #f60;
		text-decoration: none;
		outline: 0;
		-webkit-transition: all .3s ease-in-out;
		-moz-transition: all .3s ease-in-out;
		-ms-transition: all .3s ease-in-out;
		-o-transition: all .3s ease-in-out;
		transition: all .3s ease-in-out
	}

	ol,
	ul {
		padding: 0
	}

	img {
		max-width: 100%;
		height: auto
	}

	.img-right {
		margin: 0 0 0 50px !important;
		float: right
	}

	b,
	strong {
		font-weight: 900
	}

	.entry-page p {
		margin-bottom: 25px
	}

	button {
		border: none
	}

	.comment-div button {
		display: inline-block;
		color: #fff;
		padding: 0 30px 0 30px;
		height: 45px;
		line-height: 45px;
		font-size: 12px;
		text-transform: uppercase;
		color: #fff;
		background: #f60;
		border: 1px solid #f60;
		-webkit-border-radius: 25px;
		-ms-border-radius: 25px;
		-o-border-radius: 25px;
		-moz-border-radius: 25px;
		border-radius: 25px;
		font-family: Poppins-Medium;
		position: relative;
		margin-top: 20px
	}

	#respond .simple-text {
		position: relative;
		display: block;
		width: 100%;
		line-height: 24px;
		padding: 8px 15px;
		color: #222;
		border: 1px solid #d0d0d0;
		height: 45px;
		border-radius: 3px;
		margin-bottom: 20px
	}

	#respond textarea {
		width: 100%;
		padding: 10px 15px;
		height: 170px
	}

	input[type=checkbox] {
		display: inline
	}

	input:-moz-placeholder,
	input::-moz-placeholder,
	textarea:-moz-placeholder,
	textarea::-moz-placeholder {
		color: #3d3d3d;
		opacity: 1
	}

	input:-ms-input-placeholder {
		color: #3d3d3d
	}

	input::-webkit-input-placeholder,
	textarea::-webkit-input-placeholder {
		color: #3d3d3d;
		opacity: 1
	}

	.blog-single .entry p {
		margin-bottom: 30px;
		font-size: 15px;
		line-height: normal;
		color: #000;
		font-family: poppins-Regular
	}

	.blog-single .block-news-text {
		padding: 30px 20px 38px 35px;
		border: 1px solid #e5e5e5;
		-webkit-border-radius: 2px;
		-moz-border-radius: 2px;
		-o-border-radius: 2px;
		border-radius: 2px;
		position: relative;
		font-size: 15px;
		letter-spacing: 1.5px
	}

	.blog-single .block-news-text::before {
		content: "''";
		position: absolute;
		top: 22px;
		left: 7px;
		color: #f60;
		font-size: 49px;
		font-weight: 100;
		font-style: italic;
		z-index: 1
	}

	.blog-single .img-left {
		float: left;
		margin-right: 20px;
		margin-bottom: 20px
	}

	.blog-single .content-post:after,
	.blog-single .content-post:before,
	.blog-single .entry:after,
	.blog-single .entry:before {
		content: "";
		display: table;
		clear: both
	}

	.flat-analysis,
	.flat-information,
	.flat-language {
		float: left
	}

	.flat-analysis,
	.flat-language {
		width: 13%
	}

	.flat-information {
		width: 74%;
		text-align: center
	}

	.flat-language {
		position: relative;
		padding-left: 23px
	}

	.flat-language:before {
		position: absolute;
		left: 0;
		top: 0;
		content: "\f0ac";
		font-family: FontAwesome;
		font-size: 16px
	}

	.flat-language .current a {
		position: relative;
		padding: 0 15px 0 5px
	}

	.flat-language .current>a:after {
		content: "\f107";
		font-family: FontAwesome;
		font-size: 12px;
		position: absolute;
		right: 0;
		top: -2px
	}

	.flat-language .current>a {
		font-weight: 700;
		color: #fff
	}

	.flat-language .current>a:hover {
		color: #00aeff
	}

	.flat-language .current:hover ul {
		opacity: 1;
		visibility: visible;
		margin-top: 11px
	}

	.flat-language>ul>li>ul {
		position: absolute;
		right: 0;
		top: 100%;
		width: 130px;
		margin-top: 15px;
		background-color: #00aeff;
		opacity: 0;
		visibility: hidden;
		z-index: 9999;
		-webkit-transition: all .2s ease-out;
		-moz-transition: all .2s ease-out;
		-ms-transition: all .2s ease-out;
		-o-transition: all .2s ease-out;
		transition: all .2s ease-out
	}

	.flat-language>ul>li>ul li {
		padding: 1px 0 2px 15px
	}

	.flat-language>ul>li>ul li a {
		color: #fff
	}

	.top {
		background-color: #273039;
		color: #fff;
		padding: 11px 0;
		font-size: 13px
	}

	.flat-analysis {
		margin: -11px 0 -11px
	}

	.flat-analysis i {
		font-size: 18px;
		margin-right: 9px;
		position: relative;
		top: 4px
	}

	.flat-analysis a {
		display: block;
		height: 100%;
		background: #35424f;
		color: #fff;
		padding: 11px 20px 11px 18px;
		font-size: 12px;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
		font-family: Poppins, sans-serif;
		font-weight: 700
	}

	.flat-analysis a:hover {
		background: #00aeff;
		color: #fff
	}

	.flat-information {
		margin: 0 0;
		padding: 0 0 0 55px
	}

	.flat-information>li {
		display: inline-block;
		position: relative;
		margin-right: 30px;
		padding-left: 20px
	}

	.flat-information>li:before {
		position: absolute;
		left: 0;
		top: 0;
		font-family: FontAwesome;
		content: "\f095";
		color: #fff
	}

	.flat-information>li.email:before {
		content: "\f0e0"
	}

	.flat-information>li.address:before {
		content: "\f041"
	}

	.flat-information>li>a {
		color: #fff
	}

	.flat-information>li>a:hover {
		color: #00aeff
	}

	.social-links {
		padding: 0;
		margin: 0;
		text-align: right
	}

	.social-links a {
		display: inline-block;
		padding: 0 13px;
		line-height: 50px;
		font-size: 14px;
		color: #c2c2c2
	}

	.social-links a:hover {
		color: #eab702
	}

	.header {
		background-color: rgba(255, 255, 255, .9);
		border-bottom: 1px solid #f1f1f1;
		box-shadow: 2px 0 5px rgba(0, 0, 0, .1);
		-webkit-transition: all .3s ease-in-out;
		-moz-transition: all .3s ease-in-out;
		-ms-transition: all .3s ease-in-out;
		-o-transition: all .3s ease-in-out;
		transition: all .3s ease-in-out
	}

	.header .logo {
		width: 185px;
		height: 36px;
		-webkit-transition: all .3s ease-in-out;
		-moz-transition: all .3s ease-in-out;
		-ms-transition: all .3s ease-in-out;
		-o-transition: all .3s ease-in-out;
		transition: all .3s ease-in-out;
		margin: 20px 200px 0 0
	}

	.header.downscrolled,
	.header.header-absolute.downscrolled {
		position: fixed;
		top: 0;
		width: 100%;
		z-index: 9999;
		opacity: 0;
		top: -121px;
		-webkit-transition: all .5s ease-in-out;
		-moz-transition: all .5s ease-in-out;
		-ms-transition: all .5s ease-in-out;
		-o-transition: all .5s ease-in-out;
		transition: all .5s ease-in-out
	}

	.header.header-absolute.upscrolled,
	.header.upscrolled {
		opacity: 1;
		top: 0;
		box-shadow: 0 0 5px rgba(0, 0, 0, .1)
	}

	.header.header-absolute.upscrolled {
		background-color: rgba(0, 0, 0, .5)
	}

	.header.header-absolute {
		position: absolute;
		width: 100%;
		z-index: 999;
		background-color: transparent;
		border-bottom: 0
	}

	.header.header-absolute #mainnav>ul>li>a,
	.header.header-absolute .menu.menu-extra li a,
	.header.header-absolute .nav-contact .contact-text {
		color: #fff
	}

	.menu.menu-extra {
		float: right;
		position: relative
	}

	.menu.menu-extra li {
		float: left
	}

	.menu.menu-extra li a {
		color: #1c1c1c;
		padding: 0 20px;
		line-height: 90px;
		height: 90px
	}

	.menu.menu-extra li.cart {
		position: relative
	}

	.menu.menu-extra li a:hover {
		color: #00aeff
	}

	.nav-wrap {
		position: relative
	}

	#mainnav>ul {
		text-align: right
	}

	#mainnav ul {
		list-style: none;
		margin: 0;
		padding: 0
	}

	#mainnav ul li {
		position: relative
	}

	#mainnav>ul>li {
		display: inline-block
	}

	#mainnav>ul>li>a {
		font-weight: 600;
		color: #424242;
		font-family: Poppins, sans-serif;
		text-transform: uppercase;
		line-height: 90px;
		margin: 0 25px 0 25px;
		display: inline-block
	}

	#mainnav ul.submenu {
		text-align: left;
		position: absolute;
		left: 0;
		top: 150%;
		width: 200px;
		background-color: #222;
		z-index: 9999;
		opacity: 0;
		visibility: hidden;
		-webkit-transition: all .3s ease-in-out;
		-moz-transition: all .3s ease-in-out;
		-ms-transition: all .3s ease-in-out;
		-o-transition: all .3s ease-in-out;
		transition: all .3s ease-in-out
	}

	#mainnav ul.submenu:before {
		content: "";
		position: absolute;
		top: 0;
		left: 0;
		height: 3px;
		width: 100%;
		background: #00aeff
	}

	#mainnav ul.right-sub-menu {
		left: auto;
		right: 0
	}

	#mainnav ul li:hover>ul.submenu {
		top: 100%;
		opacity: 1;
		visibility: visible
	}

	#mainnav ul li ul li {
		margin-left: 0
	}

	#mainnav ul.submenu li ul {
		position: absolute;
		left: 300px;
		top: 0 !important
	}

	#mainnav ul.submenu>li {
		border-top: 1px solid #333
	}

	#mainnav ul.submenu>li.sub-parent:after {
		content: "\f105";
		font-family: FontAwesome;
		font-size: 14px;
		position: absolute;
		right: 25px;
		top: 11px;
		color: #999;
		-webkit-transition: all .3s ease-in-out;
		-moz-transition: all .3s ease-in-out;
		-ms-transition: all .3s ease-in-out;
		-o-transition: all .3s ease-in-out;
		transition: all .3s ease-in-out
	}

	#mainnav ul.submenu li:first-child {
		border-top: none
	}

	#mainnav ul.submenu>li>a {
		display: block;
		letter-spacing: 1px;
		font-size: 13px;
		color: #fff;
		text-transform: uppercase;
		text-decoration: none;
		padding: 0 0 0 26px;
		line-height: 40px;
		-webkit-transition: all .3s ease-in-out;
		-moz-transition: all .3s ease-in-out;
		-ms-transition: all .3s ease-in-out;
		-o-transition: all .3s ease-in-out;
		transition: all .3s ease-in-out
	}

	#mainnav ul.submenu>li>a:hover {
		background-color: #00aeff;
		color: #fff
	}

	#mainnav ul.submenu>li.sub-parent:hover::after {
		right: 18px
	}

	#mainnav>ul>li.home>a,
	#mainnav>ul>li>a:hover {
		color: #00aeff;
		position: relative
	}

	#mainnav>ul>li.home>a:after {
		content: '';
		position: absolute;
		left: 0;
		bottom: 25px;
		width: 100%;
		height: 4px;
		background: #00aeff;
		opacity: 1
	}

	#mainnav>ul>li>a:after {
		content: '';
		position: absolute;
		left: 0;
		bottom: 25px;
		width: 0;
		height: 4px;
		background: #00aeff;
		opacity: 0;
		-webkit-transition: all .3s ease-in-out;
		-moz-transition: all .3s ease-in-out;
		-ms-transition: all .3s ease-in-out;
		-o-transition: all .3s ease-in-out;
		transition: all .3s ease-in-out
	}

	#mainnav>ul>li>a:hover:after {
		width: 100%;
		opacity: 1
	}

	#mainnav>ul>li>a {
		position: relative
	}

	#mainnav-mobi {
		display: block;
		margin: 0 auto;
		width: 100%;
		position: absolute;
		background-color: #222;
		z-index: 1000
	}

	#mainnav-mobi ul {
		display: block;
		list-style: none;
		margin: 0;
		padding: 0
	}

	#mainnav-mobi ul li {
		margin: 0;
		position: relative;
		text-align: left;
		border-top: 1px solid #333;
		cursor: pointer
	}

	#mainnav-mobi ul>li>a {
		text-decoration: none;
		height: 50px;
		line-height: 50px;
		padding: 0 50px;
		color: #fff
	}

	#mainnav-mobi ul.sub-menu {
		top: 100%;
		left: 0;
		z-index: 2000;
		position: relative;
		background-color: #333
	}

	#mainnav-mobi>ul>li>ul>li,
	#mainnav-mobi>ul>li>ul>li>ul>li {
		position: relative;
		border-top: 1px solid #333
	}

	#mainnav-mobi>ul>li>ul>li>ul>li a {
		padding-left: 70px !important
	}

	#mainnav-mobi ul.sub-menu>li>a {
		display: block;
		text-decoration: none;
		padding: 0 60px;
		border-top-color: rgba(255, 255, 255, .1);
		-webkit-transition: all .2s ease-out;
		-moz-transition: all .2s ease-out;
		-o-transition: all .2s ease-out;
		transition: all .2s ease-out
	}

	#mainnav-mobi>ul>li>ul>li:first-child a {
		border-top: none
	}

	#mainnav-mobi ul.sub-menu>li>a:hover,
	#mainnav-mobi>ul>li>ul>li.active>a {
		color: #fff
	}

	.btn-menu {
		display: none;
		position: relative;
		background: 0 0;
		cursor: pointer;
		margin: 40px 0;
		width: 26px;
		height: 16px;
		float: right;
		margin-right: 15px;
		-webkit-transition: all ease .238s;
		-moz-transition: all ease .238s;
		transition: all ease .238s
	}

	.btn-menu span,
	.btn-menu:after,
	.btn-menu:before {
		background-color: #00aeff;
		-webkit-transition: all ease .238s;
		-moz-transition: all ease .238s;
		transition: all ease .238s
	}

	.btn-menu:after,
	.btn-menu:before {
		content: '';
		position: absolute;
		top: 0;
		height: 2px;
		width: 24px;
		left: 0;
		top: 50%;
		-webkit-transform-origin: 50% 50%;
		-ms-transform-origin: 50% 50%;
		transform-origin: 50% 50%
	}

	.btn-menu span {
		position: absolute;
		width: 12px;
		height: 2px;
		left: 0;
		top: 50%;
		overflow: hidden;
		text-indent: 200%
	}

	.btn-menu:before {
		-webkit-transform: translate3d(0, -7px, 0);
		transform: translate3d(0, -7px, 0)
	}

	.btn-menu:after {
		width: 17px;
		-webkit-transform: translate3d(0, 7px, 0);
		transform: translate3d(0, 7px, 0)
	}

	.btn-menu.active:after {
		width: 24px
	}

	.btn-menu.active span {
		opacity: 0
	}

	.btn-menu.active:before {
		-webkit-transform: rotate3d(0, 0, 1, 45deg);
		transform: rotate3d(0, 0, 1, 45deg)
	}

	.btn-menu.active:after {
		-webkit-transform: rotate3d(0, 0, 1, -45deg);
		transform: rotate3d(0, 0, 1, -45deg)
	}

	.btn-submenu {
		position: absolute;
		right: 20px;
		top: 0;
		font: 20px/50px FontAwesome;
		text-align: center;
		cursor: pointer;
		width: 70px;
		height: 44px
	}

	.btn-submenu:before {
		content: "\f107";
		color: #fff
	}

	.btn-submenu.active:before {
		content: "\f106"
	}

	.btn-menu {
		display: none
	}

	.nav-contact {
		float: right;
		padding: 27px 0 28px
	}

	.nav-contact .contact-icon {
		float: left;
		margin-right: 10px;
		color: #00aeff;
		font-size: 35px;
		position: relative;
		top: -5px
	}

	.nav-contact .contact-text {
		overflow: hidden;
		font-size: 20px;
		color: #222;
		font-weight: 600
	}

	.page-title {
		position: relative;
		padding: 88px 0;
		text-align: center
	}

	.page-title.style-1 {
		text-align: left
	}

	.page-title-heading h1 {
		color: #fff;
		text-transform: uppercase;
		font-weight: 700;
		letter-spacing: 1px;
		font-size: 36px;
		font-family: Poppins, sans-serif
	}

	.page-title .overlay {
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, .6)
	}

	.breadcrumbs ul {
		padding-top: 10px
	}

	.breadcrumbs ul li {
		display: inline-block;
		position: relative;
		margin-right: 25px
	}

	.breadcrumbs ul li a {
		font-size: 13px;
		color: #fff
	}

	.breadcrumbs ul li a:hover {
		color: #00aeff
	}

	.breadcrumbs ul li:before {
		position: absolute;
		right: -14px;
		top: 0;
		color: #fff;
		font-family: FontAwesome;
		content: "\f105"
	}

	.breadcrumbs ul li:last-child::before {
		width: 0;
		height: 0;
		background-color: transparent;
		content: ""
	}

	.entry p {
		margin-bottom: 20px
	}

	.main-content {
		padding: 40px 30px;
		background: #ffff
	}

	.post {
		margin-bottom: 40px
	}

	.post .featured-post {
		position: relative
	}

	.post .post-comment {
		position: absolute;
		left: 20px;
		top: 20px;
		width: 60px;
		z-index: 20;
		background-color: #f60;
		text-align: center;
		color: #fff
	}

	.post .post-comment li.date span {
		display: block;
		font-size: 14px
	}

	.post .post-comment li.date .day {
		font-size: 30px;
		font-weight: 700;
		text-transform: uppercase;
		padding: 10px 12px
	}

	.post .post-comment li.comment {
		background-color: #273039;
		font-size: 14px;
		font-weight: 600;
		padding: 3px 0
	}

	.post .post-comment li {
		display: block
	}

	.content-post .title-post {
		font-size: 18px;
		font-family: poppins-Medium;
		letter-spacing: .5px;
		margin-top: 30px;
		margin-bottom: 10px;
		color: #000
	}

	.post .content-post .title-post a {
		color: #000
	}

	.post .content-post .title-post a:hover {
		color: #f60
	}

	.post .more-link a {
		position: relative;
		display: inline-block;
		line-height: 22px;
		padding: 8px 40px 8px 20px;
		font-size: 12px;
		text-transform: uppercase;
		color: #fff;
		background: #00aeff;
		border: 1px solid #00aeff;
		-webkit-border-radius: 20px;
		-ms-border-radius: 20px;
		-o-border-radius: 20px;
		-moz-border-radius: 20px;
		border-radius: 20px;
		margin-top: 20px;
		font-weight: 700;
		font-family: Poppins, sans-serif
	}

	.post .more-link a:after {
		font-family: FontAwesome;
		content: "\f061";
		color: #fff;
		position: absolute;
		right: 18px;
		top: 7px;
		font-size: 12px
	}

	.post .more-link a:hover {
		color: #fff;
		background: #273039;
		border-color: #273039
	}

	.blog-single .entry .section-text {
		color: #000;
		font-family: poppins-Semibold;
		font-size: 16px;
		line-height: 23px;
		letter-spacing: 0;
		margin-bottom: 14px;
		margin-top: 25px
	}

	.blog-single .entry .flat-onehalf h4 {
		margin-top: 0
	}

	.blog-single .category-post-single {
		padding: 0;
		margin: 0;
		list-style: none
	}

	.blog-single ul.social-share {
		padding: 0;
		margin: 29px 0 0 0;
		list-style: none;
		padding-bottom: 43px;
		border-bottom: 1px solid #e5e5e5
	}

	.blog-single ul.social-share li {
		display: inline-block;
		font-family: Poppins, sans-serif;
		color: #333;
		font-size: 16px
	}

	.blog-single ul.social-share li a {
		margin: 0 17px;
		color: #999;
		font-size: 18px
	}

	.blog-single ul.social-share li a:hover {
		color: #edb820
	}

	.blog-single .direction {
		text-align: center
	}

	.blog-single .direction {
		text-align: center;
		padding-top: 45px;
		border-top: 1px solid #eee
	}

	.blog-single .direction ul li:first-child {
		float: left
	}

	.blog-single .direction ul li ul.social-icons li {
		display: inline-block;
		margin-right: 4px
	}

	.blog-single .direction ul li ul.social-icons li a {
		width: 36px;
		height: 36px;
		background-color: #f2f2f2;
		display: inline-block;
		text-align: center;
		line-height: 36px;
		color: #6a6a6a;
		border-radius: 50%
	}

	.blog-single .direction ul li ul.social-icons li a:hover {
		background-color: #f60;
		color: #fff
	}

	.accent-button a:hover {
		opacity: .9;
		transition: all .5s
	}

	.accent-button a {
		padding: 10px 31px;
		background: #f60;
		border-radius: 25px;
		color: #fff;
		text-transform: capitalize;
		transition: all linear .3s;
		border: 2px solid #f60;
		text-decoration: none;
		font-family: poppins-Medium;
		display: inline-block
	}

	.accent-button a:hover {
		background-color: #fff;
		color: #f60;
		border-color: #f60
	}

	.black-button a {
		padding: 10px 31px;
		background: #fff;
		border-radius: 25px;
		color: #000;
		text-transform: capitalize;
		transition: .2s;
		border: 2px solid #222;
		text-decoration: none;
		font-family: poppins-Medium;
		display: inline-block
	}

	.black-button a:hover {
		background-color: #f60;
		color: #fff;
		border-color: #f60
	}

	.blog-single .direction ul li ul.social-icons {
		padding: 0;
		text-align: center;
		list-style: none
	}

	.blog-single .direction ul li:last-child {
		float: right
	}

	.blog-single .direction ul li {
		display: inline-block
	}

	.comment-list .comment-body {
		margin-bottom: 5px
	}

	.comment-list ul.children {
		margin-left: 30px
	}

	.comments-area .comments-title {
		border-top: 1px solid #f0f0f0;
		margin-top: 30px;
		padding-top: 40px;
		margin-bottom: 10px;
		text-transform: uppercase;
		font-family: poppins-Medium;
		letter-spacing: .3px;
		font-size: 30px;
		line-height: normal
	}

	.comments-area ul.comment-list {
		padding: 0;
		margin: 0;
		list-style: none
	}

	.comments-area ul.comment-list .comment-body {
		border-bottom: 1px solid #e5e5e5;
		padding: 30px 0
	}

	.comments-area ul.comment-list .comment-body .comment-author {
		float: left;
		margin-right: 20px;
		width: 80px;
		height: 80px;
		border-radius: 50%;
		overflow: hidden;
		border: 2px solid #f0f0f0
	}

	ul.children li {
		list-style-type: none
	}

	.comments-area ul.comment-list .comment-body .comment_content .comment_meta {
		margin-bottom: 20px
	}

	.comments-area ul.comment-list .comment-body .comment-text {
		padding-bottom: 50px
	}

	.comments-area ul.comment-list .comment-body .comment-text .comment-name {
		font-size: 14px;
		line-height: 23px;
		color: #000;
		font-family: poppins-Medium;
		text-transform: uppercase;
		padding-top: 5px;
		transition: .2s
	}

	.comments-area ul.comment-list .comment-body .comment-text .comment-name a {
		color: #666;
		transition: .2s
	}

	.comments-area ul.comment-list .comment-body .comment-text .comment-name a:focus,
	.comments-area ul.comment-list .comment-body .comment-text .comment-name a:hover {
		color: #f60;
		text-decoration: none;
		outline: 0
	}

	.comments-area ul.comment-list .comment-body .comment_text {
		padding-bottom: 37px;
		overflow: hidden
	}

	.comments-area ul.comment-list .comment-body {
		position: relative
	}

	.comments-area ul.comment-list .comment-body .comment-metadata .date {
		font-size: 13px;
		line-height: 23px;
		color: #999;
		font-family: poppins-Regular
	}

	.comments-area ul.comment-list .comment-body .unapproved {
		float: right
	}

	.comments-area ul.comment-list .comment-body .gravatar img {
		border-radius: 50%
	}

	.comment-respond .comment-reply-title {
		margin-top: 60px;
		margin-bottom: 50px;
		text-transform: uppercase;
		font-family: poppins-Medium;
		letter-spacing: .3px;
		font-size: 30px;
		line-height: normal
	}

	.comment-respond .comment-form-email,
	.comment-respond .comment-notes {
		width: 50%;
		float: left
	}

	.comment-respond .comment-notes {
		padding-right: 10px
	}

	.comment-respond .comment-form-email {
		padding-left: 10px
	}

	.comment-respond .message,
	.comment-respond input[type=email],
	.comment-respond input[type=text] {
		width: 100%
	}

	.comment-respond .email-container,
	.comment-respond .message,
	.comment-respond .name-container {
		position: relative
	}

	.comment-respond .email-container:before,
	.comment-respond .message:before,
	.comment-respond .name-container:before {
		content: "\f007";
		font-family: FontAwesome;
		font-size: 14px;
		line-height: 23px;
		position: absolute;
		top: 14px;
		left: 15px;
		color: #bcbcbc
	}

	.comment-respond .email-container:before {
		content: "\f0e0";
		left: 30px
	}

	.comment-respond .message:before {
		content: "\f075"
	}

	.comment-respond textarea {
		height: 200px;
		border: 1px solid #d0d0d0
	}

	.comment-respond .comment-submit:hover {
		background-color: #fff;
		color: #f60;
		border-color: #f60
	}

	#contactform input,
	#contactform textarea {
		color: #000
	}

	.main-content.page-single {
		padding: 50px 0
	}

	.page-single .page-content {
		width: 65.81196581196581%;
		float: left
	}

	.page-single .page-sidebar {
		width: 34.18803418803419%;
		float: left
	}

	.sidebar {
		padding-left: 50px;
		border-left: 1px solid #e5e5e5;
		margin-left: 50px
	}

	.sidebar-left .sidebar {
		padding-left: 0;
		margin-left: 0;
		padding-right: 50px
	}

	.sidebar .widget {
		margin-bottom: 45px;
		position: relative
	}

	.widget ul {
		padding: 0;
		margin: 0
	}

	.widget ul li {
		list-style: none;
		padding: 7px 0 8px
	}

	.widget ul li a {
		font-size: 14px;
		color: #3d3d3d;
		font-family: poppins-Regular
	}

	.widget ul li a:hover {
		color: #f60
	}

	.widget .widget-title {
		margin-top: 0;
		font-size: 16px;
		font-family: Poppins-Regular;
		color: #000;
		position: relative;
		margin-bottom: 30px;
		padding-bottom: 15px;
		text-transform: uppercase
	}

	.sidebar .widget .widget-title:before {
		content: '';
		position: absolute;
		left: 0;
		bottom: 0;
		width: 100%;
		height: 2px;
		background: #f0f0f0
	}

	.sidebar .widget .widget-title:after {
		content: '';
		position: absolute;
		left: 0;
		bottom: 0;
		width: 40px;
		height: 2px;
		background: #f60
	}

	.widget.widget_categories ul li {
		position: relative
	}

	.widget.widget_categories ul li span {
		color: #f60
	}

	.sidebar .widget-recent-news {
		margin-bottom: 58px
	}

	.services-1 .sidebar .widget-recent-news {
		margin-bottom: 0
	}

	.widget.widget-recent-news ul li {
		padding: 20px 0 8px;
		overflow: hidden
	}

	.widget.widget-recent-news ul li:last-child {
		padding-bottom: 0
	}

	.widget.widget-recent-news ul li .thumb {
		float: left;
		margin-right: 13px;
		max-width: 80px
	}

	.widget.widget-recent-news ul li .text {
		overflow: hidden;
		position: relative
	}

	.widget.widget-recent-news ul li .post_meta {
		font-size: 12px;
		position: relative;
		padding-left: 20px;
		color: #f60
	}

	.widget.widget-recent-news ul li .post_meta::before {
		font-family: fontawesome;
		content: "\f073";
		position: absolute;
		left: 2px;
		top: 0;
		color: #f60;
		font-family: 400
	}

	.widget.widget-recent-news ul li .text p {
		padding-left: 20px;
		margin-bottom: 7px;
		font-weight: 600;
		font-size: 14px
	}

	.widget.widget-recent-news ul li .text h6 {
		line-height: 23px;
		margin-top: -5px
	}

	.widget.widget_tag_cloud .widget-title {
		margin-bottom: 32px
	}

	.widget.widget_tag .tag-list a {
		display: inline-block;
		color: #6a6a6a;
		font-size: 12px;
		font-weight: 600;
		display: inline-block;
		text-align: center;
		line-height: 38px;
		background-color: #f2f2f2;
		padding: 0 15px;
		margin: 0 5px 5px 0
	}

	.widget.widget_tag .tag-list a.active,
	.widget.widget_tag .tag-list a:hover {
		color: #fff;
		background-color: #f60
	}

	.video-player-col {
		position: relative;
	}

	.video-player-col::after {
		content: "\f04b";
		font-family: FontAwesome;
		left: 50%;
		position: absolute;
		top: 50%;
		transform: translate(-50%, -50%);
		font-size: 90px;
	}

	.video-player-col+iframe {
		display: none;
	}

	#pageBuilderOptionList {
		padding: 0;
		display: flex;
		flex-wrap: wrap;
		margin-top: 15px;
	}

	#pageBuilderOptionList li {
		min-width: 25%;
		list-style: none;
		padding: 10px;
		transition: 0.2s;
		border: 1px solid white;
		cursor: pointer;
		font-size: 16px;
	}

	#pageBuilderElementsModel .modal-dialog {
		width: 70%;
		margin: 30px auto;
	}

	#insertRowAndColumn .modal-header,
	#pageBuilderWidgetsModel .modal-header,
	#pageBuilderElementsModel .modal-header {
		background-color: #094e91;
		color: white;
	}

	#insertRowAndColumn .modal-header .close,
	#pageBuilderWidgetsModel .modal-header .close,
	#pageBuilderElementsModel .modal-header .close {
		margin-top: 2px;
		color: white;
		opacity: 1;
	}

	.input-search-div {
		text-align: right;
		display: table;
		width: 100%;
	}

	.input-search-div #listsearch {
		max-width: 260px;
		float: right;
	}

	.form_settings_title {
		text-align: center;
		font-size: 20px;
		text-transform: capitalize;
		border-bottom: 1px solid lightgray;
		padding-bottom: 10px;
		margin-bottom: 10px;
		padding-top: 10px;
	}

	.radio-icon {
		background-image: url(images/layouticon.png);
		height: 30px;
		width: 37px;
		display: block;
	}

	.radio-icon.a1 {
		background-position: -3px 0;
	}

	.radio-icon.a2 {
		background-position: -50px 0;
	}

	.radio-icon.a3 {

		background-position: -140px 0;
	}

	.radio-icon.a4 {
		background-position: -187px 0;
	}

	.radio-icon.a5 {
		background-position: -500px 0;
	}

	.radio-icon.a6 {
		background-position: -779px 0;
	}

	.radio-icon.a7 {
		background-position: -323px 0;
	}

	.radio-icon.a8 {
		background-position: -413px 0;
	}

	.radio-ul input {
		margin-left: 10px !important;
	}

	.dottedline.col-xs-12 {
		border: 2px dashed #ddd;
		min-height: 136px;
		border-right: none;
		cursor: pointer;
	}

	.plus-section.col-xs-12 .dottedline.col-xs-12:last-child {
		border-right: 2px dashed #ddd;

	}

	.dottedline::after {
		content: "\f067 ";
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		font-family: FontAwesome;
		color: #cfcfcf;
		font-size: 30px;
		-webkit-text-stroke: 3px white;
	}

	.plus-section.col-xs-12 {
		display: flex;
		flex-wrap: wrap;
		padding: 0;
	}

	.col-xs-12.main-div {
		padding: 0;
	}

	.plus-main-div {
		padding: 0;
	}

	.modal-header .close {
		position: absolute;
		top: -15px;
		right: -15px;
		height: 28px;
		width: 28px;
		background: #263388;
		border-radius: 50%;
		line-height: 0;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 23px;
	}

	#pageBuilderOptionList li:hover {
		background-color: #f5f5f5;
	}

	.modal-header {
		background-color: #cfcfcf !important;
		color: #333 !important;
	}

	.modal-title {
		font-weight: bold;
	}

	#row_tree {
		display: block;
		list-style-type: none;
		padding: 0;
		margin: 0;
	}

	#row_tree .container-fluid {
		padding: 0;
	}

	#row_tree>li {
		position: relative;
	}

	.dottedline:hover {
		background-color: #fdfdfd;
	}

	.skip {
		font-size: 14px;
		display: block;
		float: none;
		background: #fff;
		width: 100%;
		height: 45px;
		padding: 6px 12px;
		color: #000;
		border: #dfe8f1 solid 1px;
		-webkit-box-shadow: inset 1px 1px 3px #f6f6f6;
		-moz-box-shadow: inset 1px 1px 3px #f6f6f6;
		box-shadow: inset 1px 1px 3px #f6f6f6;
	}

	#pageBuilderWidgetsModel .nav.nav-tabs>li {
		width: 160px;
		text-align: center;
	}

	.tab-content {
		padding: 15px 0 0 0;
	}

	.form-group label {
		font-weight: normal;
	}

	.modal-content {
		display: table;
		width: 100%;
	}

	.blockUI.blockMsg.blockElement {
		background: transparent !important;
		border: none !important;
		color: white !important;
		font-size: 30px;
	}

	input[type="file"] {
		opacity: 0;
	}

	.file-uploader {
		position: relative;
	}

	.file-uploader input {
		position: absolute;
		height: 100%;
		width: 100%;
		cursor: pointer;
		top: 0;
	}

	.file-uploader>span {
		background-color: #efefef;
		padding: 20px;
		display: block;
		line-height: normal;
		font-size: 18px;
		width: 100%;
		text-align: center;
		color: #6f6f6f;
		border: dashed 2px #bfbfbf;
		border-radius: 5px;
	}

	#avatar {
		max-width: 200px;
	}

	.column-action-list {
		position: absolute;
		top: 0;
		right: 0;
		margin: 0;
		padding: 0 10px !important;
		background: rgba(0, 0, 0, 0.7);
		font-size: 15px;
		z-index: 1999999;
		border-radius: 5px;
		color: white;
	}

	.column-action-list span,
	.row-action-list span {
		cursor: pointer;
		display: block;
		padding: 0 7px;
	}

	.column-action-list li,
	.row-action-list li {
		padding: 0 !important;
	}

	.row-action-list {
		position: absolute;
		left: 0;
		top: 0;
		background: rgba(31, 51, 136, 0.9);
		color: white;
		padding: 0 10px !important;
		margin: 0 !important;
		z-index: 199999999;
		border-radius: 5px;
	}

	.rowColActionList {
		display: none;
	}

	#row_tree li:hover .rowColActionList {
		display: block;
	}

	.rowColActionList .link-item {
		border-left: dashed 1px #8f8f8f;
		margin-right: -3px;
	}

	.rowColActionList {
		padding-right: 5px !important;
	}

	.rowColActionList .text-li {
		margin-right: 5px;
	}

	.rowColActionList .link-item:hover span {
		opacity: 0.6;
	}

	.spacer-column {
		text-align: center;
		border: dashed 2px #cfcfcf;
		border-radius: 6px;
		color: #7f7f7f;
		height: 100%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 16px;
	}

	.img-container {
		height: 500px;
	}

	.play-video-btn iframe {
		display: none;
	}

	.cropperDimesionData {
		margin: 0 0 15px 0;
		font-size: 16px;
	}

	.packages-brands-div-inner {
		height: 100%;
	}

	#rowUpdate {
		/* z-index: 1; */
	}

	#myModalNK {
		z-index: 1111;
	}

	#row_bg_avatar {
		width: 120px;
	}

	.form-group {
		position: relative;
	}

	.mce-container.mce-panel.mce-floatpanel.mce-popover.mce-bottom.mce-start,
	.mce-floatpanel.mce-menu {
		position: fixed !important
	}

	.projects-slider-item {
		padding: 0;
		display: flex;
		flex-wrap: wrap;
	}

	.projects-slider-item-left {
		padding: 0;
	}

	.projects-slider-item-right {
		background-color: #99989a;
		padding: 40px 40px;
		color: white;
	}

	.projects-slider-heading {
		font-size: 30px;
	}

	.slider-content-main-div-content-left {
		font-size: 17px;
	}

	.projects-slider-heading-disc {
		margin: 30px 0;
	}

	.con-title-1 {
		margin-bottom: 30px;
	}

	/* header 1 css  */


	/* Pagebuilder css */

	.full-width-row .site-container {
		margin: 0;
		width: 100%;
	}

	.container-fluid {
		padding: 0;
	}

	.full_column {
		width: 100%;
	}

	.half_column {
		width: calc(100% / 2);
	}

	.three_column {
		width: calc(100% / 3);
	}

	.four_column {
		width: calc(100% /4);
	}

	.five_column {
		width: calc(100% /5);
	}

	.left_column:nth-child(1) {
		width: 30%;
	}

	.left_column:nth-child(2) {
		width: 70%;
	}

	.right_column:nth-child(2) {
		width: 30%;
	}

	.right_column:nth-child(1) {
		width: 70%;
	}

	.center_column:nth-child(1) {
		width: 20%;
	}

	.center_column:nth-child(2) {
		width: 60%;
	}

	.center_column:nth-child(3) {
		width: 20%;
	}

	.header-section {
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
	}

	.footer-1-main-div .footer-text {
		margin-top: 40px;
	}

	.header-inner-div.col-xs-12,
	.header-main.col-xs-12 {
		width: auto;
	}

	.header-top {
		display: flex;
		flex-wrap: wrap;
		align-items: center;
	}

	.header-left-div {
		padding: 0;
	}

	.header-navbar.list-inline.line-div {
		margin-bottom: 0;
		padding-top: 0px;
	}

	.header-navbar.list-inline.line-div li a {
		padding: 32px 6px 32px 6px;
		color: #fff;
	}

	.home-link {
		font-size: 18px;
		color: #fff;
		line-height: normal;
		transition: 0.3s;
		border-bottom: 2px solid var(--blue);
	}


	/* header 2 css  */

	.header-section-2 {
		padding: 0;
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
		align-items: center;
	}

	.header-section-2>div {
		width: auto;
		padding: 0;
	}

	.header-top-2 {
		display: flex;
		flex-wrap: wrap;
		padding: 0;
		align-items: center;
	}

	.header-right-div-2,
	.header-left-div-2 {
		width: auto;
		padding: 0;
	}

	.header-nav {
		padding-left: 30px;
	}

	.header-nav .tel-link.like-link {
		color: black;
		font-size: 19px;
	}

	.header-nav li {
		list-style: none;
	}

	.header-2 {
		background: white;
	}

	.header-left-div-2 .header-navbar a {
		display: inline-block;
		color: black;
		padding: 20px 10px;
		transition: 0.2s;
		border-bottom: 6px solid transparent;
	}

	.header-nav-number {
		margin: 0;
		padding-left: 30px;
	}

	.header-nav-number li {
		list-style: none;
	}

	.header-nav-number .tel-link.like-link {
		display: table;
		color: black;
		font-size: 18px;
	}

	.header-navbar.list-inline {
		margin: 0;
	}

	.header-left-div-2 .header-navbar li {
		padding: 0;
	}

	.header-left-div-2 .header-navbar a:hover {
		background: #f5f3f4;
		border-color: var(--blue);
	}


	/* footer 1  */

	.footer-inner-first {
		background: #333333;
		padding: 60px 0;
		display: table;
		width: 100%;
	}

	.footer-text-title {
		font-size: 30px;
		color: var(--blue);
		margin-bottom: 20px;
	}

	.fa1 {
		padding: 0;
	}

	.about-us-footer-menu a {
		color: white;
	}

	.footer-inner-two {
		background: #4d4d4d;
	}

	.footer-text-align {
		margin: 0;
		text-align: center;
		width: 100%;
		padding: 15px 0;
		font-size: 17px;
		color: #9e9e9e;
	}

	.footer-info a {
		color: white;
		display: inline-block;
		font-size: 16px;
	}

	.footer-info li {
		width: 100%;
		padding: 0;
		color: white;
		padding-left: 30px !important;
		background-repeat: no-repeat;
		background-position: left top;
	}

	.footer-info.list-inline {
		margin: 0;
	}

	.fc1-inner {
		padding: 0;
	}

	.footer-info-a {
		margin-bottom: 10px;
		font-size: 13px;
	}

	.footer-info-a {
		background-image: url(../images/location.png);
	}

	.footer-info-b {
		background-image: url(../images/call.png);
	}

	.footer-info-c {
		background-image: url(../images/msg.png);
	}

	.footer-social-ul a {
		font-size: 25px;
	}

	.footer-content {
		font-size: 15px;
		color: white;
		line-height: 27px;
		padding-top: 38px;
	}


	/* footer 2  */

	.services-links3 .footer-social-ul a i {
		color: #666;
	}

	.customer-data .col-sm-3 {
		width: calc(100% / 4);
	}

	.customer-data {
		display: flex;
		flex-wrap: wrap;
		padding: 40px 0px;
		width: 85%;
		margin: auto;
	}

	.footer-text {
		font-size: 14px;
		line-height: normal;
		color: #666;
		padding-right: 30px;
		margin-top: 16px;
	}

	.last-text-left {
		font-size: 16px;
		line-height: normal;
		color: #666;
		text-align: center;
		padding: 20px 0;
	}

	.last-text .last-text-inner {
		display: table;
		width: 85%;
		margin: auto;
		padding: 0 15px;
	}

	.last-text {
		border-top: 1px solid lightgray;
		padding: 0;
	}

	.footer-section {
		display: table;
		width: 100%;
		padding-top: 60px;
	}

	.site-container {
		display: flex;
		flex-wrap: wrap;
		margin: auto;
	}


	/* footer 3  */

	.footer-3-inner-div>div {
		width: auto;
	}

	.footer-3-address {
		margin-top: 40px;
	}

	.footer-3-inner-div .footer-text-title {
		font-size: 20px;
		color: var(--blue);
	}

	.footer-3-social-ul .social-link {
		padding: 0;
		margin-top: 20px;
	}

	.footer-3-inner-div .service1 {
		font-size: 17px;
		color: #000000;
		line-height: normal;
		transition: 0.2s;
	}

	.last-text-left.footer-3-inner-div-last {
		text-align: left;
		color: #9f9e9e;
	}

	.footer-3-address {
		margin-top: 27px;
		font-size: 17px;
		color: #000000;
	}

	.footer-3-inner-div-last-main {
		border: none;
		background: #efefef;
		margin-top: 40px;
	}

	.footer-section.footer-3-main-div {
		border-top: 1px solid #c8c7c8;
	}


	/* slider css  */

	.slider-navigation {
		position: relative;
	}

	.slider-navigation .owl-prev {
		position: absolute;
		top: 50%;
		left: 10px;
		transform: translateY(-50%);
	}

	.slider-navigation .owl-next {
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		right: 10px;
	}

	.slider-navigation .owl-next span,
	.slider-navigation .owl-prev span {
		font-size: 50px;
		line-height: normal;
	}


	/* video iframe */

	.iframe-thumb {
		position: relative;
	}

	.iframe-thumb::after {
		content: '\f04b';
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		font-size: 40px;
		font-family: FontAwesome;
		border: 3px solid black;
		border-radius: 50%;
		line-height: 22px;
		height: 80px;
		width: 80px;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		pointer-events: none;
	}


	/* header 3 css  */

	.header-top-inner {
		padding: 10px 0px !important;
	}

	.header-wishlist-div.list-inline {
		display: flex;
		justify-content: space-between;
		margin-bottom: 0;
		margin-right: 15px;
	}

	.header-bottom-inner {
		display: flex;
		flex-wrap: wrap;
		align-items: center;
	}

	.login-div {
		display: flex !important;
	}

	#header-section .container-fluid {
		padding: 0;
	}

	.nav-bottom ul li a {
		font-size: 18px;
		color: var(--blue);
		padding: 32px 10px 32px 10px;
		border-bottom: 6px solid #fff;
		transition: 0.2s;
		display: table;
	}

	.nav-bottom ul li {
		padding: 0;
	}

	.wishlist-img {
		padding-right: 6px;
	}

	.nav-bottom ul li a:hover,
	.nav-bottom ul li a:focus {
		background-color: #e8e8e8;
		color: var(--blue);
		text-decoration: none;
		border-bottom: 6px solid var(--blue);
	}

	.wish-rate:hover,
	.wish-rate:focus {
		background-color: #fff !important;
		color: var(--blue);
		text-decoration: none;
		border-bottom: 6px solid #fff !important;
	}

	.nav-bottom .fa {
		padding: 3px 5px 0 8px;
	}

	.mail-link {
		font-size: 16px;
		line-height: normal;
		color: #fff;
	}

	.login-text .img-responsive {
		margin-right: 8px;
	}

	.header-3-top {
		background: var(--blue);
	}

	.login-text {
		font-size: 16px;
		line-height: normal;
		color: #fff;
		display: flex;
		align-items: center;
	}

	.mail-link:hover,
	.mail-link:focus {
		color: #fff;
		text-decoration: none;
		outline: none;
	}

	.login-text:hover,
	.login-text:focus {
		color: #fff;
		text-decoration: none;
		outline: none;
	}

	.user-icon {
		font-size: 17px;
		padding-right: 6px;
	}

	.login-text:first-child {
		padding: 0 10px;
	}

	.lock-icon {
		font-size: 17px;
		padding-right: 6px;
	}

	.header-bar.list-inline {
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
		margin-bottom: 0;
		align-items: center;
	}

	.fa.fa-envelope-o.mail-icon {
		font-size: 17px;
		padding-right: 5px;
	}

	.architectural-section {
		margin: 50px 0;
	}

	.hardware-common-heading {
		font-size: 30px;
		line-height: normal;
		color: var(--blue);
		text-align: center;
		margin-bottom: 50px;
	}

	.hardware-text {
		font-size: 20px;
		line-height: 24px;
		color: #99989a;
		text-align: center;
		margin: auto;
		display: table;
		width: 70%;
	}

	.hardware-product-text {
		font-size: 20px;
		line-height: normal;
		color: #000;
		text-align: center;
		margin-top: 10px;
		margin-bottom: 4px;
	}

	.arrivals-heading {
		font-size: 30px;
		line-height: normal;
		color: #666666;
		text-align: center;
		margin-top: 10px;
		margin-bottom: 4px;
	}

	.arrivals-img {
		margin: auto;
		display: table;
	}

	.arrivals-first-div {
		background: #ebebeb;
		padding: 80px 20px;
	}

	.arrivals-text {
		font-size: 17px;
		line-height: normal;
		color: #666666;
		text-align: center;
		margin-top: 10px;
		margin-bottom: 4px;
	}

	.hardware-product-div {
		padding: 10px;
		margin: 24px 20px;
		transition: 0.2s;
	}

	.hardware-product-div:hover {
		background-color: #fff;
		box-shadow: 2px 1px 12px rgba(0, 0, 0, 0.5);
	}

	.hardware-product-div:hover .hardware-product-text {
		color: var(--blue);
	}

	.header-3 .header-section {
		padding: 0;
	}

	.header-3 .nav-bottom {
		display: flex;
		align-items: center;
		justify-content: space-between;
		margin-bottom: -3px;
	}

	.common-btn {
		background: var(--blue);
		transition: 0.2s;
		border-radius: 40px;
		color: white;
		border-color: var(--blue);
		padding: 10px 30px;
		font-size: 15px;
		text-transform: capitalize;
	}

	.form-control {
		height: 50px;
		padding: 10px 12px;
		font-size: 16px;
	}

	#searchModal .modal-header {
		background-color: var(--blue);
		color: transparent;
	}

	#searchModal .header-search {
		padding: 20px 0;
	}

	.null-padding {
		padding: 0;
	}

	.breadcrumb {
		padding: 10px 15px;
		margin-bottom: 20px;
		background-color: transparent;
	}

	.header-3 .header-bottom-inner>div {
		width: auto;
	}

	.header-3 .header-bottom-inner {
		justify-content: space-between;
	}

	.padding-zero {
		padding: 0;
	}

	.menu-left-header img {
		cursor: pointer;
	}

	.menu-left-header {
		display: flex;
		align-items: center;
	}

	.parent-service {
		padding-left: 0;
	}

	.icon-bar {
		position: fixed;
		top: 50%;
		-webkit-transform: translateY(-50%);
		-ms-transform: translateY(-50%);
		transform: translateY(-50%);
		right: 0;
		z-index: 99;
	}

	.icon-bar a {
		display: block;
		text-align: center;
		padding: 16px;
		transition: all 0.3s ease;
		color: white;
		font-size: 20px;
	}

	.icon-bar a:hover {
		background-color: var(--blue);
	}

	.facebook {
		background: var(--blue);
		color: white;
	}

	.twitter {
		background: var(--blue);
		color: white;
	}

	.pinterest {
		background: var(--blue);
		color: white;
	}

	.linkedin {
		background: var(--blue);
		color: white;
	}

	.instagram {
		background: var(--blue);
		color: white;
	}

	.footer-3-inner-div {
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
	}

	.slider-content-main-div-tag {
		display: block;
		text-align: center;
	}

	.hardware-product-div {
		padding: 15px;
		margin: 0px;
		transition: 0.2s;
	}

	.hardware-product-div:hover .hardware-product-text {
		color: var(--blue);
		text-decoration: none;
		outline: none;
	}

	.top-page-path-outer .top-page-path-itself .path-color {
		color: var(--blue);
	}

	.top-page-path-outer .top-page-path-itself {
		font-size: 17px;
	}

	.consort-video-div video {
		max-width: 100%;
	}

	#project-consort-list-div .item {
		padding-right: 10px;
	}

	#project-consort-list-div video {
		max-width: 100%;
		padding: 0 0px 0 10px;
	}

	#project-consort-list-div video:first-child {
		padding-left: 0;
	}

	#consort-project-div {
		margin-bottom: 4px;
	}

	.hardware-consort-heading {
		font-size: 30px;
		line-height: normal;
		color: var(--blue);
		margin-bottom: 60px;
	}


	/* .project-detail-section {
    display: flex;
    flex-wrap: wrap;
} */

	.project-detail-inner-text {
		background: #efefef;
		position: relative;
		padding: 40px 50px 20px 50px;
	}

	.project-detail-inner-text::after {
		content: "";
		display: table;
		background: #efefef;
		height: 22px;
		width: 22px;
		position: absolute;
		top: 50%;
		left: 0px;
		z-index: 1;
		transform: translateX(-50%) rotate(45deg);
	}

	.consort-media-div {
		width: auto;
	}

	.consort-slider-div {
		margin-top: 70px;
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
	}

	.item.consort-video-div video {
		width: 100%;
	}

	.media-name {
		font-size: 15px;
		line-height: normal;
		color: #000;
	}

	.project-detail-inner-div {
		display: flex;
		flex-wrap: wrap;
	}

	.contrast-div {
		margin-top: 30px;
	}

	.project-text-div {
		font-size: 17px;
		line-height: normal;
		color: #000;
		margin-bottom: 0;
	}

	.product-desc-inner-div p {
		font-size: 17px;
		color: #000;
		line-height: normal;
		margin-bottom: 20px;
	}

	.product-desc-inner-div {
		margin-top: 20px;
	}

	.read-more-btn {
		font-size: 17px;
		line-height: normal;
		color: var(--blue);
		float: right;
	}

	.read-more-btn:hover,
	.read-more-btn:focus {
		text-decoration: none;
		color: var(--blue);
		outline: none;
		border-bottom: 1px solid var(--blue);
	}

	.containerContact {
		display: table;
		position: relative;
		padding-left: 35px;
		margin-bottom: 12px;
		cursor: pointer;
		font-size: 15px;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}


	/* Hide the browser's default checkbox */

	.containerContact input {
		position: absolute;
		opacity: 0;
		cursor: pointer;
		height: 0;
		width: 0;
	}


	/* Create a custom checkbox */

	.containerContact .checkmark {
		position: absolute;
		top: 0;
		left: 0;
		height: 25px;
		width: 25px;
		background-color: #eee;
	}


	/* On mouse-over, add a grey background color */

	.containerContact:hover input~.checkmark {
		background-color: #ccc;
	}


	/* When the checkbox is checked, add a blue background */

	.containerContact input:checked~.checkmark {
		background-color: var(--blue);
	}


	/* Create the checkmark/indicator (hidden when not checked) */

	.containerContact .checkmark:after {
		content: "";
		position: absolute;
		display: none;
	}


	/* Show the checkmark when checked */

	.containerContact input:checked~.checkmark:after {
		display: block;
	}


	/* Style the checkmark/indicator */

	.containerContact .checkmark:after {
		left: 9px;
		top: 5px;
		width: 5px;
		height: 10px;
		border: solid white;
		border-width: 0 3px 3px 0;
		-webkit-transform: rotate(45deg);
		-ms-transform: rotate(45deg);
		transform: rotate(45deg);
	}

	#logInPop .modal-header {
		background-color: var(--blue);
		color: transparent;
	}

	#logInPop .modal-header h4 {
		color: transparent;
	}

	.product-to-view {
		text-align: center;
		font-size: 25px;
	}

	.already-view {
		text-align: center;
		font-size: 20px;
		margin-top: 10px;
		margin-bottom: 20px;
		color: #88898a;
	}

	.register-pop-link,
	.login-pop-link {
		color: var(--blue);
		font-weight: bold;
	}

	#logInPop .modal-header .close {
		margin-top: -2px;
		opacity: 1;
		color: white;
		font-size: 22px;
		font-weight: lighter;
	}

	.main-pop-up-div {
		padding: 40px 0 40px 0;
	}

	.catmenu-menu {
		position: absolute;
		top: 100%;
		left: 0;
		padding: 22px 10px 20px 10px;
		background: var(--blue);
		box-shadow: -1px 3px 32px -1px rgba(0, 0, 0, 0.27);
		border-radius: 10px;
		transform-origin: top;
		transform: scaleY(0);
		transition: 0.2s;
		z-index: 2;
	}

	.dropdown:hover .catmenu-menu {
		transform: scaleY(1);
	}

	.catmenu-menu .jk {
		margin: 0;
		min-width: 270px;
		list-style: none;
		transition: 0.2s;
	}

	.catmenu-menu .jk a {
		display: block;
		padding: 8px 10px 8px 10px;
		transition: 0.2s;
		color: white !important;
	}

	.catmenu-menu .jk a:hover {
		color: var(--blue) !important;
	}

	.iconhover::after {
		content: '\f078';
		position: absolute;
		right: 8px;
		top: 50%;
		font-family: FontAwesome;
		color: black;
		transform: translatey(-50%);
	}

	.iconhover>a {
		padding-right: 30px !important;
	}

	.no-product-found {
		text-align: center;
		width: 100%;
		font-size: 35px;
		text-transform: capitalize;
		color: var(--blue);
		margin: 100px 0 150px 0;
	}

	#testimonals {
		background-image: url('../images/testimonials.jpg');
		background-repeat: no-repeat;
		background-size: 100% 100%;
		padding: 100.5px 0;
		color: white;
		text-align: center;
		margin-top: 100px;
	}

	.beauty-of-wood-title {
		font-size: 30px;
	}

	.testimonials-text {
		font-size: 17px;
		line-height: 30px;
	}

	.testimonials-quorts-img .img-responsive {
		margin: 10px auto 30px;
	}

	.text-qort-name {
		font-size: 20px;
	}

	.text-qort-name-address {
		line-height: 30px;
		font-size: 17px;
	}

	.test-qourt-line span {
		display: table;
		width: 160px;
		height: 4px;
		background-color: white;
		margin: 15px auto 15px;
	}

	.certification-img .img-responsive {
		width: auto !important;
	}

	.certification-img {
		width: auto;
	}

	.brand-list-sec {
		display: flex;
		justify-content: center;
		align-items: center;
		flex-wrap: wrap;
	}

	#certification {
		margin: 50px 0;
	}

	.slider-content-main-div-content p {
		font-size: 20px;
		color: black;
		transition: 0.2s;
	}

	.slider-content-main-div-tag:hover .slider-content-main-div-content p {
		color: var(--blue);
	}

	.projects-slider-item {
		padding: 0;
		display: flex;
		flex-wrap: wrap;
	}

	.projects-slider-item-left {
		padding: 0;
	}

	.projects-slider-item-right {
		background-color: #99989a;
		padding: 40px 40px;
		color: white;
	}

	.projects-slider-heading {
		font-size: 30px;
	}

	.slider-content-main-div-content-left {
		font-size: 17px;
	}

	.projects-slider-heading-disc {
		margin: 30px 0;
	}

	.con-title-1 {
		margin-bottom: 30px;
	}

	.common-banner-text-div {
		display: none;
	}

	.my_page_grid {
		padding: 0;
	}

	.prject-category-title {
		font-size: 20px;
		margin-bottom: 50px;
		color: var(--blue);
		border-bottom: 1px solid lightgray;
		padding-bottom: 20px;
	}

	.projectSlider {
		margin-bottom: 80px;
		width: calc(100% + 30px);
		margin-left: -15px;
	}

	.project-title {
		text-align: center;
		font-size: 20px;
		margin-top: 15px;
	}

	.slider-main-div {
		padding: 0;
	}

	.projects-slider-item-inner {
		display: flex;
		width: 100%;
		flex-wrap: wrap;
	}

	.product-desc-inner-div p {
		font-size: 17px;
		color: #000;
		line-height: normal;
		margin-bottom: 20px;
	}

	.product-desc-inner-div {
		margin-top: 20px;
	}

	.breadcrumb.about_page>li+li::before {
		padding: 0 5px;
		color: black;
		content: "\f101";
		font-family: FontAwesome;
		font-size: 16px;
	}

	.breadcrumb.about_page>li a {
		color: black;
	}

	.breadcrumb.about_page>li.active a {
		color: var(--blue);
	}

	.product-description {
		margin-top: 100px;
	}

	#category-slider {
		padding: 0;
		width: calc(100% + 40px);
		margin-left: -20px;
	}

	#bredcrumbs {
		margin-top: 10px;
	}

	#project-detail-section {
		margin-top: 30px;
	}


	/* product detail page css  */

	#product-detail-slider .owl-nav .owl-prev {
		position: absolute;
		top: 50%;
		left: 2%;
		transform: translatey(-50%);
	}

	#product-detail-slider .owl-nav .owl-prev span {
		background-image: url(../images/l.png);
		background-repeat: no-repeat;
		font-size: 0;
		height: 40px;
		width: 20px;
		display: table;
	}

	#product-detail-slider .owl-nav .owl-next {
		position: absolute;
		top: 50%;
		right: 2%;
		transform: translatey(-50%);
	}

	#product-detail-slider .owl-nav .owl-next span {
		background-image: url(../images/r.png);
		background-repeat: no-repeat;
		font-size: 0;
		height: 40px;
		width: 22px;
		display: table;
	}

	#product-detail-slider .owl-nav .owl-prev:focus,
	#product-detail-slider .owl-nav .owl-prev:hover {
		background: transparent;
		color: #FFF;
		text-decoration: none;
		outline: none;
	}

	#product-detail-slider .owl-nav .owl-next:focus,
	#product-detail-slider .owl-nav .owl-next:hover {
		background: transparent;
		color: #FFF;
		text-decoration: none;
		outline: none;
	}

	#product-detail-section {
		margin-top: 60px;
	}

	.product-inner-text-div {
		padding-left: 60px;
	}

	.product-desc-div ul li {
		font-size: 18px;
		line-height: normal;
		color: #000;
		background-image: url(../images/color-dots.png);
		background-repeat: no-repeat;
		background-position: left center;
		list-style-type: none;
		padding-left: 25px;
		margin-bottom: 6px;
	}

	.dimension-main-img-div {
		margin-top: 40px;
	}

	.product-desc-div ul {
		padding-left: 4px;
		margin-top: 10px;
		padding-bottom: 25px;
		border-bottom: 2px solid lightgray;
		margin-bottom: 25px;
	}

	.wishlist-btn {
		font-size: 17px;
		line-height: normal;
		color: var(--blue);
		border: 1px solid #000;
		padding: 12px 25px;
		display: table;
		border-radius: 30px;
	}

	.wishlist-btn:hover,
	.wishlist-btn:focus {
		text-decoration: none;
		outline: none;
		color: #fff;
		background: var(--blue);
	}

	.pdf-main-div {
		width: auto;
	}

	.pdf-main-div {
		display: flex;
		flex-wrap: wrap;
		align-items: center;
	}

	.download-text {
		font-size: 18px;
		line-height: normal;
		color: #000;
		width: 120px;
		padding-left: 10px;
		margin-bottom: 0;
	}

	.pdf-link-div {
		margin-top: 30px;
	}

	.product-desc-div ul li ul li {
		list-style-type: none;
		background-image: none;
		padding-left: 7px;
		margin-bottom: 0;
	}

	.product-desc-div ul li ul {
		padding: 0;
		border-bottom: 0;
		margin-bottom: 0;
		display: flex;
		flex-wrap: wrap;
	}

	.product-desc-div ul li ul li span {
		margin-left: 4px;
	}

	.product-desc-div ul li ul li {
		list-style-type: none;
		background-image: none;
		display: flex;
		align-items: center;
	}

	.hardware-consort-heading.product-heading {
		margin-bottom: 8px;
	}

	#category-slider .owl-stage-outer {
		padding: 40px 20px;
	}

	#architectural-section .hardware-consort-heading {
		margin-bottom: 0;
	}

	.latest-project-heading {
		font-size: 30px;
		text-align: center;
		margin-bottom: 30px;
		color: var(--blue);
	}

	#cart_section .common-heading-col {
		padding: 0;
	}

	.arrow-heading {
		font-size: 25px;
		margin-bottom: 30px;
	}

	.product_main_div {
		margin: 20px 0;
	}

	#cart_section {
		margin-bottom: 70px;
	}

	#common-banner-section .common-inner-div img {
		margin: auto;
	}

	.common-inner-div {
		background-color: #e7e8ed;
	}

	.category-title {
		font-size: 30px;
		text-align: center;
		width: 100%;
		color: var(--blue);
		margin-bottom: 40px;
	}

	.single-category-col {
		text-align: center;
		padding: 15px;
		transition: 0.2s;
	}

	.single-category-heading {
		font-size: 20px;
		color: #000000;
		margin-top: 10px;
	}

	.single-category-col-img-col .img-responsive {
		width: 100%;
	}

	.hardware-product-div:hover,
	#you-may-like-product .product-listing-item-div:hover,
	#product-listing-section .product-listing-item-div:hover,
	#category-list .single-category-col:hover {
		box-shadow: -1px 3px 14px -1px rgba(0, 0, 0, 0.27);
		-webkit-box-shadow: -1px 3px 14px -1px rgba(0, 0, 0, 0.27);
		-moz-box-shadow: -1px 3px 14px -1px rgba(0, 0, 0, 0.27);
	}

	.category-listing-inner-col {
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		margin-bottom: 40px;
	}

	.product-listing-section {
		padding: 0;
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
	}

	#product-listing-section .product-listing-item-div {
		text-align: center;
		transition: 0.2s;
		padding: 15px;
		margin-bottom: 40px;
	}

	.product-listing-a {
		font-size: 20px;
		padding-top: 20px;
		display: table;
		width: 100%;
		color: var(--blue);
	}

	.product-listing-a:hover {
		color: var(--blue);
	}

	.hardware-consort-heading-description {
		font-size: 30px;
		color: var(--blue);
	}

	.boder-under-name {
		border-bottom: 1px solid #acacac;
		padding-bottom: 30px;
	}

	#you-may-like-product .product-listing-item-div {
		text-align: center;
		padding: 15px;
		transition: 0.2s;
	}

	#you-may-like-product {
		padding: 0;
		width: calc(100% + 30px);
		margin-left: -15px;
	}

	#you-may-like-product .owl-stage-outer {
		padding: 20px;
	}

	#you-may-also-like-product .hardware-consort-heading {
		margin-bottom: 40px;
	}


	/* contact-us page */

	#contact-parent-div {
		margin: 40px 0 40px 0;
	}

	.iframe_main img {
		width: 100%;
	}

	.contact-div {
		box-shadow: 2px 3px 5px 2px rgba(0, 0, 0, .1);
		padding: 10px;
		display: flex;
		flex-wrap: wrap;
		align-items: center;
		height: 200px;
	}

	.simple_div.form-control {
		font-size: 14px;
		color: #000;
		margin-bottom: 10px;
	}

	.send-div {
		border: 1px solid var(--blue);
		color: #fff;
		padding: 8px 10px 8px 10px;
		border-radius: 7px;
		display: table;
		font-size: 14px;
		line-height: normal;
		transition: 0.3s;
		background-color: var(--blue);
	}

	.send-div:hover,
	.send-div:focus {
		color: #fff;
		text-decoration: none;
		outline: none;
	}

	#contact-iframe-section {
		margin-bottom: 100px;
	}

	::placeholder {
		color: #000;
	}

	.con-tel {
		color: #000;
		font-size: 30px;
		line-height: normal;
	}

	.cust-text {
		text-transform: capitalize;
		font-size: 18px;
		line-height: normal;
		color: #333;
		margin-bottom: 16px;
	}

	.email-text {
		font-size: 14px;
		width: 210px;
		line-height: normal;
		margin-bottom: 15px;
	}

	.contact-inner-div {
		padding: 0;
		width: calc(100% + 12px);
		margin-right: -12px;
	}

	.head-contact {
		padding: 0 6px;
	}

	.hard-inner {
		box-shadow: 2px 3px 5px 2px rgba(0, 0, 0, .1);
		border-radius: 8px;
		padding: 25px 20px 40px 20px;
		margin-bottom: 90px;
	}

	.hard-head {
		font-size: 14px;
		line-height: normal;
		color: #000;
		margin-bottom: 0;
	}

	.con-hard-main-div {
		padding: 0;
		width: calc(100% + 30px);
		margin-left: -15px;
	}

	#conhardware-section {
		margin-bottom: 30px;
	}

	.hard-text {
		font-size: 14px;
		line-height: normal;
		color: #666666;
		margin-bottom: 0;
	}

	.hard-link {
		color: #666666;
		transition: 0.3s;
	}

	.hard-link:hover {
		text-decoration: none;
		color: #000;
		outline: none;
	}

	.hard-link.link-mail {
		color: var(--blue);
		transition: 0.2s;
	}

	.hard-link.link-mail:focus,
	.hard-link.link-mail:hover {
		color: var(--blue);
		text-decoration: none;
		outline: none;
	}

	.trade-text {
		margin: 6px 0 30px 0;
	}

	.hard-link:focus {
		color: #000;
		text-decoration: none;
		outline: none;
	}


	/* form-css */

	.form-inner-div ul {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.form-inner-div li {
		display: block;
		padding: 9px;
		border: 1px solid #DDDDDD;
		margin-bottom: 30px;
		border-radius: 3px;
	}

	.form-inner-div li:last-child {
		border: none;
		margin-bottom: 0px;
		text-align: center;
	}

	.form-inner-div li>label {
		display: block;
		float: left;
		/* margin-top: -19px; */
		background: #FFFFFF;
		height: 30px;
		padding: 2px 5px 2px 5px;
		color: #000;
		font-size: 20px;
		overflow: hidden;
	}

	.simple-div {
		margin-bottom: 15px;
	}

	.form-inner-main-div {
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
		padding: 0;
	}

	.form-inner-div input[type="text"],
	.form-inner-div input[type="email"],
	.form-inner-div input[type="number"],
	.form-inner-div textarea {
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		width: 100%;
		display: block;
		outline: none;
		border: none;
		height: 35px;
		line-height: 25px;
		font-size: 18px;
		padding: 0;
		border-bottom: 1px solid lightgray;
		padding-left: 6px;
	}

	.form-inner-div li>span {
		background: #F3F3F3;
		display: block;
		padding: 3px;
		margin: 0 -9px -9px -9px;
		text-align: center;
		color: #C0C0C0;
		font-size: 11px;
	}

	.form-inner-div textarea {
		resize: none;
	}

	.form-inner-div input[type="submit"],
	.form-inner-div input[type="button"] {
		background: #2471FF;
		border: none;
		padding: 10px 20px 10px 20px;
		border-bottom: 3px solid #5994FF;
		border-radius: 3px;
		color: #D2E2FF;
	}

	.form-inner-div input[type="submit"]:hover,
	.form-inner-div input[type="button"]:hover {
		background: #6B9FFF;
		color: #fff;
	}

	.hard-form-heading {
		font-size: 60px;
		line-height: normal;
		text-transform: uppercase;
		color: #000;
		margin-bottom: 60px;
		padding: 0 10px;
	}

	.form-inner-div {
		padding: 0;
	}

	.simple-div,
	.message_div {
		padding: 0;
	}

	.send_div {
		border: 1px solid var(--blue);
		color: #fff;
		padding: 12px 45px 12px 45px;
		display: table;
		text-transform: uppercase;
		text-align: center;
		font-size: 20px;
		line-height: normal;
		border-radius: 10px;
		background: var(--blue);
		transition: 0.3s;
	}

	.send-submit-div {
		padding: 0;
		margin: 10px 0 15px 0;
	}

	.message_div {
		margin-bottom: 10px;
	}

	.send_div:hover,
	.send_div:focus {
		color: #fff;
		text-decoration: none;
		outline: none;
	}

	.iframe_main iframe {
		width: 100%;
	}

	.list-inner.col-xs-12.col-sm-9 {
		padding-right: 20px;
	}

	#form-section {
		margin-bottom: 60px;
	}

	.arrivals-heading {
		font-size: 30px;
		line-height: normal;
		color: #666666;
		text-align: center;
		margin-top: 10px;
		margin-bottom: 20px;
	}

	.arrivals-img {
		margin: auto;
		display: table;
	}

	.arrivals-first-div {
		padding: 80px 20px;
	}

	.arrivals-text {
		font-size: 17px;
		line-height: normal;
		color: #99989a;
		text-align: center;
		margin-top: 10px;
		margin-bottom: 4px;
	}

	#arrivals-section {
		margin-bottom: 50px;
	}

	.hardware-common-heading {
		font-size: 30px;
		line-height: normal;
		color: #1e204d;
		text-align: center;
		margin-bottom: 40px;
	}

	.arrivals-inner-main {
		background: #ebebeb;
		padding: 60px 35px;
	}

	.arrivals-second-div {
		padding-right: 0;
	}

	.arrivals-second-div p {
		text-align: left;
	}

	.arrivals-inner-main {
		margin-bottom: 0px;
		display: flex;
		flex-wrap: wrap;
		align-items: center;
	}

	.arrrivals-inner-div .arrivals-main-div a {
		display: inline-block;
		width: 100%;
		overflow: hidden;
	}

	.arrivals-second-div a:first-child {
		margin-bottom: 0;
	}

	.arrivals-second-div a {
		display: inline-block;
		width: 100%;
		overflow: hidden;
	}

	.arrivals-second-div {
		padding-left: 50px;
	}

	.arrrivals-inner-div {
		display: flex;
	}

	.consort-news-div {
		font-size: 18px;
		line-height: normal;
		color: #fff;
		margin-bottom: 0;
	}

	.arrivals-main-div {
		background: #ebebeb;
		transition: 0.2s;
	}

	.consort-offer-div {
		position: absolute;
		top: -10px;
		left: -66px;
		transform: rotate(-40deg);
		background: #666;
		padding: 16px 16px 5px 16px;
		width: 172px;
		height: 60px;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.arrivals-main-div a {
		position: relative;
	}

	.arrivals-second-div a {
		position: relative;
	}

	.arrrivals-inner-div a:hover .consort-offer-div {
		background-color: #060e9f;
	}

	.arrrivals-inner-div .arrivals-main-div:hover {
		background-color: #fff;
		box-shadow: 2px 3px 5px 2px rgba(0, 0, 0, .1);
	}

	.arrivals-second-div a:hover .arrivals-inner-main {
		background: #fff;
		box-shadow: 2px 3px 5px 2px rgba(0, 0, 0, .1);
	}

	.arrivals-second-div a:hover .arrivals-inner-main .arrivals-heading {
		color: #060e9f;
	}

	.arrivals-second-div a:hover {
		box-shadow: 2px 3px 5px 2px rgba(0, 0, 0, .1);
	}

	.arrrivals-inner-div .arrivals-main-div:hover .arrivals-heading {
		color: #060e9f;
	}

	.arrivals-second-div a:first-child {
		margin-bottom: 50px;
	}

	#arrivals-section {
		pointer-events: none;
	}
</style>