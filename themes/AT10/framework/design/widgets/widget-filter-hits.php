<?php
/* 
* Theme: TURBOBID CORE FRAMEWORK FILE
* Url: www.turbobid.ca
* Author: Md Nuralam
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $CORE;  ?>


	<div class="card card-filter">
		<div class="card-body">
			<a href="#" data-toggle="collapse" data-target="#collapse_hits" aria-expanded="true" class="">
				 
				<h5 class="card-title">Listing Views</h5>
			</a>
		 
		<div class="filter-content collapse show" id="collapse_hits">
		 
				<input type="range" class="custom-range" min="0" max="100" name="">
				<div class="form-row">
				<div class="form-group col-md-6">
				  <label>Min</label>
				  <input class="form-control" placeholder="$0" type="min">
				</div>
				<div class="form-group text-right col-md-6">
				  <label>Max</label>
				  <input class="form-control" placeholder="$1,0000" type="max">
				</div>
				</div> 
				<button class="btn btn-block btn-primary">Apply</button>
			</div> 
            
		</div>
</div>