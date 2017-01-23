				<div class="col-md-5">
					<small><small><center><?php
						debug_to_console("State is ".$state);
						if ($state == null) {
							echo "Zip Code not found, So here are three random pictures from my local area. Enjoy"; 
						}else {
							echo "Pictures from ".$county1.". Pulled from Flickr"; } ?>
					</center></small></small>
					<div class="carousel slide" id="carousel-<?php echo $id_type; ?>">
						<ol class="carousel-indicators">
							<li class="active" data-slide-to="0" data-target="#carousel-<?php echo $id_type; ?>">
							</li>
							<li data-slide-to="1" data-target="#carousel-<?php echo $id_type; ?>">
							</li>
							<li data-slide-to="2" data-target="#carousel-<?php echo $id_type; ?>">
							</li>
						</ol>
						<div class="carousel-inner">
							<div class="item active">
								<img alt="Carousel Bootstrap First" src="<?php echo $picture1; ?>" />
								<div class="carousel-caption">
									<p>
										<?php echo $title1; ?>
									</p> 
								</div>
							</div>
							<div class="item">
								<img alt="Carousel Bootstrap Second" src="<?php echo $picture2; ?>" />
								<div class="carousel-caption">
									<p>
										<?php echo $title2; ?>
									</p>
								</div>
							</div>
							<div class="item">
								<img alt="Carousel Bootstrap Third" src="<?php echo $picture3; ?>" />
								<div class="carousel-caption">
									<p>
										<?php echo $title3; ?>
									</p>
								</div>
							</div>
						</div> <a class="left carousel-control" href="#carousel-<?php echo $id_type; ?>" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-<?php echo $id_type; ?>" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
					</div>
				</div>
			</div>